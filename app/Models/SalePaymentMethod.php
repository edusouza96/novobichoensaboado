<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Sale;
use Illuminate\Database\Eloquent\Model;
use BichoEnsaboado\Enums\PaymentMethodsType;

class SalePaymentMethod extends Model
{
    protected $table = 'sales_payment_method';
    public $timestamps = false;

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function getSale()
    {
        return $this->sale;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getValueReceived()
    {
        return $this->value_received;
    }
    public function getLeftover()
    {
        return $this->leftover;
    }
   
    public function getPaymentMethodId()
    {
        return $this->payment_method_id;
    }
    public function getPlots()
    {
        return $this->plots;
    }
    
    public function getDescription()
    {
        return PaymentMethodsType::getName($this->getPaymentMethodId());
    }

    public function getCalcValueTotal()
    {
        return $this->getLeftover() > 0
            ? abs($this->getValueReceived() - $this->getLeftover())
            : $this->getValueReceived();
    }
   
}