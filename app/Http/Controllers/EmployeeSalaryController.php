<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\EmployeeSalaryRepository;

class EmployeeSalaryController extends Controller
{
    /** @var EmployeeSalaryRepository */
    private $employeeSalaryRepository;

    public function __construct(EmployeeSalaryRepository $employeeSalaryRepository)
    {
        $this->employeeSalaryRepository = $employeeSalaryRepository;
    }

    public function index(Request $request)
    {
        $employeeSalaries = $this->employeeSalaryRepository->findByFilter($request->all(), true);
        return view('employeeSalary.index', compact('employeeSalaries'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
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
