<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Services\EmployeeSalaryCreateService;
use BichoEnsaboado\Repositories\EmployeeSalaryRepository;
use BichoEnsaboado\Http\Requests\EmployeeSalaryCreateRequest;

class EmployeeSalaryController extends Controller
{
    /** @var EmployeeSalaryRepository */
    private $employeeSalaryRepository;
    
    /** @var EmployeeSalaryCreateService */
    private $employeeSalaryCreateService;

    public function __construct(EmployeeSalaryRepository $employeeSalaryRepository, EmployeeSalaryCreateService $employeeSalaryCreateService)
    {
        $this->employeeSalaryRepository = $employeeSalaryRepository;
        $this->employeeSalaryCreateService = $employeeSalaryCreateService;
    }

    public function index(Request $request)
    {
        $employeeSalaries = $this->employeeSalaryRepository->findByFilter($request->all(), true);
        return view('employeeSalary.index', compact('employeeSalaries'));
    }

    public function create()
    {
        $employeeSalary = $this->employeeSalaryRepository->newInstance();
        return view('employeeSalary.create', compact('employeeSalary'));
    }

    public function store(EmployeeSalaryCreateRequest $request)
    {
        try {
            $this->employeeSalaryCreateService->create($request->all(), auth()->user());
            return redirect()->route('employeeSalary.index')->with('alertType', 'success')->with('message', 'Pagamento Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        try {
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

   
}
