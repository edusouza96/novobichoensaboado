<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Service;

class ServiceRepository
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function all()
    {
        return $this->service->all();
    }

    public function findByBreed($id)
    {
        return $this->service->whereHas('breed', function ($query) use ($id) {
            $query->whereId($id);
        })->get();
    }

    public function find($id)
    {
        return $this->service->find($id);
    }

    public function allVet()
    {
        return $this->service->whereDoesntHave('breed')->get();
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->service->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }
        
        if(isset($attributes['breed'])){
            $search = $search->where('breed_id', $attributes['breed']);
        }
        
        if(isset($attributes['package_type'])){
            $search = $search->where('package_type_id', $attributes['package_type']);
        }
        
        $search->where(function ($search) use($attributes) {
            if(isset($attributes['pet'])){
                $search = $search->where('pet', $attributes['pet']);
            }
            
            if(isset($attributes['vet'])){
                $search = $search->orWhere('vet', $attributes['vet']);
            }
        });

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();

    }


    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }
}
