<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\RebateRepository;
use BichoEnsaboado\Http\Requests\RebateCreateRequest;

class RebateController extends Controller
{
    /** @var RebateRepository */
    private $rebateRepository;

    public function __construct(RebateRepository $rebateRepository)
    {
        $this->rebateRepository = $rebateRepository;
    }
   
    public function findActive()
    {
        try{
            $rebates = $this->rebateRepository->findByFilter(['active' => true]);
            return response()->json($rebates);
        }catch(\InvalidArgumentException  $e){
        }
    }

    public function index(Request $request)
    {
        $rebates = $this->rebateRepository->findByFilter($request->all(), true);
        return view('rebate.index', compact('rebates'));
    }

    
    public function create()
    {
        $rebate = $this->rebateRepository->newInstance();
        return view('rebate.create', compact('rebate'));
    }

    public function store(RebateCreateRequest $request)
    {
        try {
            $this->rebateRepository->create($request->only('name', 'value', 'pet', 'vet', 'product'));
            return redirect()->route('rebate.index')->with('alertType', 'success')->with('message', 'Promoção Cadastrada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $rebate = $this->rebateRepository->find($id);
        return view('rebate.edit', compact('rebate'));
    }

    public function update(RebateCreateRequest $request, $id)
    {
        try {
            $this->rebateRepository->update($id, $request->only('name', 'value', 'pet', 'vet', 'product'));
            return redirect()->route('rebate.index')->with('alertType', 'success')->with('message', 'Promoção Atualizada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function active($id)
    {
        try {
            $this->rebateRepository->changeStatus($id, true);
            return redirect()->route('rebate.index')->with('alertType', 'success')->with('message', 'Promoção Ativada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    public function inactive($id)
    {
        try {
            $this->rebateRepository->changeStatus($id, false);
            return redirect()->route('rebate.index')->with('alertType', 'success')->with('message', 'Promoção Inativada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
   
}
