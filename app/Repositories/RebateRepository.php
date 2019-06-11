<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Rebate;

class RebateRepository
{
    private $rebate;

    public function __construct(Rebate $rebate)
    {
        $this->rebate = $rebate;
    }

    public function all()
    {
        return $this->rebate->all();   
    }

    public function update()
    {
        // 
    }

    public function delete()
    {
        // 
    }
}
