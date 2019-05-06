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

    public function update()
    {
        // 
    }

    public function delete()
    {
        // 
    }
}
