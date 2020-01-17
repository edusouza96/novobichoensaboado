<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\NeighborhoodRepository;
use BichoEnsaboado\Http\Requests\NeighborhoodCreateRequest;

class NeighborhoodController extends Controller
{
    private $neighborhoodRepository;

    public function __construct(NeighborhoodRepository $neighborhoodRepository)
    {
        $this->neighborhoodRepository = $neighborhoodRepository;
    }

    public function index(Request $request)
    {
        $neighborhoods = $this->neighborhoodRepository->findByFilter($request->all(), true);
        return view('neighborhood.index', compact('neighborhoods'));
    }

    public function create()
    {
        $neighborhood = $this->neighborhoodRepository->newInstance();
        return view('neighborhood.create', compact('neighborhood'));
    }

    public function store(NeighborhoodCreateRequest $request)
    {
        try {
            $this->neighborhoodRepository->create($request->only('name', 'value'));
            return redirect()->route('neighborhood.index')->with('alertType', 'success')->with('message', 'Bairro Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $neighborhood = $this->neighborhoodRepository->find($id);
        return view('neighborhood.edit', compact('neighborhood'));
    }

    public function update(NeighborhoodCreateRequest $request, $id)
    {
        try {
            $this->neighborhoodRepository->update($id, $request->only('name', 'value'));
            return redirect()->route('neighborhood.index')->with('alertType', 'success')->with('message', 'Bairro Atualizado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->neighborhoodRepository->destroy($id);
            return redirect()->route('neighborhood.index')->with('alertType', 'success')->with('message', 'Bairro Deletado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }

    public function allOptions()
    {
        try {
            $neighborhoods = $this->neighborhoodRepository->all();
            return response()->json($neighborhoods);
        } catch (\InvalidArgumentException $e) {
        }
    }
}
