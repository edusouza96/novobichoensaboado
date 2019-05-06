<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Diary;
use BichoEnsaboado\Models\Package;

class PackageRepository
{
    private $package;

    public function __construct(Package $package)
    {
        $this->package = $package;
    }

    public function create(Diary $diary, $number, $key)
    {
        $package = $this->newEmptyInstance();
        $package->diary()->associate($diary);
        $package->number = $number;
        $package->key = $key;
        $package->save();
        return $package;
    }

    public function find($id)
    {
        return $this->package->find($id);   
    }
    
    public function newEmptyInstance()
    {
        return $this->package->newInstance();
    }

    public function delete($id)
    {
        $package = $this->find($id);
        return $package->delete();
    }

}
