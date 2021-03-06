<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\TypeMovesType;
use BichoEnsaboado\Enums\PaymentMethodsType;
use BichoEnsaboado\Enums\CostCenterSystemType;
use BichoEnsaboado\Models\CashBook;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\OutlayRepository;
use BichoEnsaboado\Repositories\CashBookRepository;
use BichoEnsaboado\Repositories\TreasureRepository;
use BichoEnsaboado\Repositories\CashBookMoveRepository;
use BichoEnsaboado\Repositories\SalePaymentMethodRepository;
use BichoEnsaboado\Repositories\TransferRepository;

class CashdeskService
{
    private $cashBookRepository;
    private $cashBookMoveRepository;
    private $outlayRepository;
    private $treasureRepository;
    private $saleRepository;
    private $salePaymentMethodRepository;
    private $transferRepository;

    public function __construct(
        CashBookRepository $cashBookRepository, 
        CashBookMoveRepository $cashBookMoveRepository, 
        OutlayRepository $outlayRepository,
        TreasureRepository $treasureRepository,
        SaleRepository $saleRepository,
        SalePaymentMethodRepository $salePaymentMethodRepository,
        TransferRepository $transferRepository
    ) {
        $this->cashBookRepository = $cashBookRepository;
        $this->cashBookMoveRepository = $cashBookMoveRepository;
        $this->outlayRepository = $outlayRepository;
        $this->treasureRepository = $treasureRepository;
        $this->saleRepository = $saleRepository;
        $this->salePaymentMethodRepository = $salePaymentMethodRepository;
        $this->transferRepository = $transferRepository;
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
        $cashBook = $this->cashBookRepository->save($treasure->getValue(), null, $dateHour, $userLogged, $store);
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
        
        $treasureDestiny = $this->treasureRepository->addValue($valueWithdraw, SourceType::getName($source), $store);
        $treasureOrigin = $this->treasureRepository->subValue($valueWithdraw, SourceType::CASH_DRAWER_NAME, $store);

        $this->transferRepository->create($cashBook, $treasureOrigin, $treasureDestiny, $valueWithdraw, $userLogged);
        
        $cashDrawer = $treasureOrigin->getValue() + $valueWithdraw;

        $cashBook = $this->cashBookRepository->updateValueEnd($cashBook, $cashDrawer, $userLogged, $store);
        return $treasureOrigin;
    }
    public function contribute(array $attributes, User $userLogged, $store)
    {
        $source = $attributes['source'];
        $valueContribute = $attributes['valueContribute'];
        
        $cashBook = $this->cashBookRepository->getLast($store);
        $movesEntry = $this->cashBookMoveRepository->save($valueContribute, SourceType::CASH_DRAWER, TypeMovesType::ENTRY, $cashBook, $userLogged);
        $movesOut = $this->cashBookMoveRepository->save($valueContribute, $source, TypeMovesType::OUT, $cashBook, $userLogged);


        $outlay = $this->outlayRepository->save('Aporte', $valueContribute, Carbon::now(), $source, CostCenterSystemType::COST_CENTER_APORTE_CAIXA_INICIAL, $movesOut, $paid=true, $userLogged, $store);
        $treasure = $this->treasureRepository->subValue($valueContribute, SourceType::getName($source), $store);
        $treasure = $this->treasureRepository->addValue($valueContribute, SourceType::CASH_DRAWER_NAME, $store);

        return $treasure;
    }
    public function bleed(array $attributes, User $userLogged, $store)
    {
        $source = $attributes['source'];
        $valueWithdraw = $attributes['valueWithdraw'];
        $observation = $attributes['observation'];

        $cashBook = $this->cashBookRepository->getLast($store);
        $movesEntry = $this->cashBookMoveRepository->save($valueWithdraw, $source, TypeMovesType::ENTRY, $cashBook, $userLogged);
        $movesOut = $this->cashBookMoveRepository->save($valueWithdraw, SourceType::CASH_DRAWER, TypeMovesType::OUT, $cashBook, $userLogged);
        
        $outlay = $this->outlayRepository->save($observation, $valueWithdraw, Carbon::now(), SourceType::CASH_DRAWER, CostCenterSystemType::COST_CENTER_SANGRIA, $movesOut, $paid=true, $userLogged, $store);
        $treasure = $this->treasureRepository->addValue($valueWithdraw, SourceType::getName($source), $store);
        $treasure = $this->treasureRepository->subValue($valueWithdraw, SourceType::CASH_DRAWER_NAME, $store);

        return $treasure;
    }
    public function moneyTransfer(array $attributes, User $userLogged, $store)
    {
        $origin = $attributes['origin'];
        $destiny = $attributes['destiny'];
        $value = $attributes['value'];

        $treasureOrigin = $this->treasureRepository->subValue($value, SourceType::getName($origin), $store);
        $treasureDestiny = $this->treasureRepository->addValue($value, SourceType::getName($destiny), $store);

        $cashBook = $this->cashBookRepository->getLast($store);

        $this->transferRepository->create($cashBook, $treasureOrigin, $treasureDestiny, $value, $userLogged);

        return $treasureDestiny;
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
        
        $transfers = $cashBook->getTransfers();

        $sumOrigin = $transfers->filter(function($transfer){
            return $transfer->getOrigin()->getSource() == SourceType::CASH_DRAWER;
        })->sum('value');
        $sumDestiny = $transfers->filter(function($transfer){
            return $transfer->getDestiny()->getSource() == SourceType::CASH_DRAWER;
        })->sum('value');

        $moves = $cashBook->getMoves();
        $moves = $moves->filter(function($move){
            return !$move->hasOutlay() || !$move->getOutlay()->getCostCenter()->getCategory()->isSystem();
        });

        $outlays = $this->getValueTotal($moves, TypeMovesType::OUT);
        $sales = $this->getValueTotalSalesByCashBook($cashBook);
        $salesDeliveryFee = $this->getValueTotalSalesDeliveryFeeOnCard($cashBook);
        $salesDeliveryFeeCash = $this->getValueTotalSalesDeliveryFeeOnCash($cashBook);
        $contribute = $this->getValutTotalContribute($date, $store, $cashBook);
        $bleed = $this->getValutTotalBleed($date, $store, $cashBook);
        $treasure = $this->treasureRepository->getCashDrawer($store);

        return [
            'sales' => $sales,
            'sales_total' => $sales->sum('value'),
            'sales_delivery_fee' => $salesDeliveryFee->sum('value_total'),
            'sales_delivery_fee_cash' => $salesDeliveryFeeCash->sum('value_total'),
            'outlays' => $outlays,
            'outlays_total' => $outlays->sum('value'),
            'value_start' => $cashBook->getValueStart(),
            'value_end' => $cashBook->getValueEnd(),
            'only_cash_drawer' => $treasure->getValue(),
            'contribute' => $contribute,
            'bleed' => $bleed,
            'opened_by' => $cashBook->getCreatedBy()->getName(),
            'closed_by' => $cashBook->getValueEnd() ? $cashBook->getUpdatedBy()->getName() : '',
            'datetime_open' => $cashBook->getCreatedAt()->format('d/m/Y H:i:s'),
            'datetime_close' => $cashBook->getValueEnd() ? $cashBook->getDateHour()->format('d/m/Y H:i:s') : '',
            'transfers' => $transfers,
            'sum_origin' => $sumOrigin,
            'sum_destiny' => $sumDestiny,
        ];
    }

    private function getValueTotal(Collection $moves, $type)
    {
        return $moves->where('type', $type)
            ->groupBy('source_id')
            ->map(function($move){ 
                return [
                    'value' => $move->sum('value'),
                    'method' => SourceType::getDisplay($move->first()->getSource()),
                    'details' => $move->map(function($itemMove){
                        return [
                            'description' => $itemMove->getOutlay()->getDescription(),
                            'value' => $itemMove->getOutlay()->getValue(),
                        ];
                    })
                ];
            });
    }
    private function getValueTotalSalesByCashBook(CashBook $cashBook)
    {
        // Procura todas vendas
        $sales = $this->saleRepository->findByCashBook($cashBook);

        $salePaymentMethods = collect();
        // percorre todas vendas
        foreach ($sales as $sale) {
            // percorre todos os métodos de pagamento de cada venda 
            foreach ($sale->getSalePaymentMethod() as $salePaymentMethod) {
                $salePaymentMethods->push($salePaymentMethod);
            }
        }
       
        return $salePaymentMethods->groupBy('payment_method_id')
            ->map(function($sale){ 

                return [
                    'value' => $sale->sum('value_total'),
                    'method' => PaymentMethodsType::getName($sale->first()->getPaymentMethodId())
                ];
            });
    }
   
    private function getValueTotalSalesDeliveryFeeOnCard(CashBook $cashBook)
    {
        // Procura todas vendas
        $salePaymentMethods = $this->salePaymentMethodRepository->findByCashBook($cashBook);
       
        return $salePaymentMethods->filter(function($salePaymentMethod){ 
            return $salePaymentMethod->getPaymentMethodId() != PaymentMethodsType::CASH;
        });
    }
    
    private function getValueTotalSalesDeliveryFeeOnCash(CashBook $cashBook)
    {
        // Procura todas vendas
        $salePaymentMethods = $this->salePaymentMethodRepository->findByCashBook($cashBook);
       
        return $salePaymentMethods->filter(function($salePaymentMethod){ 
            return $salePaymentMethod->getPaymentMethodId() == PaymentMethodsType::CASH;
        });
    }

    private function getValutTotalContribute(Carbon $date, $store, CashBook $cashBook)
    {
        return $this->outlayRepository
            ->getContributesByDate($date, $store, $cashBook)
            ->sum('value');
    }
    
    private function getValutTotalBleed(Carbon $date, $store, CashBook $cashBook)
    {
        return $this->outlayRepository
            ->getBleedByDate($date, $store, $cashBook)
            ->sum('value');
    }
}