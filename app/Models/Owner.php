<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use SoftDeletes;
    
    protected $table = 'owners';
    protected $fillable = ['name', 'cpf', 'email', 'neighborhood_id', 'address', 'phone1', 'phone2'];

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    public function myPets()
    {
        return $this->hasMany(Client::class);
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCpf()
    {
        return $this->cpf;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getMyPets()
    {
        return $this->myPets;
    }
    public function getNeighborhood()
    {
        return $this->neighborhood;
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
    
}
