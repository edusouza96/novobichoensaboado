<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = 'owners';
    protected $fillable = ['name', 'cpf', 'email'];

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
    
}
