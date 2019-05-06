<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\User;

class UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();   
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    
}
