<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Rebate;

class RebateRepository
{
    private $rebate;

    public function __construct(Rebate $rebate)
    {
        $this->rebate = $rebate;
    }

    public function all()
    {
        return $this->rebate->all();   
    }

    public function find($id)
    {
        return $this->rebate->find($id);
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->rebate->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }

        if(isset($attributes['active'])){
            $search = $search->where('active', $attributes['active']);
        }

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();
    }

    public function newInstance()
    {
        return $this->rebate->newInstance();
    }

    public function create(array $attributes)
    {
        return $this->rebate->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->rebate->whereId($id)
                           ->update($attributes);
    }

    public function changeStatus($id, $status)
    {
        return $this->rebate->whereId($id)
                           ->update(['active' => $status]);
    }
}
