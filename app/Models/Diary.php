<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Client;
use BichoEnsaboado\Models\Service;
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_hour'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getClient()
    {
        return $this->client;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getFetch()
    {
        return $this->fetch;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDeliveryFee()
    {
        return $this->delivery_fee;
    }

    public function getGross()
    {
        return $this->gross;
    }

    public function getDateHour()
    {
        return $this->date_hour;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getPackage()
    {
        return $this->id_package;
    }

    public function getCompanion()
    {
        return $this->companion;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'companion' => $this->getCompanion(),
            'dateHour' => $this->getDateHour()->toDateTimeString(),
            'hour' => $this->getDateHour()->format('H:i'),
            'deliveryFee' => $this->getDeliveryFee(),
            'fetch' => $this->getFetch(),
            'gross' => $this->getGross(),
            'client' => $this->getClient(),
            'package' => $this->getPackage(),
            'service' => $this->getService(),
            'status' => $this->getStatus(),
            'value' => $this->getValue(),
        ];
    }
}
