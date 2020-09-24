<?php
namespace BichoEnsaboado\Presenters;

use JsonSerializable;
use BichoEnsaboado\Models\Diary;
use BichoEnsaboado\Enums\ServicesType;
use Illuminate\Contracts\Support\Arrayable;
 
class SaleItemPresenter implements Arrayable, JsonSerializable
{
    private $saleItem;
    private $type;

    public function __construct($saleItem, $type)
    {
        $this->saleItem = $saleItem;
        $this->type = $type;
    }

    public function toArray()
    {
        if($this->type ==  ServicesType::PRODUCTS) return $this->toArrayProduct();
        if($this->type ==  ServicesType::PET) return $this->toArrayPet();
        if($this->type ==  ServicesType::VET) return $this->toArrayVet();
        if($this->type ==  ServicesType::DELIVERY_FEE) return $this->toArrayDeliveryFee();
       
    }

    public function toArrayProduct()
    {
        $totalValue = $this->saleItem->pivot->quantity *  $this->saleItem->pivot->unitary_value;
        return [
            'quantity' => $this->saleItem->pivot->quantity,
            'id' => $this->saleItem->pivot->id,
            'type' => $this->type,
            'name' => $this->saleItem->getName(),
            'value' => $totalValue,
            'value_br' => number_format($totalValue, 2, ',', '.'),
        ];
    }

    public function toArrayPet()
    {
        return [
            'quantity' => 1,
            'id' => $this->saleItem->pivot->id,
            'type' => $this->type,
            'name' => $this->saleItem->getServicePet()->getName().$this->saleItem->getNumberPackage(),
            'value' => $this->saleItem->getServicePetValue(),
            'value_br' => number_format($this->saleItem->getServicePetValue(), 2, ',', '.'),
        ];
    }
   
    public function toArrayVet()
    {
        return [
            'quantity' => 1,
            'id' => $this->saleItem->pivot->id,
            'type' => $this->type,
            'name' => $this->saleItem->getServiceVet()->getName(),
            'value' => $this->saleItem->getServiceVetValue(),
            'value_br' => number_format($this->saleItem->getServiceVetValue(), 2, ',', '.'),
        ];
    }

    public function toArrayDeliveryFee()
    {
        return [
            'quantity' => 1,
            'id' => $this->saleItem->pivot->id,
            'type' => $this->type,
            'name' => 'Busca - '. $this->saleItem->getClient()->getName(),
            'value' => $this->saleItem->getDeliveryFee(),
            'value_br' => number_format($this->saleItem->getDeliveryFee(), 2, ',', '.'),
        ];
    }

        
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}