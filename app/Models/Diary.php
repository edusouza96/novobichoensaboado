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
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function servicePet()
    {
        return $this->belongsTo(Service::class, 'service_pet_id');
    }
    public function serviceVet()
    {
        return $this->belongsTo(Service::class, 'service_vet_id');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getClient()
    {
        return $this->client;
    }

    public function getServicePet()
    {
        return $this->servicePet;
    }
    public function getServiceVet()
    {
        return $this->serviceVet;
    }

    public function getFetch()
    {
        return $this->fetch;
    }

    public function getServicePetValue()
    {
        return $this->service_pet_value;
    }
    public function getServiceVetValue()
    {
        return $this->service_vet_value;
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
        return $this->package_id;
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
            'servicePet' => $this->getServicePet(),
            'serviceVet' => $this->getServiceVet(),
            'status' => $this->getStatus(),
            'petValue' => $this->getValue(),
            'petValue' => $this->getPetValue(),
            'vetValue' => $this->getVettValue(),
        ];
    }
}
