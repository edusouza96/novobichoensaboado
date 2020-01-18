<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Breed;
use BichoEnsaboado\Models\Owner;
use BichoEnsaboado\Models\Neighborhood;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = ['owner_name', 'owner_id', 'name', 'breed_id', 'neighborhood_id', 'address', 'phone1', 'phone2'];
    
    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id');
    }
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
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
    public function getOwnerName()
    {
        return $this->owner_name;
    }
    public function getOwner()
    {
        return $this->owner;
    }
    public function getOwnerId()
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
        
    public function toArray()
    {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'breed_name'    => $this->getBreed()->getName(),
            'breed_id'      => $this->getBreed()->getId(),
            'owner_name'    => $this->getOwnerName(),
            'owner_id'      => $this->getOwnerId(),
            'neighborhood'  => $this->getNeighborhood()->getName(),
            'deliveryFee'   => $this->getNeighborhood()->getValue(),
            'address'       => $this->getAddress(),
            'phone1'        => $this->getPhone1(),
            'phone2'        => $this->getPhone2(),
            'phones'        => $this->getPhone1().'<br>'.$this->getPhone2(),
            'email'         => $this->getOwner()->getEmail(),
        ];
    }
}
