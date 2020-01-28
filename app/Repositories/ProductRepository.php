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

    public function all()
    {
        return $this->product->all();   
    }
    
    public function findByName($name)
    {
        return $this->product->where('name', 'like', "%$name%")->get();   
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

    public function destroy($id)
    {
        return $this->product->destroy($id);
    }
}
