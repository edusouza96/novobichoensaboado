<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\CashBook;

class CashBookRepository
{
    private $cashBook;

    public function __construct(CashBook $cashBook)
    {
        $this->cashBook = $cashBook;
    }

    public function all()
    {
        return $this->cashBook->all();   
    }
    
    public function find($id)
    {
        return $this->cashBook->find($id);   
    }

    public function findByDate(Carbon $date, $store)
    {
        return $this->cashBook
            ->where('store_id', $store)
            ->whereNull('value_end')
            ->whereDate('date_hour', '=', $date->toDateString())
            ->orderBy('id', 'desc')
            ->first();   
    }

    public function newInstance()
    {
        return $this->cashBook->newInstance();
    }

    public function save($valueStart, $valueEnd, Carbon $dateHour, $userLogged, $store)
    {
        $cashBook = $this->newInstance();
        $cashBook->value_start = $valueStart;
        $cashBook->value_end = $valueEnd;
        $cashBook->date_hour = $dateHour;
        $cashBook->store_id = $store;
        $cashBook->createdBy()->associate($userLogged);
        $cashBook->updatedBy()->associate($userLogged);

        $cashBook->save();

        return $cashBook;
    }
}
