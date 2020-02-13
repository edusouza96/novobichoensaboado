<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Outlay;
use Illuminate\Support\Collection;
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
    
    public function pay($id, $value, $source, $datePay, $cashBookMove = null)
    {
        $outlay = $this->find($id);   
        $outlay->paid = true;
        $outlay->value = $value;
        $outlay->source_id = $source;
        $outlay->date_pay = $datePay;
        if($cashBookMove)
            $outlay->cashBookMove()->associate($cashBookMove);
        $outlay->save();
    }
    
    public function findByDate(Carbon $datePay, $store)
    {
        return $this->outlay
            ->where('store_id', $store)
            ->whereNotIn('cost_center_id', CostCenterSystemType::GROUP_CATEGORY_SISTEM)
            ->where('date_pay', 'like', $datePay->format('Y-m-d%'))
            ->get();
            
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->outlay->newQuery();

        $search = $search->whereHas('costCenter', function($query){
            return $query->where('cost_center_category_id', '<>', CostCenterSystemType::CATEGORY_SISTEMA);
        });

        if(isset($attributes['paid'])){
            $search = $search->where('paid', $attributes['paid']);
        }
       
        if(isset($attributes['description'])){
            $search = $search->where('description', 'like', "%{$attributes['description']}%");
        }

        if(isset($attributes['source'])){
            $search = $search->where('source_id', $attributes['source']);
        }
        
        if(isset($attributes['cost_center'])){
            $search = $search->where('cost_center_id', $attributes['cost_center']);
        }
        
        if(isset($attributes['store'])){
            $search = $search->where('store_id', $attributes['store']);
        }
        
        if(isset($attributes['date_pay'])){
            $search = $search->where('date_pay', 'like', $attributes['date_pay'].'%');
        }
        
        if(isset($attributes['date_pay_yesterday'])){
            $search = $search->whereDate('date_pay', '<', $attributes['date_pay_yesterday']);
        }

        $search->orderBy('date_pay', 'desc');

        return $paginate ? $search->paginate(15) : $search->get();
    }
    
    public function getContributesByDate(Carbon $datePay, $store)
    {
        return $this->outlay
            ->where('store_id', $store)
            ->whereIn('cost_center_id', CostCenterSystemType::GROUP_CONTRIBUTE)
            ->whereDate('date_pay', 'like', $datePay->format('Y-m-d%'))
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

    public function save($description = null, $value, Carbon $datePay, $source, $costCenter, $cashBookMove = null, $paid, User $userLogged, $store)
    {
        $outlay = $this->newInstance();
        $outlay->description = $description;
        $outlay->value = $value;
        $outlay->date_pay = $datePay;
        $outlay->source_id = $source;
        $outlay->cost_center_id = $costCenter;
        if($cashBookMove)
            $outlay->cashBookMove()->associate($cashBookMove);
        $outlay->paid = $paid;
        $outlay->store_id = $store;
        $outlay->createdBy()->associate($userLogged);
        $outlay->updatedBy()->associate($userLogged);

        $outlay->save();

        return $outlay;
    }
    
    public function update($id, $description = null, $value, Carbon $datePay, $source, $costCenter, $cashBookMove = null, $paid, User $userLogged)
    {
        $outlay = $this->find($id);
        $outlay->description = $description;
        $outlay->value = $value;
        $outlay->date_pay = $datePay;
        $outlay->source_id = $source;
        $outlay->cost_center_id = $costCenter;
        $outlay->cash_book_move_id = null;
        if($cashBookMove)
            $outlay->cashBookMove()->associate($cashBookMove);
        $outlay->paid = $paid;
        $outlay->updatedBy()->associate($userLogged);

        $outlay->save();

        return $outlay;
    }

    public function delete($id)
    {
        $this->find($id)->delete();   
    }
}
