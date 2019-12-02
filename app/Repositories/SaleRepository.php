<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\Diary;
use BichoEnsaboado\Models\Product;

class SaleRepository
{
    private $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function all()
    {
        return $this->sale->all();   
    }
    
    public function find($id)
    {
        return $this->sale->find($id);   
    }

    public function findByDate($date, $store)
    {
        return $this->sale
            ->where('store_id', $store)
            ->where('created_at', 'like', $date->format('Y-m-d%'))
            ->get();
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->sale->newQuery();

        if(isset($attributes['store'])){
            $search = $search->where('store_id', $attributes['store']);
        }
        if(isset($attributes['created_at'])){
            $search = $search->where('created_at', 'like', $attributes['created_at'].'%');
        }
        if(isset($attributes['name_pet'])){
            $search = $search->whereHas('diary', function($query) use ($attributes){
                $query->whereHas('client', function($query) use ($attributes){
                    $query->where('name', 'like', '%'.$attributes['name_pet'].'%');
                });
            });
        }
        if(isset($attributes['name_product'])){
            $search = $search->whereHas('products', function($query) use ($attributes){
                $query->where('name', 'like', '%'.$attributes['name_product'].'%');
            });
        }

        if(empty($attributes)){
            $search = $search->where('created_at', 'like', Carbon::now()->format('Y-m-d').'%');
        }

        $search->orderBy('id', 'desc');
        return $paginate ? $search->paginate(10) : $search->get();
    }
    
    public function save($valueReceived, $leftover, $amountSale, $paymentMethod, $plots, $promotionValue, $userLogged, $store)
    {
        $sale = $this->newInstance();
        $sale->value_received = $valueReceived;
        $sale->leftover = $leftover;
        $sale->total = $amountSale;
        $sale->payment_method_id = $paymentMethod;
        $sale->plots = $plots;
        $sale->rebate = $promotionValue;
        $sale->store_id = $store;
        $sale->createdBy()->associate($userLogged);
        $sale->updatedBy()->associate($userLogged);

        $sale->save();

        return $sale;
    }

    public function newInstance()
    {
        return $this->sale->newInstance();
    }

    public function attachDiary(Sale $sale, Diary $diary)
    {
        $sale->diary()->attach($diary);
        $sale->save();
        return $sale;
    }
   
    public function attachProduct(Sale $sale, Product $product)
    {
        $sale->products()->attach($product, $product->getDataToSaveSale());
        $sale->save();
        return $sale;
    }
    
}
