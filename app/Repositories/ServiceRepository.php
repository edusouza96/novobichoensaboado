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

    public function update()
    {
        // 
    }

    public function delete()
    {
        // 
    }
}
