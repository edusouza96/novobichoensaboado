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
        //
    }

 
    public function store(OutlayCreateRequest $request)
    {
        try {
            $outlay = $this->outlayCreateService->create($request->all(), $this->user, $this->store);
            dd($outlay);
            dd([
                "description" => "Teste despesa",
                "value" => "10",
                "date_pay" => \Carbon\Carbon::now(),
                "source" => "2",
                "cost_center" => "1",
                "paid" => true,
            ]);
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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
