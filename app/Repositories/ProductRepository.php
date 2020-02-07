<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Product;

class ProductRepository
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function last()
    {
        return $this->product->latest('barcode')->first();   
    }

    public function all()
    {
        return $this->product->all();   
    }
    
    public function findByName($name)
    {
        return $this->product->where('name', 'like', "%$name%")
            ->where('quantity', '>', 0)
            ->get();   
    }
    
    public function find($id)
    {
        return $this->product->find($id);   
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->product->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }
        
        if(isset($attributes['barcode'])){
            $search = $search->where('barcode', $attributes['barcode']);
        }

        $search->orderBy('name', 'asc');

        return $paginate ? $search->paginate(15) : $search->get();

    }

    public function quantityLessThan()
    {
        return $this->product->where('quantity', '<', 5)->get();
    }

    public function destroy($id)
    {
        return $this->product->destroy($id);
    }

    public function newInstance()
    {
        return $this->product->newInstance();
    }

    public function create(array $attributes)
    {
        $attributes['value_sales'] = str_replace(',', '.', $attributes['value_sales']);
        $attributes['value_buy'] = str_replace(',', '.', $attributes['value_buy']);
        return $this->product->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $attributes['value_sales'] = str_replace(',', '.', $attributes['value_sales']);
        $attributes['value_buy'] = str_replace(',', '.', $attributes['value_buy']);
        return $this->product->whereId($id)
                           ->update($attributes);
    }

    public function writeOffInventory($id, $quantity)
    {
        $product = $this->find($id);
        $product->subtract($quantity);
        $product->save();

        return $product;
    }

}
