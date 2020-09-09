<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\CashBook;
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
   
    public function findByCashBook(CashBook $cashBook)
    {
        return $this->sale->whereHas('salePaymentMethod.cashBookMove', function($query) use($cashBook){
            $query->where('cash_book_id', $cashBook->getId());
        })->get();
    }

    public function findByFilter(array $attributes, $offDay=false, $paginate=false)
    {
        $search = $this->sale->newQuery();

        if(isset($attributes['store'])){
            $search = $search->where('store_id', $attributes['store']);
        }
        
        if($offDay){
            $search = $search->where('total', '>', 0);
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
    
    public function save($amountSale, $promotionValue, $userLogged, $store)
    {
        $sale = $this->newInstance();
        $sale->total = $amountSale;
        $sale->rebate = $promotionValue;
        $sale->store_id = $store;
        $sale->createdBy()->associate($userLogged);
        $sale->updatedBy()->associate($userLogged);
        $sale->save();

        return $sale;
    }

    public function attachRebate(Sale $sale, $rebateId)
    {
        $sale->rebates()->attach($rebateId);
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

    public function findDiary($id)
    {
        $query = $this->sale->newQuery();
        return $query->join('sales_diaries', 'sales_diaries.sale_id', '=', 'sales.id')
                    ->join('diaries', 'sales_diaries.diary_id', '=', 'diaries.id')
                    ->where('sales_diaries.id', $id)
                    ->first();
    }
    public function removeDeliveryFee($id, $gross)
    {
        $query = $this->sale->newQuery();
        return $query->join('sales_diaries', 'sales_diaries.sale_id', '=', 'sales.id')
                    ->join('diaries', 'sales_diaries.diary_id', '=', 'diaries.id')
                    ->where('sales_diaries.id', $id)
                    ->update([
                        'delivery_fee' => 0, 
                        'fetch' => false, 
                        'gross' => $gross
                    ]);
    }
    public function removePet($id, $gross)
    {
        $query = $this->sale->newQuery();
        return $query->join('sales_diaries', 'sales_diaries.sale_id', '=', 'sales.id')
                    ->join('diaries', 'sales_diaries.diary_id', '=', 'diaries.id')
                    ->where('sales_diaries.id', $id)
                    ->update([
                        'service_pet_id' => null, 
                        'service_pet_value' => 0, 
                        'gross' => $gross
                    ]);
    }
    public function removeVet($id, $gross)
    {
        $query = $this->sale->newQuery();
        return $query->join('sales_diaries', 'sales_diaries.sale_id', '=', 'sales.id')
                    ->join('diaries', 'sales_diaries.diary_id', '=', 'diaries.id')
                    ->where('sales_diaries.id', $id)
                    ->update([
                        'service_vet_id' => null, 
                        'service_vet_value' => 0, 
                        'gross' => $gross
                    ]);
    }
    
    public function findProduct($id)
    {
        $query = $this->sale->newQuery();
        return $query->select('sales.*','sales_products.*', 'products.*', 'sales_products.quantity as quantity')
                    ->join('sales_products', 'sales_products.sale_id', '=', 'sales.id')
                    ->join('products', 'sales_products.product_id', '=', 'products.id')
                    ->where('sales_products.id', $id)
                    ->first();
    }
    
    public function deleteProduct($saleId, $productId)
    {
        $query = $this->sale->newQuery();
        $sale = $query->whereHas('products', function($query) use($saleId){
            $query->where('sales_products.id', $saleId);
        })->first();
        $sale->products()->detach($productId);
    }

    public function updateSaleAfterChargeback($id, $newTotal)
    {
        $sale = $this->find($id);
        $oldTotal = $sale->total;

        $sale->total = $newTotal;
        
        $salePaymentMethod = $sale->getSalePaymentMethod()->last();
        $salePaymentMethod->leftover += ($oldTotal - $newTotal);
        $salePaymentMethod->save();
        
        $sale->save();
    }

    public function reportSalesByPeriod(array $attributes, $paginate = false)
    {
        $search = $this->sale->newQuery();

        if(isset($attributes['start'])){
            $search->whereDate('created_at', '>=', Carbon::createFromFormat('Y-m-d', $attributes['start'])->startOfDay());
        }

        if(isset($attributes['end'])){
            $search->whereDate('created_at', '<=', Carbon::createFromFormat('Y-m-d', $attributes['end'])->endOfDay());
        }
        
        if(isset($attributes['store_id'])){
            $search->where('store_id', $attributes['store_id']);
        }

        if(isset($attributes['product_name'])){
            $search->whereHas('products', function($query) use($attributes){
                return $query->where('name', 'like', "%{$attributes['product_name']}%");
            });
        }

        $search->orderBy('created_at');

        return $paginate ? $search->paginate(15) : $search->get();
    }
    
}
