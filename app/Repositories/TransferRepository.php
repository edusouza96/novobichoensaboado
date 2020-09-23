<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\CashBook;
use BichoEnsaboado\Models\Transfer;
use BichoEnsaboado\Models\Treasure;
use BichoEnsaboado\Models\User;

class TransferRepository
{
    private $transfer;

    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function all()
    {
        return $this->transfer->all();   
    }
    
    public function find($id)
    {
        return $this->transfer->find($id);   
    }

    public function newInstance()
    {
        return $this->transfer->newInstance();
    }

    public function create(CashBook $cashBook, Treasure $origin, Treasure $destiny, $value, User $user)
    {
        $transfer = $this->newInstance();
        $transfer->cashBook()->associate($cashBook);
        $transfer->origin()->associate($origin);
        $transfer->destiny()->associate($destiny);
        $transfer->user()->associate($user);
        $transfer->value = $value;
        $transfer->save();

        return $transfer;
    }
}
