<?php
namespace BichoEnsaboado\Presenters;

use JsonSerializable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
 
class ChartSalesByPeriodPresenter implements Arrayable, JsonSerializable
{
    private $report;

    public function __construct(Collection $report)
    {
        $this->report = $report->groupBy(function($data){
            return $data->getCreatedAt()->format('m/Y');
        });
    }

    public function toArray()
    {
        return $this->report->map(function($data){
            return number_format($data->sum('total'), 2, '.', '');
        });
    }
        
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}