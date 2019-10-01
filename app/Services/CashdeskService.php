<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\TypeMovesType;
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

    public function __construct(
        CashBookRepository $cashBookRepository, 
        CashBookMoveRepository $cashBookMoveRepository, 
        OutlayRepository $outlayRepository,
        TreasureRepository $treasureRepository
    ) {
        $this->cashBookRepository = $cashBookRepository;
        $this->cashBookMoveRepository = $cashBookMoveRepository;
        $this->outlayRepository = $outlayRepository;
        $this->treasureRepository = $treasureRepository;
    }

    public function open(array $attributes, User $userLogged, $store)
    {
        $valueStart = $attributes['valueStart'];
        $source = $attributes['source'];
        $dateHour = Carbon::now();
        $cashBook = $this->cashBookRepository->save($valueStart, null, $dateHour, $userLogged, $store);
        $moves = $this->cashBookMoveRepository->save($valueStart, SourceType::CASH_DRAWER, TypeMovesType::ENTRY, $cashBook, $userLogged);
        $outlay = $this->outlayRepository->save('Aporte - caixa inicial', $valueStart, $dateHour, $source, $costCenter=1, $paid=true, $userLogged, $store);
        $treasure = $this->treasureRepository->subValue($source, $valueStart, $store);
        return $this->treasureRepository->addValue(SourceType::CASH_DRAWER, $valueStart, $store);
    }

    public function close(array $attributes, User $userLogged, $store)
    {
        $valueWithdraw = $attributes['valueWithdraw'];
        $source = $attributes['source'];
        $closingDate = Carbon::createFromFormat('Y-m-d', $attributes['closingDate']);

        $cashBook = $this->cashBookRepository->findByDate($closingDate, $store);
        if(!$cashBook) throw new \Exception("Caixa não aberto para o dia ".$closingDate->format('d/m/Y'));
        
        $treasure = $this->treasureRepository->addValue($source, $valueWithdraw, $store);
        $treasure = $this->treasureRepository->subValue(SourceType::CASH_DRAWER, $valueWithdraw, $store);
        $cashDrawer = $treasure->getValue() + $valueWithdraw;

        $cashBook = $this->cashBookRepository->updateValueEnd($cashBook, $cashDrawer, $userLogged, $store);
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

   
}