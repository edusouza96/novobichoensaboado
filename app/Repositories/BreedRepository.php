<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Breed;

class BreedRepository
{
    private $breed;

    public function __construct(Breed $breed)
    {
        $this->breed = $breed;
    }

    public function all()
    {
        return $this->breed->all();   
    }

    public function find($id)
    {
        return $this->breed->find($id);   
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->breed->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();
    }
    
    public function create(array $attributes)
    {
        return $this->breed->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->breed->whereId($id)
                           ->update($attributes);
    }

    public function destroy($id)
    {
        return $this->breed->destroy($id);
    }

    public function newInstance()
    {
        return $this->breed->newInstance();
    }
}
