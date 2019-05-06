<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Breed;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services';

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
    public function getPackageType()
    {
        // #1 - unico
        // #2 - 15 dias
        // #3 - 30 dias
        return $this->package_type_id;
    }
}
