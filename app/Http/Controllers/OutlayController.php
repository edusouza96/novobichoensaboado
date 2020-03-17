<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use BichoEnsaboado\Services\OutlayCreateService;
use BichoEnsaboado\Repositories\OutlayRepository;
use BichoEnsaboado\Http\Requests\OutlayCreateRequest;

class OutlayController extends Controller
{
    private $outlayCreateService;
    private $store = 1;
    private $outlayRepository;

    public function __construct(OutlayCreateService $outlayCreateService, OutlayRepository $outlayRepository)
    {
        $this->outlayCreateService = $outlayCreateService;
        $this->outlayRepository = $outlayRepository;
    }

    public function index(Request $request)
    {
        $outlays = $this->outlayRepository->findByFilter($request->all(), true);
        return view('outlay.index', compact('outlays'));
    }
   
    public function create()
    {
        $outlay = $this->outlayRepository->newInstance();
        return view('outlay.create', compact('outlay'));
    }
 
    public function store(OutlayCreateRequest $request)
    {
        try {
            $outlay = $this->outlayCreateService->create($request->all(), auth()->user(), $this->store);
            return redirect()->route('outlay.index')->with('alertType', 'success')->with('message', 'Despesa Cadastrada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function findByDate(Request $request)
    {
        try {
            $datePay = Carbon::createFromFormat('Y-m-d', $request->get('date_pay'));
            $outlay = $this->outlayRepository->findByDate($datePay , $this->store);
            return response()->json($outlay);
        } catch (Exception $ex) {
            dd('erro');
        }
    }
    
    public function listDashboard($type)
    {
        try {
            $attributes['paid'] = 0;
            if($type == 'today'){
                $attributes['date_pay'] = Carbon::now()->format('Y-m-d');
            }else if($type == 'tomorrow'){
                $attributes['date_pay'] = Carbon::tomorrow()->format('Y-m-d');
            }else{
                $attributes['date_pay_yesterday'] = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
            }
            $outlay = $this->outlayRepository->findByFilter($attributes, false);
            return response()->json($outlay);
        } catch (Exception $ex) {
            dd('erro');
        }
    }

    public function edit($id)
    {
        $outlay = $this->outlayRepository->find($id);
        return view('outlay.edit', compact('outlay'));
    }

    public function update(OutlayCreateRequest $request, $id)
    {
        try {
            $outlay = $this->outlayCreateService->update($id, $request->all(), auth()->user(), $this->store);
            return redirect()->route('outlay.index')->with('alertType', 'success')->with('message', 'Despesa Atualizada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    public function showJson($id)
    {
        try {
            $outlay = $this->outlayRepository->find($id);
            return response()->json($outlay);
        } catch (Exception $ex) {
            dd($ex);
        } 
    }
    public function destroy($id)
    {
        try {
            $this->outlayCreateService->delete($id, $this->store);
            return redirect()->route('outlay.index')->with('alertType', 'success')->with('message', 'Despesa Deletada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }
    public function pay(Request $request)
    {
        try {
            $this->outlayCreateService->pay($request->all(), auth()->user(), $this->store);
            return redirect()->route('outlay.index')->with('alertType', 'success')->with('message', 'Despesa Paga.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
}
