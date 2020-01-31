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

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->user->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }
       
        if(isset($attributes['nickname'])){
            $search = $search->where('nickname', 'like', "%{$attributes['nickname']}%");
        }

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();
    }
    
}
