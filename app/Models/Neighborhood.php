<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'neighborhoods';

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
}
