<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Treasure;
use BichoEnsaboado\Models\CostCenter;
use BichoEnsaboado\Models\CashBookMove;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlay extends Model
{
    use SoftDeletes;
    
    protected $table = 'outlays';
    protected $dates = ['date_pay'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function source()
    {
        return $this->belongsTo(Treasure::class, 'source_id');
    }
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }
    public function cashBookMove()
    {
        return $this->belongsTo(CashBookMove::class, 'cash_book_move_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function getDatePay()
    {
        return $this->date_pay;
    }
    public function getSource()
    {
        return $this->source;
    }
    public function getCashBookMove()
    {
        return $this->cashBookMove;
    }
    public function getCostCenter()
    {
        return $this->costCenter;
    }
    public function getPaid()
    {
        return $this->paid;
    }
    public function getStore()
    {
        return $this->store;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
   
    public function statusPay()
    {
        if($this->paid == 1) return 'checked';
        if($this->paid === 0) return '';
        return 'checked';
    }
   
}
