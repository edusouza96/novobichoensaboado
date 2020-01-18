<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Client;

class ClientRepository
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function all()
    {
        return $this->client->all();   
    }
    
    public function findByName($name)
    {
        return $this->client->where('name', 'like', "%$name%")->get();   
    }
    
    public function find($id)
    {
        return $this->client->find($id);   
    }

    public function update($id, array $attributes)
    {
        return $this->client->whereId($id)
                           ->update($attributes);
    }

    public function destroy($id)
    {
        return $this->client->destroy($id);
    }

    public function newInstance()
    {
        return $this->client->newInstance();
    }

    public function create(array $attributes)
    {
        return $this->client->create($attributes);
    }
    
}
