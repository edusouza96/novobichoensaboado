<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Breed;
use BichoEnsaboado\Models\Owner;
use BichoEnsaboado\Models\Neighborhood;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    
    protected $table = 'clients';
    protected $fillable = ['owner_id', 'name', 'breed_id', 'observation'];
    
    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id');
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
        return $this->getOwner()->getNeighborhood();
    }
    public function getOwnerName()
    {
        return $this->getOwner()->getName();
    }
    public function getOwner()
    {
        return $this->owner;
    }
    public function getOwnerId()
    {
        return $this->getOwner()->getId();
    }
    public function getName()
    {
        return $this->name;
    }
    public function getAddress()
    {
        return $this->getOwner()->getAddress();
    }
    public function getPhone1()
    {
        return $this->getOwner()->getPhone1();
    }
    public function getPhone2()
    {
        return $this->getOwner()->getPhone2();
    }

    public function getObservation()
    {
        return $this->observation;
    }
        
    public function toArray()
    {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'breed_name'    => $this->getBreed() ? $this->getBreed()->getName() : '',
            'breed_id'      => $this->getBreed() ? $this->getBreed()->getId() : '',
            'owner_name'    => $this->getOwnerName(),
            'owner_id'      => $this->getOwnerId(),
            'neighborhood'  => $this->getNeighborhood()->getName(),
            'deliveryFee'   => $this->getNeighborhood()->getValue(),
            'address'       => $this->getAddress(),
            'phone1'        => $this->getPhone1(),
            'phone2'        => $this->getPhone2(),
            'phones'        => $this->getPhone1().'<br>'.$this->getPhone2(),
            'email'         => $this->getOwner()->getEmail(),
            'observation'   => $this->getObservation(),
        ];
    }
}
