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

    public function findByStore($storeId)
    {
        return $this->treasure->where('store_id', $storeId)->get();   
    }
    
    public function findOptionsCardMachineByStore($storeId)
    {
        return $this->treasure
            ->where('card_machine', 1)
            ->where('store_id', $storeId)
            ->get();   
    }
    
    public function find($id)
    {
        return $this->treasure->find($id);   
    }

    public function newInstance()
    {
        return $this->treasure->newInstance();
    }

    public function addValue($value, $name, $store)
    {
        $treasure = $this->findTreasureByName($name, $store);
        $treasure->value += $value;
        $treasure->save();
        return $treasure;
    }

    public function subValue($value, $name, $store)
    {
        $treasure = $this->findTreasureByName($name, $store);
        $treasure->value -= $value;
        $treasure->save();
        return $treasure;
    }

    public function findTreasureByName($name, $store)
    {
        return $this->treasure
            ->where('name', $name)
            ->where('store_id', $store)
            ->first();
    }

    public function getCashDrawer($store)
    {
        return $this->treasure
            ->where('store_id', $store)
            ->where('name', 'cash_drawer')
            ->first();
    }

    public function create(array $attributes)
    {
        return $this->treasure->create($attributes);
    }

    public function deleteByStore($store)
    {
        return $this->treasure->where('store_id', $store)
                           ->delete();
    }
}
