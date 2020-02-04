<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Breed extends Model
{
    use SoftDeletes;
    
    protected $table = 'breeds';
    protected $fillable = ['name'];

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
   
}
