<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
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
        }

        $companion = 0;
        $brothers = $this->diaryRepository->findPetsSameOwnerScheduledSameDay($client->getOwner(), Carbon::createFromFormat('Y-m-d H:i:s', $attributes['date']));

        if($brothers->count() > 0){
            $companion = 1;
            $gross = $valuePet + $valueVet;
            $deliveryFee = 0;
        }
        
        $status = empty($attributes['id']) ? StatusType::SCHEDULED : null;
        
        $diary = $this->diaryRepository->findOrNew($attributes['id']);

        $diary = $this->diaryRepository->save($diary, $userLogged, $store, $client, $dateHour, $status, $servicePet, $valuePet, $serviceVet, $valueVet, $fetch, $deliveryFee, $gross, $observation, 0, $companion);
        return $diary;
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
    
}

/**
 * Criar o pacote na tabela package
 * na linha vai ter o id da tabela diary
 * a numeração do pacote
 * um hash unico do pacote md5(date())
 */