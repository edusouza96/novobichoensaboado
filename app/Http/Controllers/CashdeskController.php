<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use BichoEnsaboado\Services\CashdeskService;
use BichoEnsaboado\Http\Requests\OpenCashdeskRequest;
use BichoEnsaboado\Http\Requests\BleedCashdeskRequest;
use BichoEnsaboado\Http\Requests\CloseCashdeskRequest;
use BichoEnsaboado\Http\Requests\ContributeCashdeskRequest;

class CashdeskController extends Controller
{
    private $cashdeskService;

    public function __construct(CashdeskService $cashdeskService)
    {
        $this->cashdeskService = $cashdeskService;
    }

    public function bleed(BleedCashdeskRequest $request)
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $cashbook = $this->cashdeskService->bleed($request->all(), auth()->user(), $store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
   
    public function contribute(ContributeCashdeskRequest $request)
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $cashbook = $this->cashdeskService->contribute($request->all(), auth()->user(), $store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    
    public function open(OpenCashdeskRequest $request)
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $cashbook = $this->cashdeskService->open($request->all(), auth()->user(), $store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
    
    public function close(CloseCashdeskRequest $request)
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $cashbook = $this->cashdeskService->close($request->all(), auth()->user(), $store);
            return response()->json($cashbook);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function status()
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $status = $this->cashdeskService->status($store);
            return response()->json($status);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
   
    public function getCashDrawer()
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $treasure = $this->cashdeskService->getCashDrawer($store);
            return response()->json($treasure);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function inconsistencyUnfinishedCashdesk()
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $result = $this->cashdeskService->inconsistencyUnfinishedCashdesk($store);
            return response()->json($result);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function extractOfDay(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
            $store = auth()->user()->getStore()->getId();
            $result = $this->cashdeskService->extractOfDay($date , $store);
            return response()->json($result);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
   
    public function moneyTransfer(Request $request)
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $result = $this->cashdeskService->moneyTransfer($request->all(), auth()->user(), $store);
            return response()->json($result);
        } catch (\Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
}
