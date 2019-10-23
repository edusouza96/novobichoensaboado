<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;
use BichoEnsaboado\Models\CostCenterCategory;

class CostCenter extends Model
{
    protected $table = 'cost_center';

    public function category()
    {
        return $this->belongsTo(CostCenterCategory::class, 'cost_center_category_id');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCategory()
    {
        return $this->category;
    }
  
}
