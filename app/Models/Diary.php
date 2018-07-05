<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'diaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'client', 'service', 'search', 'price', 'total_price', 'delivery_price', 'status', 'package', 'companion', 'checkin_hour', 'checkout_hour']; 
        
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_hour'];

    public function getId(){
        return $this->id;
    }

    public function getClient(){
        return $this->client;
    }

    public function getService(){
        return $this->service;
    }

    public function getSearch(){
        return $this->search;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getDeliveryPrice(){
        return $this->delivery_price;
    }

    public function getTotalPrice(){
        return $this->total_price;
    }

    public function getDateHour(){
        return $this->date_hour;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getPackage(){
        return $this->package;
    }

    public function getCompanion(){
        return $this->companion;
    }
}
