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

    public function update()
    {

    }

    public function delete()
    {

    }
}
