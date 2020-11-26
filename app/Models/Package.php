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
    
    public function packages()
    {
        return $this->hasMany(Package::class, 'key', 'key');
    }
    
    public function getPackages()
    {
        return $this->packages;
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

    public function listDatesPackagesAll()
    {
        return $this->packages->map(function($package){
            return [ 
                'dateHour' => $package->getDiary() ? $package->getDiary()->getDateHour()->format('Y-m-d\TH:i:s') : '',
                'id' => $package->getNumber()
            ];
        });
    }
}
