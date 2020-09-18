<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treasure extends Model
{
    use SoftDeletes;
    protected $table = 'treasures';
    public $timestamps = false;
    protected $fillable = ['name', 'display', 'value', 'store_id', 'card_machine', 'source_id'];

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
    public function getSource()
    {
        return $this->source_id;
    }
    public function getStore()
    {
        return $this->store_id;
    }   
}
