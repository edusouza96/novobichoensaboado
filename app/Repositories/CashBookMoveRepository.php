<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\CashBook;
use BichoEnsaboado\Models\CashBookMove;

class CashBookMoveRepository
{
    private $cashBookMove;

    public function __construct(CashBookMove $cashBookMove)
    {
        $this->cashBookMove = $cashBookMove;
    }

    public function all()
    {
        return $this->cashBookMove->all();   
    }
    
    public function find($id)
    {
        return $this->cashBookMove->find($id);   
    }

    public function newInstance()
    {
        return $this->cashBookMove->newInstance();
    }

    public function save($value, $source, $type, CashBook $cashBook, User $userLogged)
    {
        $cashBookMove = $this->newInstance();
        $cashBookMove->value = $value;
        $cashBookMove->source_id = $source;
        $cashBookMove->type = $type;
        $cashBookMove->cashBook()->associate($cashBook);
        $cashBookMove->createdBy()->associate($userLogged);
        $cashBookMove->updatedBy()->associate($userLogged);

        $cashBookMove->save();

        return $cashBookMove;
    }
    
    public function update(CashBookMove $cashBookMove, $value, $source, $type, CashBook $cashBook, User $userLogged)
    {
        $cashBookMove->value = $value;
        $cashBookMove->source_id = $source;
        $cashBookMove->type = $type;
        $cashBookMove->cashBook()->associate($cashBook);
        $cashBookMove->updatedBy()->associate($userLogged);

        $cashBookMove->save();

        return $cashBookMove;
    }
    
    public function delete($id)
    {
        $this->find($id)->delete();   
    }
}
