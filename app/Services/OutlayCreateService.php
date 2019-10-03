<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Models\User;
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
        $outlay = $this->outlayRepository->save(
            $attributes['description'], 
            $attributes['value'], 
            $attributes['date_pay'], 
            $attributes['source'], 
            $attributes['cost_center'], 
            $attributes['paid'], 
            $userLogged, 
            $store
        );

        $treasure = $this->treasureRepository->subValue($attributes['source'], $attributes['value'], $store);

        $cashBook = $this->cashBookRepository->getLast($store);
        $moves = $this->cashBookMoveRepository->save($attributes['value'], $attributes['source'], TypeMovesType::OUT, $cashBook, $userLogged);

        return $outlay;
    }

}