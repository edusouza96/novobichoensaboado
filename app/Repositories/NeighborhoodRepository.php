<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Neighborhood;

class NeighborhoodRepository
{
    private $neighborhood;

    public function __construct(Neighborhood $neighborhood)
    {
        $this->neighborhood = $neighborhood;
    }

    public function all()
    {
        return $this->neighborhood->all();   
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->neighborhood->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();

    }

    public function create(array $attributes)
    {
        $attributes['value'] = str_replace(',', '.', $attributes['value']);
        return $this->neighborhood->create($attributes);
    }

    public function update()
    {
        // 
    }

    public function delete()
    {
        // 
    }

    public function newInstance()
    {
        return $this->neighborhood->newInstance();
    }
}
