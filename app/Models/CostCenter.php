<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;
use BichoEnsaboado\Models\CostCenterCategory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenter extends Model
{
    use SoftDeletes;
    
    protected $table = 'cost_center';
    protected $fillable = ['name', 'cost_center_category_id'];

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
    public function isFixed()
    {
        return $this->fixed;
    }
  
}
