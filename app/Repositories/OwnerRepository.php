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

    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }
}
