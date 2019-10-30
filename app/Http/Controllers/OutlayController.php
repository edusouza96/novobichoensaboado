<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Services\OutlayCreateService;
use BichoEnsaboado\Repositories\OutlayRepository;
use BichoEnsaboado\Http\Requests\OutlayCreateRequest;

class OutlayController extends Controller
{
    private $outlayCreateService;
    private $userRepository;
    private $user;
    private $store = 1;
    private $outlayRepository;

    public function __construct(OutlayCreateService $outlayCreateService, OutlayRepository $outlayRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->user = $this->userRepository->find(1);
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
            $outlay = $this->outlayCreateService->create($request->all(), $this->user, $this->store);
            return redirect()->route('outlay.index')->with('alertType', 'success')->with('message', 'Despesa Cadastrada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function findByDate(Request $request)
    {
        try {
            $datePay = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('date_pay'));
            $outlay = $this->outlayRepository->findByDate($datePay , $this->store);
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
            $outlay = $this->outlayCreateService->update($id, $request->all(), $this->user);
            return redirect()->route('outlay.index')->with('alertType', 'success')->with('message', 'Despesa Atualizada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    public function destroy($id)
    {
        //
    }
    public function pay($id)
    {
        try {
            $this->outlayRepository->pay($id);
            return redirect()->route('outlay.index')->with('alertType', 'success')->with('message', 'Despesa Paga.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
}
