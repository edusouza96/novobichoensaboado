<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Breed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    
    protected $table = 'services';
    protected $fillable = ['name', 'value','breed_id', 'package_type_id', 'pet', 'vet'];

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id');
    }

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
    public function getBreed()
    {
        return $this->breed;
    }

    public function isPet()
    {
        return $this->pet;
    }

    public function isVet()
    {
        return $this->vet;
    }

    public function getPackageType()
    {
        return $this->package_type_id;
    }

}
