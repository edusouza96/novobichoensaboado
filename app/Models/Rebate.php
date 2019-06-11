<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;

class Rebate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rebates';

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
   
}
