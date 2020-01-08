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

    public function find($id)
    {
        return $this->neighborhood->find($id);   
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

    public function update($id, array $attributes)
    {
        $attributes['value'] = str_replace(',', '.', $attributes['value']);
        return $this->neighborhood->whereId($id)
                                  ->update($attributes);
    }

    public function destroy($id)
    {
        return $this->neighborhood->destroy($id);
    }

    public function newInstance()
    {
        return $this->neighborhood->newInstance();
    }
}
