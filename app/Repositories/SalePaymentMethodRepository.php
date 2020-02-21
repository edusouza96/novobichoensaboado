<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\SalePaymentMethod;

class SalePaymentMethodRepository
{
    private $salePaymentMethod;

    public function __construct(SalePaymentMethod $salePaymentMethod)
    {
        $this->salePaymentMethod = $salePaymentMethod;
    }
  
    public function save(Sale $sale, $valueReceived, $leftover, $paymentMethod, $plots)
    {
        $salePaymentMethod = $this->newInstance();
        $salePaymentMethod->sale()->associate($sale);
        $salePaymentMethod->value_received = $valueReceived;
        $salePaymentMethod->leftover = $leftover;
        $salePaymentMethod->payment_method_id = $paymentMethod;
        $salePaymentMethod->plots = $plots;

        $salePaymentMethod->save();

        return $salePaymentMethod;
    }

    public function newInstance()
    {
        return $this->salePaymentMethod->newInstance();
    }    
}
