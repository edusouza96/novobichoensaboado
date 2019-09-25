<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\TypeMovesType;
use BichoEnsaboado\Repositories\CashBookRepository;
use BichoEnsaboado\Repositories\CashBookMoveRepository;

class CashdeskService
{
    private $cashBookRepository;
    private $cashBookReposicashBookMoveRepositorytory;

    public function __construct(CashBookRepository $cashBookRepository, CashBookMoveRepository $cashBookMoveRepository)
    {
        $this->cashBookRepository = $cashBookRepository;
        $this->cashBookMoveRepository = $cashBookMoveRepository;
    }

    public function open(array $attributes, User $userLogged, $store)
    {
        $valueStart = $attributes['valueStart'];
        $source = $attributes['source'];
        $dateHour = Carbon::now();
        $cashBook = $this->cashBookRepository->save($valueStart, '0.00', $dateHour, $userLogged, $store);
        return $this->cashBookMoveRepository->save($valueStart, SourceType::CASH_DRAWER, TypeMovesType::ENTRY, $cashBook, $userLogged);

    }

   
}