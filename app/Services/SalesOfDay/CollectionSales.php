<?php

namespace BichoEnsaboado\Services\SalesOfDay;

use Illuminate\Support\Collection;
use BichoEnsaboado\Services\SalesOfDay\CollectionSalesDiaries;
use BichoEnsaboado\Services\SalesOfDay\CollectionSalesProducts;

class CollectionSales
{
    private $sales;

    public function __construct(Collection $sales)
    {
        $this->sales = $sales;
    }

    public function getProducts()
    {
        $list = collect();
        foreach ($this->sales as $sale) {
            $products = new CollectionSalesProducts($sale->getProducts());
            $list = $list->merge($products->get());
        }
        
        return $list;
    }
    
    public function getDiary()
    {
        $list = collect();
        foreach ($this->sales as $sale) {
            $diaries = new CollectionSalesDiaries($sale->getDiary());
            $list = $list->merge($diaries->get());
        }
        
        return $list;
    }



    public function list()
    {
        $list = collect();
        $list = $list->merge($this->getProducts());
        $list = $list->merge($this->getDiary());
        return $list;
    }
}