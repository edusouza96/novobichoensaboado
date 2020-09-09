<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\CostCenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use BichoEnsaboado\Enums\CostCenterSystemType;

class CostCenterCategory extends Model
{
    use SoftDeletes;
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
    public function isSystem()
    {
        return $this->id == CostCenterSystemType::CATEGORY_SISTEMA;
    }
}
