<?php

namespace BichoEnsaboado\Services\SalesOfDay;

use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\ServicesType;
use BichoEnsaboado\Services\SalesOfDay\UnitSale;

class CollectionSalesProducts
{
    private $products;

    public function __construct(Collection $products)
    {
        $this->products = $products;
    }

    public function get()
    {
        return $this->products->map(function($product){
            return new UnitSale(
                $product->pivot->sale_id,
                $product->getId(),
                $product->pivot->quantity.'x '.$product->getName(),
                $product->pivot->quantity * $product->pivot->unitary_value,
                $product->pivot->created_at,
                $product->pivot->pivotParent->getStore(),
                ServicesType::PRODUCTS
            );
        });
    }
}