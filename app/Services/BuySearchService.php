<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Models\Diary;
use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\ServicesType;
use BichoEnsaboado\Repositories\DiaryRepository;

class BuySearchService
{
    private $diaryRepository;

    public function __construct(DiaryRepository $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }
   
    public function getBuys($ids)
    {
        $diaries = $this->diaryRepository->findInId($ids);
        return $this->buildServices($diaries);
    }

    private function buildServices(Collection $diaries)
    {
        $services = collect();
        $servicesDeliveryFee = collect();

        foreach ($diaries as $diary) {
            $servicePet = $diary->toArrayPet();
            if($servicePet) $services->push($servicePet);

            $serviceVet = $diary->toArrayVet();
            if($serviceVet) $services->push($serviceVet);

            $serviceDeliveryFee = $diary->toArrayDeliveryFee();
            if($serviceDeliveryFee) $servicesDeliveryFee->push($serviceDeliveryFee);
        }

        if($servicesDeliveryFee->isNotEmpty()) 
            $services->push($this->applyUniqueDeliveryFee($servicesDeliveryFee));

        return $services;
    }
    
    public function getDiariesSameOwner(Diary $diary)
    {
        $client = $diary->getClient();
        $date = $diary->getDateHour();
        return $this->diaryRepository->findPetsSameOwnerScheduledSameDay($client, $date, false);
    }

    private function applyUniqueDeliveryFee(Collection $servicesDeliveryFee)
    {
        $serviceDeliveryFee = $servicesDeliveryFee->sortByDesc('amount')->first();
        if($servicesDeliveryFee->count() > 1){
            $ids = $servicesDeliveryFee->where('id', '!=', $serviceDeliveryFee['id'])->pluck('id');
            $this->diaryRepository->resetDeliveryFee($ids);
        }
        return [
            "units" => 1,
            "description" => 'Serviço de Busca',
            "unitaryValue" => $serviceDeliveryFee['amount'],
            "amount" => $serviceDeliveryFee['amount'],
            "type" => ServicesType::DELIVERY_FEE,
        ];
    }
}