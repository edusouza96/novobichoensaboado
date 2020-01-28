<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;

class Rebate extends Model
{
   
    protected $table = 'rebates';
    protected $fillable = ['name', 'value', 'pet', 'vet', 'product'];

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function isActive()
    {
        return (bool) $this->active;
    }
    public function applyPet()
    {
        return (bool) $this->pet;
    }
    public function applyVet()
    {
        return (bool) $this->vet;
    }
    public function applyProduct()
    {
        return (bool) $this->product;
    }
   
}
