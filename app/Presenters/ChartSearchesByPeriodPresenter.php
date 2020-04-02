<?php
namespace BichoEnsaboado\Presenters;

use JsonSerializable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
 
class ChartSearchesByPeriodPresenter implements Arrayable, JsonSerializable
{
    private $report;

    public function __construct(Collection $report)
    {
        $this->report = $report->groupBy(function($data){
            return $data->getClient()->getNeighborhood()->getName();
        });
    }

    public function toArray()
    {
        return $this->report->map(function($data){
            return $data->count();
        });
    }
        
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}