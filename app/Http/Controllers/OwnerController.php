<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\OwnerRepository;
use BichoEnsaboado\Http\Requests\OwnerCreateRequest;

class OwnerController extends Controller
{

    /** @var OwnerRepository */
    private $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function index(Request $request)
    {
        $owners = $this->ownerRepository->findByFilter($request->all(), true);
        return view('owner.index', compact('owners'));
    }

    public function myPets($id)
    {
        try{
            $pets = $this->ownerRepository->myPets($id);
            return response()->json($pets);
        }catch(\InvalidArgumentException  $e){
        }
    }

    public function create()
    {
        $owner = $this->ownerRepository->newInstance();
        return view('owner.create', compact('owner'));
    }

    public function store(OwnerCreateRequest $request)
    {
        try {
            $this->ownerRepository->create($request->only('name', 'cpf', 'email'));
            return redirect()->route('owner.index')->with('alertType', 'success')->with('message', 'Cliente Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $owner = $this->ownerRepository->find($id);
        return view('owner.edit', compact('owner'));
    }

    public function update(OwnerCreateRequest $request, $id)
    {
        try {
            $this->ownerRepository->update($id, $request->only('name', 'cpf', 'email'));
            return redirect()->route('owner.index')->with('alertType', 'success')->with('message', 'Cliente Atualizado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->ownerRepository->destroy($id);
            return redirect()->route('owner.index')->with('alertType', 'success')->with('message', 'Cliente Deletado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }
}
