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

}
