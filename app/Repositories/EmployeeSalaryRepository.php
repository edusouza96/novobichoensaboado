<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Outlay;
use BichoEnsaboado\Models\EmployeeSalary;
use BichoEnsaboado\Enums\CostCenterSystemType;

class EmployeeSalaryRepository
{
    private $employeeSalary;

    public function __construct(EmployeeSalary $employeeSalary)
    {
        $this->employeeSalary = $employeeSalary;
    }

    public function newInstance()
    {
        return $this->employeeSalary->newInstance();
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->employeeSalary->newQuery();

        $search->whereHas('outlays', function($query) use($attributes){
            
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

    public function create(Outlay $outlay,User $user, $salaryAdvance)
    {
        $employeeSalary = $this->newInstance();
        $employeeSalary->salary_advance = $salaryAdvance;
        $employeeSalary->outlays()->associate($outlay);
        $employeeSalary->users()->associate($user);
        $employeeSalary->save();

        return $employeeSalary;
    }
}
