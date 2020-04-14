<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Client;
use BichoEnsaboado\Models\Package;
use BichoEnsaboado\Models\Service;
use BichoEnsaboado\Enums\StatusType;
use BichoEnsaboado\Enums\ServicesType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diary extends Model
{
    use SoftDeletes;
    
    protected $table = 'diaries';
    protected $dates = ['date_hour'];
    protected $fillable = ['gross'];

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sales_diaries', 'diary_id', 'sale_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
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
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
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
    
    public function getStore()
    {
        return $this->store_id;
    }

    public function getPackage()
    {
        return $this->package;
    }

    public function getCompanion()
    {
        return $this->companion;
    }
    
    public function getCheckinHour()
    {
        return $this->checkin_hour;
    }
    
    public function getObservation()
    {
        return $this->observation;
    }

    private function getColorByStatus()
    {
        if($this->status == StatusType::SCHEDULED) return 'table-row-background-status-scheduled';
        if($this->status == StatusType::PRESENT) return 'table-row-background-status-present';
        if($this->status == StatusType::FINISHED) return 'table-row-background-status-finished';
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
            'package' => $this->getPackage() ? $this->getPackage()->getId() : null,
            'servicePet' => $this->getServicePet(),
            'serviceVet' => $this->getServiceVet(),
            'status' => $this->getStatus(),
            'petValue' => $this->getServicePetValue(),
            'vetValue' => $this->getServiceVetValue(),
            'checkin_hour' => $this->getCheckinHour(),
            'observation' => $this->getObservation(),
            'cssRowBackground' => $this->getColorByStatus(),
            'editable' => false,
        ];
    }

    public function toArrayPet()
    {
        if (is_null($this->getServicePet())) return null;
        return [
            "units" => 1,
            "description" => $this->getServicePet()->getName().' - '.$this->getClient()->getName(),
            "unitaryValue" => $this->getServicePetValue(),
            "amount" => $this->getServicePetValue(),
            "type" => ServicesType::PET,
        ];
    }
    public function toArrayVet()
    {
        if (is_null($this->getServiceVet())) return null;
        return [
            "units" => 1,
            "description" => $this->getServiceVet()->getName().' - '.$this->getClient()->getName(),
            "unitaryValue" => $this->getServiceVetValue(),
            "amount" => $this->getServiceVetValue(),
            "type" => ServicesType::VET,
        ];
    }
    public function toArrayDeliveryFee()
    {
        if ($this->getFetch() == 0) return null;
        return [
            "units" => 1,
            "description" => 'Serviço de Busca - '.$this->getClient()->getName(),
            "unitaryValue" => $this->getDeliveryFee(),
            "amount" => $this->getDeliveryFee(),
            "type" => ServicesType::DELIVERY_FEE,
        ];
    }
    public function getDescription()
    {
        return 
            (is_null($this->getServicePet()) ? '' : $this->getServicePet()->getName().' + ').
            (is_null($this->getServiceVet()) ? '' : $this->getServiceVet()->getName().' + ').
            (is_null($this->getFetch())      ? '' : 'Serviço de Busca');
    }
}
