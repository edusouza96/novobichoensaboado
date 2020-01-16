<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Owner;

class OwnerRepository
{
    private $owner;

    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function all()
    {
        return $this->owner->all();
    }

    public function myPets($id)
    {
       return $this->find($id)->getMypets();
    }

    public function find($id)
    {
        return $this->owner->find($id);
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->owner->newQuery();

        if(isset($attributes['pet_name'])){
            $search = $search->whereHas('myPets', function($search) use($attributes){
                $search->where('name', 'like', "%{$attributes['pet_name']}%");
            });
        }

        if(isset($attributes['breed_name'])){
            $search = $search->whereHas('myPets.breed', function($search) use($attributes){
                $search->where('name', 'like', "%{$attributes['breed_name']}%");
            });
        }
       
        if(isset($attributes['owner_name'])){
            $search = $search->where('name', 'like', "%{$attributes['owner_name']}%");
        }
       
        if(isset($attributes['cpf'])){
            $search = $search->where('cpf', 'like', "%{$attributes['cpf']}%");
        }

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();

    }

    public function newInstance()
    {
        return $this->owner->newInstance();
    }

    public function create(array $attributes)
    {
        return $this->owner->create($attributes);
    }
    
    public function update($id, array $attributes)
    {
        return $this->owner->whereId($id)
                           ->update($attributes);
    }

    public function destroy($id)
    {
        return $this->owner->destroy($id);
    }

}
