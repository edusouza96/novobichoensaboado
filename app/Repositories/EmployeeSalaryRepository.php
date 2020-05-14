<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\EmployeeSalary;
use BichoEnsaboado\Enums\CostCenterSystemType;

class EmployeeSalaryRepository
{
    private $employeeSalary;

    public function __construct(EmployeeSalary $employeeSalary)
    {
        $this->employeeSalary = $employeeSalary;
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->employeeSalary->newQuery();

        $search->whereHas('outlays', function($query) use($attributes){

            $query->where('cost_center_id', '=', CostCenterSystemType::COST_CENTER_EMPLOYEE_SALARY);
            
            if(isset($attributes['start'])){
                $query->whereDate('date_pay', '>=', Carbon::createFromFormat('Y-m-d', $attributes['start'])->startOfDay());
            }
            
            if(isset($attributes['end'])){
                $query->whereDate('date_pay', '<=', Carbon::createFromFormat('Y-m-d', $attributes['end'])->endOfDay());
            }
            
        });

        if(isset($attributes['user_id'])){
            $search->where('user_id', '=', $attributes['user_id']);
        }

        $search->orderBy('created_at', 'desc');

        return $paginate ? $search->paginate(15) : $search->get();
    }
}
