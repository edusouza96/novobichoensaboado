<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Enums\TypeMovesType;
use BichoEnsaboado\Repositories\CashBookRepository;
use BichoEnsaboado\Repositories\TreasureRepository;
use BichoEnsaboado\Repositories\CashBookMoveRepository;

class CashBookMoveService
{
    private $treasureRepository;
    private $cashBookRepository;
    private $cashBookMoveRepository;

    public function __construct(
        TreasureRepository $treasureRepository,
        CashBookRepository $cashBookRepository, 
        CashBookMoveRepository $cashBookMoveRepository
    )
    {
        $this->treasureRepository =  $treasureRepository;
        $this->cashBookRepository = $cashBookRepository;
        $this->cashBookMoveRepository = $cashBookMoveRepository;
    }

    public function generateMovementEntry($value, $name, $store, $source, $userLogged)
    {
        $treasure = $this->treasureRepository->addValue($value, $name, $store);
        $cashBook = $this->cashBookRepository->getLast($store);
        $moves = $this->cashBookMoveRepository->save($value, $source, TypeMovesType::ENTRY, $cashBook, $userLogged);
        return $moves;
    }
 
    public function generateMovementOut($value, $name, $store, $source, $userLogged)
    {
        $treasure = $this->treasureRepository->subValue($value, $name, $store);
        $cashBook = $this->cashBookRepository->getLast($store);
        $moves = $this->cashBookMoveRepository->save($value, $source, TypeMovesType::OUT, $cashBook, $userLogged);
        return $moves;
    }
}