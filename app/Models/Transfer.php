<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Treasure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;
    protected $table = 'transfers';
    protected $fillable = ['origin_id', 'destiny_id', 'user_id', 'cash_book_id', 'value'];

    public function origin()
    {
        return $this->belongsTo(Treasure::class, 'origin_id');
    }
    public function destiny()
    {
        return $this->belongsTo(Treasure::class, 'destiny_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
     
}
