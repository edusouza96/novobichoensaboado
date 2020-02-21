<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\TypeMovesType;
use BichoEnsaboado\Enums\PaymentMethodsType;
use BichoEnsaboado\Enums\CostCenterSystemType;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\OutlayRepository;
use BichoEnsaboado\Repositories\CashBookRepository;
use BichoEnsaboado\Repositories\TreasureRepository;
use BichoEnsaboado\Repositories\CashBookMoveRepository;

class CashdeskService
{
    private $cashBookRepository;
    private $cashBookMoveRepository;
    private $outlayRepository;
    private $treasureRepository;
    private $saleRepository;

    public function __construct(
        CashBookRepository $cashBookRepository, 
        CashBookMoveRepository $cashBookMoveRepository, 
        OutlayRepository $outlayRepository,
        TreasureRepository $treasureRepository,
        SaleRepository $saleRepository
    ) {
        $this->cashBookRepository = $cashBookRepository;
        $this->cashBookMoveRepository = $cashBookMoveRepository;
        $this->outlayRepository = $outlayRepository;
        $this->treasureRepository = $treasureRepository;
        $this->saleRepository = $saleRepository;
    }

    public function open(array $attributes, User $userLogged, $store)
    {
        $openWithoutNewContribute = $attributes['openWithoutNewContribute'];
        $dateHour = Carbon::now();

        $treasure = $this->treasureRepository->getCashDrawer($store);
        if($openWithoutNewContribute == 'true'){
            $cashBook = $this->cashBookRepository->save($treasure->getValue(), null, $dateHour, $userLogged, $store);
            return $treasure;
        }

        $valueStart = $attributes['valueStart'];
        $source = $attributes['source'];
        $cashBook = $this->cashBookRepository->save($valueStart+$treasure->getValue(), null, $dateHour, $userLogged, $store);
        $moves = $this->cashBookMoveRepository->save($valueStart, SourceType::CASH_DRAWER, TypeMovesType::ENTRY, $cashBook, $userLogged);
        $outlay = $this->outlayRepository->save('Aporte - caixa inicial', $valueStart, $dateHour, $source, CostCenterSystemType::COST_CENTER_APORTE, $moves, $paid=true, $userLogged, $store);
        $treasure = $this->treasureRepository->subValue($valueStart, SourceType::getName($source), $store);
        return $this->treasureRepository->addValue($valueStart, SourceType::CASH_DRAWER_NAME, $store);
    }

    public function close(array $attributes, User $userLogged, $store)
    {
        $valueWithdraw = $attributes['valueWithdraw'];
        $source = $attributes['source'];
        $closingDate = Carbon::createFromFormat('Y-m-d', $attributes['closingDate']);

        $cashBook = $this->cashBookRepository->findByDate($closingDate, $store);
        if(!$cashBook) throw new \Exception("Caixa não aberto para o dia ".$closingDate->format('d/m/Y'));
        
        $treasure = $this->treasureRepository->addValue($valueWithdraw, SourceType::getName($source), $store);
        $treasure = $this->treasureRepository->subValue($valueWithdraw, SourceType::CASH_DRAWER_NAME, $store);
        $cashDrawer = $treasure->getValue() + $valueWithdraw;

        $cashBook = $this->cashBookRepository->updateValueEnd($cashBook, $cashDrawer, $userLogged, $store);
        return $treasure;
    }
    public function contribute(array $attributes, User $userLogged, $store)
    {
        $source = $attributes['source'];
        $valueContribute = $attributes['valueContribute'];
        $cashBook = $this->cashBookRepository->getLast($store);
        
        $outlay = $this->outlayRepository->save('Aporte', $valueContribute, Carbon::now(), $source, CostCenterSystemType::COST_CENTER_APORTE_CAIXA_INICIAL, $paid=true, $userLogged, $store);
        $treasure = $this->treasureRepository->subValue($valueContribute, SourceType::getName($source), $store);
        $treasure = $this->treasureRepository->addValue($valueContribute, SourceType::CASH_DRAWER_NAME, $store);

        return $treasure;
    }
    public function bleed(array $attributes, User $userLogged, $store)
    {
        $source = $attributes['source'];
        $valueWithdraw = $attributes['valueWithdraw'];
        $observation = $attributes['observation'];
        
        $outlay = $this->outlayRepository->save($observation, $valueWithdraw, Carbon::now(), SourceType::CASH_DRAWER, CostCenterSystemType::COST_CENTER_SANGRIA, $paid=true, $userLogged, $store);
        $treasure = $this->treasureRepository->addValue($valueWithdraw, SourceType::getName($source), $store);
        $treasure = $this->treasureRepository->subValue($valueWithdraw, SourceType::CASH_DRAWER_NAME, $store);

        return $treasure;
    }
    public function moneyTransfer(array $attributes, User $userLogged, $store)
    {
        $origin = $attributes['origin'];
        $destiny = $attributes['destiny'];
        $value = $attributes['value'];

        $treasure = $this->treasureRepository->subValue($value, SourceType::getName($origin), $store);
        $treasure = $this->treasureRepository->addValue($value, SourceType::getName($destiny), $store);

        return $treasure;
    }

    public function status($store)
    {
        return $this->cashBookRepository->findByDate(Carbon::now(), $store);

    }

    public function getCashDrawer($store)
    {
        return $this->treasureRepository->getCashDrawer($store);
    }

    public function inconsistencyUnfinishedCashdesk($store)
    {
        return $this->cashBookRepository->getUnfinishedCashdesk($store);
    }

    public function extractOfDay(Carbon $date, $store)
    {
        $cashBook = $this->cashBookRepository->findByDate($date, $store, true);
        if(!$cashBook) throw new \Exception("Não foi aberto o caixa");
        
        $moves = $cashBook->getMoves();
        $outlays = $this->getValueTotal($moves, TypeMovesType::OUT);
        $sales = $this->getValueTotalSalesByDate($date, $store);
        $contribute = $this->getValutTotalContribute($date, $store);
        $bleed = $this->getValutTotalBleed($date, $store);

        return [
            'sales' => $sales,
            'outlays' => $outlays,
            'value_start' => $cashBook->getValueStart(),
            'value_end' => $cashBook->getValueEnd(),
            'contribute' => $contribute,
            'bleed' => $bleed,
        ];
    }

    private function getValueTotal(Collection $moves, $type)
    {
        return $moves->where('type', $type)
            ->groupBy('source_id')
            ->map(function($move){ 
                return [
                    'value' => $move->sum('value'),
                    'method' => SourceType::getDisplay($move->first()->getSource())
                ];
            });
    }
    private function getValueTotalSalesByDate(Carbon $date, $store)
    {
        return $this->saleRepository
            ->findByDate($date , $store)
            ->groupBy('payment_method_id')
            ->map(function($saleGroup){ 
                return [
                    'value' => $saleGroup->sum('total') - $saleGroup->sum('rebate'),
                    'method' => PaymentMethodsType::getName($saleGroup->first()->getPaymentMethodId())
                ];
            });
    }

    private function getValutTotalContribute(Carbon $date, $store)
    {
        return $this->outlayRepository
            ->getContributesByDate($date, $store)
            ->sum('value');
    }
    
    private function getValutTotalBleed(Carbon $date, $store)
    {
        return $this->outlayRepository
            ->getBleedByDate($date, $store)
            ->sum('value');
    }
}