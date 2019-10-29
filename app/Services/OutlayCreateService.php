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

class OutlayCreateService
{
    private $outlayRepository;
    private $treasureRepository;
    private $cashBookRepository;
    private $cashBookMoveRepository;

    public function __construct(
        OutlayRepository $outlayRepository, 
        TreasureRepository $treasureRepository,
        CashBookRepository $cashBookRepository, 
        CashBookMoveRepository $cashBookMoveRepository
    )
    {
        $this->outlayRepository =  $outlayRepository;
        $this->treasureRepository =  $treasureRepository;
        $this->cashBookRepository = $cashBookRepository;
        $this->cashBookMoveRepository = $cashBookMoveRepository;
    }

    public function create(array $attributes, User $userLogged, $store)
    {
        $datePay = Carbon::createFromFormat('Y-m-d', $attributes['date_pay']);
        $value = str_replace(',', '.', $attributes['value']);
        
        $outlay = $this->outlayRepository->save(
            $attributes['description'], 
            $value, 
            $datePay, 
            $attributes['source'], 
            $attributes['cost_center'], 
            isset($attributes['paid']) ? $attributes['paid']: false, 
            $userLogged, 
            $store
        );

        $treasure = $this->treasureRepository->subValue($value, SourceType::getName($attributes['source']), $store);

        $cashBook = $this->cashBookRepository->getLast($store);
        $moves = $this->cashBookMoveRepository->save($value, $attributes['source'], TypeMovesType::OUT, $cashBook, $userLogged);

        return $outlay;
    }

}