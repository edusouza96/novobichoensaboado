<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\CostCenterCategory;

class CostCenterCategoryRepository
{
    private $costCenterCategory;

    public function __construct(CostCenterCategory $costCenterCategory)
    {
        $this->costCenterCategory = $costCenterCategory;
    }

    public function all()
    {
        return $this->costCenterCategory->where('id', '<>', 1000)->get(); 
    }
}
