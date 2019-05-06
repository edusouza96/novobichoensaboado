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

    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }
}
