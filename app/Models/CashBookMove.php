<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\CashBook;
use Illuminate\Database\Eloquent\Model;

class CashBookMove extends Model
{
    protected $table = 'cash_book_moves';

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function cashBook()
    {
        return $this->belongsTo(CashBook::class, 'cash_book_id');
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function getSource()
    {
        return $this->source_id;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getCashBook()
    {
        return $this->cashBook;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
   
}
