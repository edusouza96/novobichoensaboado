<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Outlay;
use BichoEnsaboado\Enums\CostCenterSystemType;

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
            ->whereNotIn('cost_center_id', CostCenterSystemType::GROUP_CATEGORY_SISTEM)
            ->where('date_pay', 'like', $datePay->format('Y-m-d%'))
            ->get();
            
    }
    
    public function getContributesByDate(Carbon $datePay, $store)
    {
        return $this->outlay
            ->where('store_id', $store)
            ->whereIn('cost_center_id', CostCenterSystemType::GROUP_CONTRIBUTE)
            ->where('date_pay', 'like', $datePay->format('Y-m-d%'))
            ->get();
    }
    
    public function getBleedByDate(Carbon $datePay, $store)
    {
        return $this->outlay
            ->where('store_id', $store)
            ->where('cost_center_id', CostCenterSystemType::COST_CENTER_SANGRIA)
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
