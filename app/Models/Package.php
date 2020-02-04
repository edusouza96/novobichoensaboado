<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Diary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    
    protected $table = 'packages';

    public function diary()
    {
        return $this->belongsTo(Diary::class, 'diary_id');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getDiary()
    {
        return $this->diary;
    }

    public function getNumber()
    {
        return $this->number;
    }
    public function getKey()
    {
        return $this->key;
    }
}
