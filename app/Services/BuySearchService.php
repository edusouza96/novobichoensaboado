<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Models\Diary;
use Illuminate\Support\Collection;
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
        foreach ($diaries as $diary) {
            $servicePet = $diary->toArrayPet();
            if($servicePet) $services->push($servicePet);

            $serviceVet = $diary->toArrayVet();
            if($serviceVet) $services->push($serviceVet);

            $serviceDeliveryFee = $diary->toArrayDeliveryFee();
            if($serviceDeliveryFee) $services->push($serviceDeliveryFee);
        }

        return $services;
    }
    
    public function getDiariesSameOwner(Diary $diary)
    {
        $owner = $diary->getClient()->getOwner();
        $date = $diary->getDateHour();
        return $this->diaryRepository->findPetsSameOwnerScheduledSameDay($owner, $date);
    }
}