<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Models\User;
use BichoEnsaboado\Enums\CostCenterSystemType;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Services\OutlayCreateService;
use BichoEnsaboado\Repositories\EmployeeSalaryRepository;

class EmployeeSalaryCreateService
{
    /** @var EmployeeSalaryRepository */
    private $employeeSalaryRepository;
    
    /** @var OutlayCreateService */
    private $outlayCreateService;
    
    /** @var UserRepository */
    private $userRepository;

    public function __construct(EmployeeSalaryRepository $employeeSalaryRepository, OutlayCreateService $outlayCreateService, UserRepository $userRepository)
    {
        $this->employeeSalaryRepository = $employeeSalaryRepository;
        $this->outlayCreateService = $outlayCreateService;
        $this->userRepository = $userRepository;
    }

    public function create(array $attributes, User $userLogged)
    {

        $outlay = $this->createOutlay($attributes, $userLogged);
        $user = $this->userRepository->find($attributes["user_id"]);

        $salaryAdvance = isset($attributes["salary_advance"])
            ? $attributes["salary_advance"]
            : false;
        
        return $this->employeeSalaryRepository->create($outlay, $user, $salaryAdvance);

    }

    private function createOutlay(array $attributes, $userLogged)
    {
        $attributes["paid"] = true;
        $attributes["cost_center"] = CostCenterSystemType::COST_CENTER_EMPLOYEE_SALARY;

        return $this->outlayCreateService->create($attributes, $userLogged, $userLogged->getStore()->getId());
    }
}