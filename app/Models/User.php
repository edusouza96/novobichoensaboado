<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   
    protected $table = 'users';

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getNickname()
    {
        return $this->nickname;
    }
    public function getPassword()
    {
        return $this->password;
    }
   
}
