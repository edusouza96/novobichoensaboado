<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\User;
use Illuminate\Database\Eloquent\Model;

class CashBook extends Model
{
    protected $table = 'cash_book';
    protected $dates = ['date_hour'];

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
    public function getValueStart()
    {
        return $this->value_start;
    }
    public function getValueEnd()
    {
        return $this->value_end;
    }
    public function getDateHour()
    {
        return $this->date_hour;
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
