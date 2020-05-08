<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\StoreRepository;
use BichoEnsaboado\Services\TreasureByStoreService;
use BichoEnsaboado\Http\Requests\StoreCreateRequest;

class StoreController extends Controller
{

    /** @var StoreRepository */
    private $storeRepository;
    
    /** @var TreasureByStoreService */
    private $treasureByStoreService;

    public function __construct(StoreRepository $storeRepository, TreasureByStoreService $treasureByStoreService)
    {
        $this->storeRepository = $storeRepository;
        $this->treasureByStoreService = $treasureByStoreService;
    }

    public function index(Request $request)
    {
        $stores = $this->storeRepository->findByFilter($request->all(), true);
        return view('store.index', compact('stores'));
    }

    public function create()
    {
        $store = $this->storeRepository->newInstance();
        return view('store.create', compact('store'));
    }

    public function store(StoreCreateRequest $request)
    {
        try {
            $store = $this->storeRepository->create($request->only('name', 'phone', 'email', 'address', 'inauguration_date'));
            $this->treasureByStoreService->createInitialSource($store);
            return redirect()->route('store.index')->with('alertType', 'success')->with('message', 'Loja Cadastrada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $store = $this->storeRepository->find($id);
        return view('store.edit', compact('store'));
    }

    public function update(StoreCreateRequest $request, $id)
    {
        try {
            $this->storeRepository->update($id, $request->only('name', 'phone', 'email', 'address', 'inauguration_date'));
            return redirect()->route('store.index')->with('alertType', 'success')->with('message', 'Loja Atualizada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->storeRepository->destroy($id);
            $this->treasureByStoreService->deleteByStore($id);
            return redirect()->route('store.index')->with('alertType', 'success')->with('message', 'Loja Deletada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }

    public function allOptions()
    {
        try {
            $store = $this->storeRepository->all();
            return response()->json($store);
        } catch (\InvalidArgumentException $e) {
        }
    }
}
