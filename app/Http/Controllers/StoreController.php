<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\StoreRepository;
use BichoEnsaboado\Http\Requests\StoreCreateRequest;

class StoreController extends Controller
{

    /** @var StoreRepository */
    private $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function create()
    {
        $store = $this->storeRepository->newInstance();
        return view('store.create', compact('store'));
    }

    public function store(StoreCreateRequest $request)
    {
        try {
            $this->storeRepository->create($request->only('name', 'phone', 'email', 'address', 'inauguration_date'));
            return redirect()->route('store.index')->with('alertType', 'success')->with('message', 'Loja Cadastrada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
}
