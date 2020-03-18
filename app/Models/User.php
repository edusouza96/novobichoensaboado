<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Role;
use BichoEnsaboado\Models\Store;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use EntrustUserTrait;

    protected $fillable = ['name', 'nickname', 'password'];
    protected $table = 'users';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

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

    public function getRole()
    {
        return $this->roles->first();
    }

}
