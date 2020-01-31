<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Store;

class StoreRepository
{
    private $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function all()
    {
        return $this->store->all();   
    }

    public function find($id)
    {
        return $this->store->find($id);
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->store->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();
    }

    public function newInstance()
    {
        return $this->store->newInstance();
    }

    public function create(array $attributes)
    {
        return $this->store->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->store->whereId($id)
                           ->update($attributes);
    }

}
