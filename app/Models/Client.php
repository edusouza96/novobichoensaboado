<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Breed;
use BichoEnsaboado\Models\Neighborhood;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id');
    }
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getBreed()
    {
        return $this->breed;
    }
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }
    public function getOwner()
    {
        return $this->owner_name;
    }
    public function getIdOwner()
    {
        return $this->owner_id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getPhone1()
    {
        return $this->phone1;
    }
    public function getPhone2()
    {
        return $this->phone2;
    }
    public function getEmail()
    {
        return $this->email;
    }
    
    public function toArray()
    {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'breed_name'    => $this->getBreed()->getName(),
            'breed_id'      => $this->getBreed()->getId(),
            'owner_name'         => $this->getOwner(),
            'neighborhood'  => $this->getNeighborhood()->getName(),
            'address'       => $this->getAddress(),
            'phone1'        => $this->getPhone1(),
            'phone2'        => $this->getPhone2(),
            'email'         => $this->getEmail(),
        ];
    }
}
