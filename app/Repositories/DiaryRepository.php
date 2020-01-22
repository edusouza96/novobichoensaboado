<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Diary;
use BichoEnsaboado\Models\Owner;
use BichoEnsaboado\Models\Client;
use BichoEnsaboado\Models\Service;
use Illuminate\Support\Facades\DB;
use BichoEnsaboado\Enums\StatusType;

class DiaryRepository
{
    private $diary;

    public function __construct(Diary $diary)
    {
        $this->diary = $diary;
    }

    public function save(Diary $diary, User $userLogged, $store, Client $client, Carbon $dateHour, $status, Service $servicePet = null, $valuePet = 0, Service $serviceVet = null, $valueVet = 0, bool $fetch, $deliveryFee = 0, $gross, $observation, $package = 0, $companion =0)
    {
        if(is_null($diary->getId())) $diary->createdBy()->associate($userLogged);
        $diary->updatedBy()->associate($userLogged);
        $diary->client()->associate($client);
        $diary->servicePet()->associate($servicePet);
        $diary->serviceVet()->associate($serviceVet);
        if($status) $diary->status = (int) $status;
        $diary->fetch = (int) $fetch;
        $diary->service_pet_value = $valuePet;
        $diary->service_vet_value = $valueVet;
        $diary->date_hour = $dateHour;
        $diary->delivery_fee = $deliveryFee;
        $diary->gross = $gross;
        $diary->package_id = $package;
        $diary->companion = $companion;
        $diary->store_id = $store;
        $diary->observation = $observation;
        $diary->save();
        return $diary;
    }

    public function findByDate(Carbon $date)
    {
        return $this->diary->whereBetween('date_hour', [
            $date->startOfDay()->toDateTimeString(), 
            $date->endOfDay()->toDateTimeString()
        ])->get();
    }

    public function find($id)
    {
        return $this->diary->find($id);   
    }
    
    public function findInId(array $ids)
    {
        return $this->diary->whereIn('id', $ids)->get();   
    }
    
    public function findOrNew($id = null)
    {
        return $id ? $this->find($id) : $this->newEmptyInstance();   
    }
    
    public function checkin($id)
    {
        $diary = $this->find($id);
        $diary->status = StatusType::PRESENT;
        $diary->checkin_hour = Carbon::now()->format('h:i');
        $diary->save();

        return $diary;
    }
    public function paid(array $ids)
    {
        $this->diary->whereIn('id', $ids)
            ->update(['status' => StatusType::FINISHED]);
    }

    public function newEmptyInstance()
    {
        return $this->diary->newInstance();
    }

    public function delete($id)
    {
        $diary = $this->find($id);
        return $diary->delete();
    }

    public function findPetsSameOwnerScheduledSameDay(Owner $owner, Carbon $date)
    {
        $diary = $this->diary->newQuery();

        return $diary->whereHas('client', function($query) use($owner){
            $query->whereHas('owner', function($query) use($owner){
                $query->Where('id', $owner->getId());
            });
        })->whereBetween('date_hour', [clone $date->startOfDay(), clone $date->endOfDay()])->get();
    }

    public function findByFilter($attributes, $paginate=false)
    {
        $search = $this->diary->newQuery();

        if(isset($attributes['start'])){
            $search = $search->whereDate('date_hour', '>=', $attributes['start']." 00:00:00");
        }

        if(isset($attributes['end'])){
            $search = $search->whereDate('date_hour', '<=', $attributes['end']." 23:59:59");
        }

        if(isset($attributes['client_id'])){
            $search = $search->where('client_id', $attributes['client_id']);
        }
        
        $search->orderBy('date_hour', 'desc');
// dd(str_replace_array('s?', $search->getBindings(), $search->toSql()));
        return $paginate ? $search->paginate(15) : $search->get();
    }

    public function attachPackage($diary, $package)
    {
        $diary->package()->associate($package);
        $diary->save();
        return $diary;
    }

    public function blacklist()
    {
        $diary = $this->diary->newQuery();

        return $diary->select(DB::raw('max(diaries.id) as id, max(`client_id`) as client_id, max(`date_hour`) as date_hour, sum(`gross`) as gross'))
            ->join('clients', 'diaries.client_id', '=', 'clients.id')
            ->whereDoesntHave('sales')
            ->whereDate('date_hour', '<=', Carbon::now()->startOfDay())
            ->groupBy(DB::raw("DATE_FORMAT(date_hour, '%Y-%m-%d')"))
            ->groupBy('clients.owner_id')
            ->get();
    }
}
