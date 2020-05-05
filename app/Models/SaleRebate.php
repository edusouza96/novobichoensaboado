<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\Rebate;
use Illuminate\Database\Eloquent\Model;

class SaleRebate extends Model
{
    protected $table = 'sales_rebates';
    public $timestamps = false;

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function rebate()
    {
        return $this->belongsTo(Rebate::class);
    }

    public function getSale()
    {
        return $this->sale;
    }
    public function getRebate()
    {
        return $this->rebate;
    }
    public function getId()
    {
        return $this->id;
    }
   
}