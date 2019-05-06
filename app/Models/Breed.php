<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'breeds';

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
   
}
