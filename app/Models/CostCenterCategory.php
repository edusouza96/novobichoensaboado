<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\CostCenter;
use Illuminate\Database\Eloquent\Model;

class CostCenterCategory extends Model
{
    protected $table = 'cost_center_category';

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'id', 'cost_center_category_id');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCostCenter()
    {
        return $this->costCenter;
    }
}
