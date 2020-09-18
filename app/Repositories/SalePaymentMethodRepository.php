<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\CashBook;
use BichoEnsaboado\Models\CashBookMove;
use BichoEnsaboado\Models\SalePaymentMethod;

class SalePaymentMethodRepository
{
    private $salePaymentMethod;

    public function __construct(SalePaymentMethod $salePaymentMethod)
    {
        $this->salePaymentMethod = $salePaymentMethod;
    }
  
    public function save(Sale $sale, $valueReceived, $leftover, $paymentMethod, $plots, CashBookMove $cashBookMove, $deliveryFee = false)
    {
        $salePaymentMethod = $this->newInstance();
        $salePaymentMethod->sale()->associate($sale);
        $salePaymentMethod->value_received = $valueReceived;
        $salePaymentMethod->leftover = $leftover;
        $salePaymentMethod->payment_method_id = $paymentMethod;
        $salePaymentMethod->plots = $plots;
        $salePaymentMethod->cashBookMove()->associate($cashBookMove);
        $salePaymentMethod->delivery_fee = $deliveryFee;

        $salePaymentMethod->save();

        return $salePaymentMethod;
    }

    public function newInstance()
    {
        return $this->salePaymentMethod->newInstance();
    }    

    public function findByCashBook(CashBook $cashBook)
    {
        $search = $this->salePaymentMethod->newQuery();

        $search->whereHas('cashBookMove', function($query) use($cashBook){
            $query->where('cash_book_id', $cashBook->getId());
        });
        
        $search->where('delivery_fee', true);
        
        return $search->get();
    }
}
