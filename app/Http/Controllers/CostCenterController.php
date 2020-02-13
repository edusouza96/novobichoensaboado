<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\CostCenterRepository;
use BichoEnsaboado\Http\Requests\CostCenterCreateRequest;

class CostCenterController extends Controller
{
    private $costCenterRepository;

    public function __construct(CostCenterRepository $costCenterRepository)
    {
        $this->costCenterRepository = $costCenterRepository;
    }

    public function allOptions()
    {
        try {
            $costCenter = $this->costCenterRepository->all(true);
            return response()->json($costCenter);
        } catch (\InvalidArgumentException $e) {
        }
    }

    public function index(Request $request)
    {
        $costCenters = $this->costCenterRepository->findByFilter($request->all(), true);
        return view('costCenter.index', compact('costCenters'));
    }

    public function create()
    {
        $costCenter = $this->costCenterRepository->newInstance();
        return view('costCenter.create', compact('costCenter'));
    }

    public function store(CostCenterCreateRequest $request)
    {
        try {
            $this->costCenterRepository->create($request->only('name', 'cost_center_category_id'));
            return redirect()->route('costCenter.index')->with('alertType', 'success')->with('message', 'Centro de Custo Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $costCenter = $this->costCenterRepository->find($id);
        return view('costCenter.edit', compact('costCenter'));
    }

    public function update(CostCenterCreateRequest $request, $id)
    {
        try {
            $this->costCenterRepository->update($id, $request->only('name', 'cost_center_category_id'));
            return redirect()->route('costCenter.index')->with('alertType', 'success')->with('message', 'Centro de Custo Atualizada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $this->costCenterRepository->destroy($id);
            return redirect()->route('costCenter.index')->with('alertType', 'success')->with('message', 'Centro de Custo Deletado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }

}
