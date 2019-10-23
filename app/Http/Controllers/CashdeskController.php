<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use BichoEnsaboado\Services\CashdeskService;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Http\Requests\OpenCashdeskRequest;
use BichoEnsaboado\Http\Requests\BleedCashdeskRequest;
use BichoEnsaboado\Http\Requests\CloseCashdeskRequest;
use BichoEnsaboado\Http\Requests\ContributeCashdeskRequest;

class CashdeskController extends Controller
{
    private $cashdeskService;
    private $userRepository;
    private $user;
    private $store = 1;

    public function __construct(CashdeskService $cashdeskService, UserRepository $userRepository)
    {
        $this->cashdeskService = $cashdeskService;
        $this->userRepository = $userRepository;
        $this->user = $this->userRepository->find(1);
    }

    public function bleed(BleedCashdeskRequest $request)
    {
        try {
            $cashbook = $this->cashdeskService->bleed($request->all(), $this->user, $this->store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
   
    public function contribute(ContributeCashdeskRequest $request)
    {
        try {
            $cashbook = $this->cashdeskService->contribute($request->all(), $this->user, $this->store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    
    public function open(OpenCashdeskRequest $request)
    {
        try {
            $cashbook = $this->cashdeskService->open($request->all(), $this->user, $this->store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    
    public function close(CloseCashdeskRequest $request)
    {
        try {
            $cashbook = $this->cashdeskService->close($request->all(), $this->user, $this->store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function status()
    {
        try {
            $status = $this->cashdeskService->status($this->store);
            return response()->json($status);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
   
    public function getCashDrawer()
    {
        try {
            $treasure = $this->cashdeskService->getCashDrawer($this->store);
            return response()->json($treasure);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function inconsistencyUnfinishedCashdesk()
    {
        try {
            $result = $this->cashdeskService->inconsistencyUnfinishedCashdesk($this->store);
            return response()->json($result);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function extractOfDay(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
            $result = $this->cashdeskService->extractOfDay($date , $this->store);
            return response()->json($result);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
   
    public function moneyTransfer(Request $request)
    {
        try {
            $result = $this->cashdeskService->moneyTransfer($request->all(), $this->user, $this->store);
            return response()->json($result);
        } catch (\Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
}
