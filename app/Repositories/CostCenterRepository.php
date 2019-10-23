<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\CostCenter;

class CostCenterRepository
{
    private $costCenter;

    public function __construct(CostCenter $costCenter)
    {
        $this->costCenter = $costCenter;
    }

    public function all()
    {
        return $this->costCenter->all();   
    }

    public function find($id)
    {
        return $this->costCenter->find($id);
    }

    public function findByCategory($categoryId)
    {
        return $this->costCenter->where('cost_center_category_id', $categoryId);
    }
    
}
