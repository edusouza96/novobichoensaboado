<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $table = 'sales';

    public function diary()
    {
        return $this->belongsToMany(Diary::class, 'sales_diaries', 'sale_id', 'diary_id')->withTimestamps()->withPivot('id');
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'sales_products', 'sale_id', 'product_id')->withTimestamps()->withPivot('id', 'quantity', 'unitary_value');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
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
    
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getDiary()
    {
        return $this->diary;
    }
    public function getProducts()
    {
        return $this->products;
    }
   
    public function getCalcValueTotal()
    {
        return $this->total - $this->rebate;
    }

    public function getDescription()
    {

        $description = '';
        foreach ($this->getDiary() as $diary) {
            $description .= $diary->getClient()->getName().'<br>';
        }
        foreach ($this->getProducts() as $product) {
            $description .= $product->getName().'<br>';
        }
        return $description;
    }
    public function getStore()
    {
        return $this->store_id;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'value' => $this->getCalcValueTotal(),
            'description' => $this->getDescription(),
            'teste' => $this->getProducts()
        ];
    }
}