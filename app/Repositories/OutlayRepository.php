<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Outlay;

class OutlayRepository
{
    private $outlay;

    public function __construct(Outlay $outlay)
    {
        $this->outlay = $outlay;
    }

    public function all()
    {
        return $this->outlay->all();   
    }
    
    public function find($id)
    {
        return $this->outlay->find($id);   
    }
    
    public function findByDate(Carbon $datePay, $store)
    {
        return $this->outlay
            ->where('store_id', $store)
            ->where('cost_center_id', '<>', 1)
            ->where('date_pay', 'like', $datePay->format('Y-m-d%'))
            ->get();
            
    }
    
    public function getContributesByDate(Carbon $datePay, $store)
    {
        return $this->outlay
            ->where('store_id', $store)
            ->where('cost_center_id', 1)
            ->where('date_pay', 'like', $datePay->format('Y-m-d%'))
            ->get();
            
    }

    public function newInstance()
    {
        return $this->outlay->newInstance();
    }

    public function save($description = null, $value, Carbon $datePay, $source, $costCenter, $paid, User $userLogged, $store)
    {
        $outlay = $this->newInstance();
        $outlay->description = $description;
        $outlay->value = $value;
        $outlay->date_pay = $datePay;
        $outlay->source_id = $source;
        $outlay->cost_center_id = $costCenter;
        $outlay->paid = $paid;
        $outlay->store_id = $store;
        $outlay->createdBy()->associate($userLogged);
        $outlay->updatedBy()->associate($userLogged);

        $outlay->save();

        return $outlay;
    }
}
