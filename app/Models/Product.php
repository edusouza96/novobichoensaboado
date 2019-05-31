<?php

namespace BichoEnsaboado\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

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
        return $this->valueSales;
    }
    public function getValueBuy()
    {
        return $this->valueBuy;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getBarcode()
    {
        return $this->barcode;
    }
   
}
