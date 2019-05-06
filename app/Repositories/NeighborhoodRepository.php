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

    public function update()
    {
        // 
    }

    public function delete()
    {
        // 
    }
}
