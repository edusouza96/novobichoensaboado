<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\BreedRepository;
use BichoEnsaboado\Http\Requests\BreedCreateRequest;

class BreedController extends Controller
{
    private $breedRepository;

    public function __construct(BreedRepository $breedRepository)
    {
        $this->breedRepository = $breedRepository;
    }

    public function index(Request $request)
    {
        $breeds = $this->breedRepository->findByFilter($request->all(), true);
        return view('breed.index', compact('breeds'));
    }

    public function allOptions()
    {
        try {
            $breeds = $this->breedRepository->all();
            return response()->json($breeds);
        } catch (\InvalidArgumentException $e) {
        }
    }

    public function create()
    {
        $breed = $this->breedRepository->newInstance();
        return view('breed.create', compact('breed'));
    }

    public function store(BreedCreateRequest $request)
    {
        try {
            $this->breedRepository->create($request->only('name'));
            return redirect()->route('breed.index')->with('alertType', 'success')->with('message', 'Raça Cadastrada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $breed = $this->breedRepository->find($id);
        return view('breed.edit', compact('breed'));
    }

    public function update(BreedCreateRequest $request, $id)
    {
        try {
            $this->breedRepository->update($id, $request->only('name'));
            return redirect()->route('breed.index')->with('alertType', 'success')->with('message', 'Raça Atualizada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->breedRepository->destroy($id);
            return redirect()->route('breed.index')->with('alertType', 'success')->with('message', 'Raça Deletada.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }
}
