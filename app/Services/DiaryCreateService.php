<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Diary;
use BichoEnsaboado\Models\Client;
use BichoEnsaboado\Models\Service;
use BichoEnsaboado\Enums\StatusType;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Repositories\ClientRepository;
use BichoEnsaboado\Repositories\PackageRepository;
use BichoEnsaboado\Repositories\ServiceRepository;

class DiaryCreateService
{
    /** @var DiaryRepository */
    private $diaryRepository;

    /** @var ClientRepository */
    private $clientRepository;

    /** @var ServiceRepository */
    private $serviceRepository;
    
    /** @var PackageRepository */
    private $packageRepository;

    public function __construct(
        DiaryRepository $diaryRepository, 
        ClientRepository $clientRepository, 
        ServiceRepository $serviceRepository,
        PackageRepository $packageRepository)
    {
        $this->diaryRepository = $diaryRepository;
        $this->clientRepository = $clientRepository;
        $this->serviceRepository = $serviceRepository;
        $this->packageRepository = $packageRepository;
    }

    public function create(array $attributes, User $userLogged, $store)
    {
        $diary = $this->diaryRepository->findOrNew($attributes['id']);

        $client = $this->clientRepository->find($attributes['client']);
        $servicePet = isset($attributes['servicePet']) ? $this->serviceRepository->find($attributes['servicePet']) : null;
        $valuePet = $servicePet ? $servicePet->getValue() : 0;
        $serviceVet = isset($attributes['serviceVet']) ? $this->serviceRepository->find($attributes['serviceVet']) : null;
        $valueVet = $serviceVet ? $serviceVet->getValue() : 0;
        $dateHour = Carbon::createFromFormat('Y-m-d H:i:s', $attributes['date'])->setTimeFromTimeString($attributes['hour']);
        $fetch = isset($attributes['fetch']) ? $attributes['fetch'] == 'true' : false;
        $deliveryFee = $fetch ? $client->getNeighborhood()->getValue() : 0; 
        $gross = $attributes['gross'];
        $observation = $attributes['observation'];
        
        // Se for pacote
        if(isset($attributes['package'])){
            if(empty($attributes['id'])){
                return $this->createPackage(
                    $attributes['package'], 
                    $userLogged, 
                    $store, 
                    $client, 
                    $servicePet, 
                    $valuePet,
                    $serviceVet, 
                    $valueVet, 
                    $fetch, 
                    $deliveryFee, 
                    $gross, 
                    $observation
                );
            }else{
                return $this->updatePackage(
                    $diary,
                    $attributes['package'], 
                    $dateHour,
                    $userLogged, 
                    $store, 
                    $client, 
                    $serviceVet, 
                    $valueVet, 
                    $fetch, 
                    $deliveryFee, 
                    $observation
                );

            }
        }
        
        $brothers = $this->diaryRepository->findPetsSameOwnerScheduledSameDay($client, Carbon::createFromFormat('Y-m-d H:i:s', $attributes['date']), true);
        $companion = (int) $brothers->count() > 0;
        
        $status = empty($attributes['id']) ? StatusType::SCHEDULED : null;
        
        $diary = $this->diaryRepository->save($diary, $userLogged, $store, $client, $dateHour, $status, $servicePet, $valuePet, $serviceVet, $valueVet, $fetch, $deliveryFee, $gross, $observation, 0, $companion);
        return $diary;
    }

    private function isFirstPetSameOwnerOfDay($attributes, $companion)
    {
        return !empty($attributes['id']) && $companion == 0;
    }
    private function createPackage(array $packageDates, User $userLogged, $store, Client $client, Service $servicePet = null, $valuePet = 0, Service $serviceVet = null, $valueVet = 0, bool $fetch, $deliveryFee = 0, $gross, $observation)
    {
        $key = md5(time());
        $diaries = collect();

        foreach ($packageDates as $item) {
            $diary = $this->diaryRepository->newEmptyInstance();

            $diary = $this->diaryRepository->save(
                $diary, 
                $userLogged, 
                $store, 
                $client, 
                Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $item['dateHour']),
                StatusType::SCHEDULED, 
                $servicePet, 
                $valuePet, 
                $serviceVet, 
                $valueVet, 
                $fetch, 
                $deliveryFee, 
                $gross, 
                $observation
            );

            // Zera as variaveis pois só o primeiro registro do pacote tem valor
            $deliveryFee = 0;
            $gross = 0;
            $valuePet = 0;
            $valueVet = 0;

            $package = $this->packageRepository->create($diary, $item['id'], $key);
            $diary = $this->diaryRepository->attachPackage($diary, $package);

            $diaries->push($diary);
        }

        return $diaries->first();

    }
    
    private function updatePackage(Diary $diaryParam, $packageDates, Carbon $dateHour, User $userLogged, $store, Client $client, Service $serviceVet = null, $valueVet = 0, bool $fetch, $deliveryFee = 0, $observation)
    {
                
        if(is_array($packageDates)){    
            $key = $diaryParam->getPackage()->getKey();
            $packages = $this->packageRepository->findByKey($key);

            foreach ($packages as $i => $package) {
                $diary = $package->getDiary();

                $diary = $this->diaryRepository->save(
                    $diary, 
                    $userLogged, 
                    $store, 
                    $client, 
                    Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $packageDates[$i]['dateHour']),
                    null, 
                    $diary->getServicePet(), 
                    $diary->getServicePetValue(), 
                    $diary->getServiceVet(),
                    $diary->getServiceVetValue(), 
                    $diary->getFetch(), 
                    $diary->getDeliveryFee(), 
                    $diary->getGross(), 
                    $diary->getObservation()."\nAlterado as datas no dia ".Carbon::now()->format('d/m/Y H:i:s')." pelo(a) operador(a) ".$userLogged->getName(),
                    $diary->getPackage()->getId(),
                    $diary->getCompanion()
                );
            }
        }

        $diff = ((bool)$diaryParam->getFetch()) != $fetch;
        $deliveryFee = $diff ? $deliveryFee : $diaryParam->getDeliveryFee();
        $gross = $diaryParam->getServicePetValue() + $valueVet + $deliveryFee;
        return $this->diaryRepository->save(
            $diaryParam, 
            $userLogged, 
            $store, 
            $client, 
            $dateHour,
            null, 
            $diaryParam->getServicePet(), 
            $diaryParam->getServicePetValue(), 
            $serviceVet,
            $valueVet, 
            $fetch, 
            $deliveryFee, 
            $diff ? $gross : $diaryParam->getGross(), 
            $diaryParam->getObservation()."\nAlteração no pacote no dia ".Carbon::now()->format('d/m/Y H:i:s')." pelo(a) operador(a) ".$userLogged->getName(),
            $diaryParam->getPackage()->getId(),
            $diaryParam->getCompanion()
        );
        
    }
    
}

/**
 * Criar o pacote na tabela package
 * na linha vai ter o id da tabela diary
 * a numeração do pacote
 * um hash unico do pacote md5(date())
 */