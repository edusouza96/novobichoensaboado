<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sales';

    public function diary()
    {
        return $this->belongsToMany(Diary::class, 'sales_diaries', 'sale_id', 'diary_id')->withTimestamps();
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'sales_products', 'sale_id', 'product_id')->withTimestamps();
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
    public function getTotal()
    {
        return $this->total;
    }
    public function getPaymentMethodId()
    {
        return $this->payment_method_id;
    }
    public function getPlots()
    {
        return $this->plots;
    }
    public function getRebate()
    {
        return $this->rebate;
    }
   
   
}