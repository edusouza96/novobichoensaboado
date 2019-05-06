<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'owners';

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
    public function getMyPets()
    {
        return $this->myPets;
    }
    
}
