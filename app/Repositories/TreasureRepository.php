<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Treasure;

class TreasureRepository
{
    private $treasure;

    public function __construct(Treasure $treasure)
    {
        $this->treasure = $treasure;
    }

    public function all()
    {
        return $this->treasure->all();   
    }
    
    public function find($id)
    {
        return $this->treasure->find($id);   
    }

    public function newInstance()
    {
        return $this->treasure->newInstance();
    }

    public function addValue($id, $value, $store)
    {
        $treasure = $this->find($id);
        $treasure->value += $value;
        $treasure->store_id = $store;
        $treasure->save();
        return $treasure;
    }

    public function subValue($id, $value, $store)
    {
        $treasure = $this->find($id);
        $treasure->value -= $value;
        $treasure->store_id = $store;
        $treasure->save();
        return $treasure;
    }

    public function getCashDrawer($store)
    {
        return $this->treasure
            ->where('store_id', $store)
            ->where('name', 'cash_drawer')
            ->first();
    }
}
