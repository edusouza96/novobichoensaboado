<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';
    protected $fillable = ['barcode', 'name','value_sales', 'value_buy', 'quantity'];

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getValueSales()
    {
        return $this->value_sales;
    }
    public function getValueBuy()
    {
        return $this->value_buy;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getBarcode()
    {
        return $this->barcode;
    }
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    }

    public function getDataToSaveSale()
    {
        return [
            "quantity"  => $this->getQuantity(),	
            "unitary_value" => $this->getValueSales(),
        ];
    }
   
}
