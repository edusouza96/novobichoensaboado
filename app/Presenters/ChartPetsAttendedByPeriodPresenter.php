<?php
namespace BichoEnsaboado\Presenters;

use JsonSerializable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
 
class ChartPetsAttendedByPeriodPresenter implements Arrayable, JsonSerializable
{
    private $report;

    public function __construct(Collection $report)
    {
        $this->report = $report;
    }

    public function toArray()
    {
        $collection = collect();
        foreach ($this->report as $data) {
            $collection->put($data->name, $data->count);
        }

        return $collection;
    }
        
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}