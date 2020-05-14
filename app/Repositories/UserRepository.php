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

    public function getEmployees()
    {
        $search = $this->user->newQuery();   

        $search->whereHas('roles', function($query){
            return $query->where('name', 'employee');
        });

        $search->orderBy('name');

        return $search->get();
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
        
        if(isset($attributes['role_id'])){
            $search = $search->whereHas('roles', function($query) use($attributes){
                return $query->where('role_id', $attributes['role_id']);
            });
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
        $user = $this->user->create($attributes);
        $user->roles()->attach($attributes['role_id']);

        if(isset($attributes['store']))
            $user->stores()->sync($attributes['store']);
        else
            $user->stores()->sync([]);
            
        $user->save();

        return $user;
    }

    public function update($id, array $attributes)
    {
        $user = $this->find($id);
        $user->name = $attributes['name'];
        $user->nickname = $attributes['nickname'];
        $user->password = $this->checkNewPassword($id, $attributes['password']);
        $user->roles()->detach();
        $user->roles()->attach($attributes['role_id']);
        
        if(isset($attributes['store']))
            $user->stores()->sync($attributes['store']);
        else
            $user->stores()->sync([]);

        $user->save();

        return $user;
    }

    private function checkNewPassword($id, $password)
    {
        $user = $this->find($id);
        if($user->getPassword() == $password){
            return $password;
        }

        return bcrypt($password);
    }

    public function findByNickname($nickname)
    {
        return $this->user->where('nickname', $nickname)->first();  
    }
}