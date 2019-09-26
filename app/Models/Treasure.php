<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treasure extends Model
{
    use SoftDeletes;
    protected $table = 'treasures';
    public $timestamps = false;

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function getDisplay()
    {
        return $this->display;
    }
    public function getStore()
    {
        return $this->store_id;
    }   
}
