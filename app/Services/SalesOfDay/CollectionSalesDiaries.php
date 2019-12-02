<?php

namespace BichoEnsaboado\Services\SalesOfDay;

use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\ServicesType;
use BichoEnsaboado\Services\SalesOfDay\UnitSale;

class CollectionSalesDiaries
{
    private $diaries;

    public function __construct(Collection $diaries)
    {
        $this->diaries = $diaries;
    }

    public function get()
    {
        $list = collect();
        $list = $list->merge($this->getPet());
        $list = $list->merge($this->getVet());
        $list = $list->merge($this->getDeliveryFee());

        return $list;
    }
    public function getPet()
    {
        $list = collect();
        foreach ($this->diaries as $diary) {
            if(is_null($diary->getServicePet())) continue;
            $list->push(
                new UnitSale(
                    $diary->pivot->sale_id,
                    $diary->getId(),
                    $diary->getServicePet()->getName().' - '.$diary->getClient()->getName(),
                    $diary->getServicePetValue(),
                    $diary->getDateHour(),
                    $diary->getStore(),
                    ServicesType::PET
                )
            );
        }

        return $list;
    }
    public function getVet()
    {
        $list = collect();
        foreach ($this->diaries as $diary) {
            if(is_null($diary->getServiceVet())) continue;
            $list->push(
                new UnitSale(
                    $diary->pivot->sale_id,
                    $diary->getId(),
                    $diary->getServiceVet()->getName().' - '.$diary->getClient()->getName(),
                    $diary->getServiceVetValue(),
                    $diary->getDateHour(),
                    $diary->getStore(),
                    ServicesType::VET
                )
            );
        }

        return $list;
    }
    public function getDeliveryFee()
    {
        $list = collect();
        foreach ($this->diaries as $diary) {
            if($diary->getFetch() == 0) continue;
            $list->push(
                new UnitSale(
                    $diary->pivot->sale_id,
                    $diary->getId(),
                    'Serviço de Busca - '.$diary->getClient()->getName(),
                    $diary->getDeliveryFee(),
                    $diary->getDateHour(),
                    $diary->getStore(),
                    ServicesType::DELIVERY_FEE
                )
            );
        }

        return $list;
    }
}