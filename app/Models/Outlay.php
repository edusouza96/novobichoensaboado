<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\User;
use Illuminate\Database\Eloquent\Model;

class Outlay extends Model
{
    protected $table = 'outlay';
    protected $dates = ['date_pay'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
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
        return $this->source_id;
    }
    public function getCostCenter()
    {
        return $this->cost_center_id;
    }
    public function getPaid()
    {
        return $this->paid;
    }
    public function getStore()
    {
        return $this->store_id;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
   
}
