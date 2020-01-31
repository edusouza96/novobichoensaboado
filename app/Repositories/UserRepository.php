<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\User;
use Illuminate\Support\Facades\Hash;

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
    
    public function destroy($id)
    {
        return $this->user->destroy($id);
    }

    public function newInstance()
    {
        return $this->user->newInstance();
    }

    public function create(array $attributes)
    {
        $attributes['password'] = bcrypt($attributes['password']);
        return $this->user->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $attributes['password'] = $this->checkNewPassword($id, $attributes['password']);
        return $this->user->whereId($id)
                           ->update($attributes);
    }

    private function checkNewPassword($id, $password)
    {
        $user = $this->find($id);
        if($user->getPassword() == $password){
            return $password;
        }

        return bcrypt($password);
    }
}