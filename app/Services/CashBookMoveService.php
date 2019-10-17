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

    public function generateMovement($value, $name, $store, $source, $userLogged)
    {
        $treasure = $this->treasureRepository->addValue($value, $name, $store);
        $cashBook = $this->cashBookRepository->getLast($store);
        $moves = $this->cashBookMoveRepository->save($value, $source, TypeMovesType::ENTRY, $cashBook, $userLogged);

    }
}