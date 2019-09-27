<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Services\CashdeskService;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Http\Requests\OpenCashdeskRequest;

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

    public function open(OpenCashdeskRequest $request)
    {
        try {
            $cashbook = $this->cashdeskService->open($request->all(), $this->user, $this->store);
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
}
