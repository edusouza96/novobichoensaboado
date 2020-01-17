<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;

use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\OwnerRepository;
use BichoEnsaboado\Repositories\ClientRepository;
use BichoEnsaboado\Http\Requests\ClientCreateRequest;

class ClientController extends Controller
{
    /** @var ClientRepository */
    private $clientRepository;
    
    /** @var OwnerRepository */
    private $ownerRepository;

    public function __construct(ClientRepository $clientRepository, OwnerRepository $ownerRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->ownerRepository = $ownerRepository;
    }

    public function findByName($name)
    {
        try{
            $clients = $this->clientRepository->findByName($name);
            return response()->json($clients);
        }catch(\InvalidArgumentException  $e){
        }
    }

    public function create($id)
    {
        $owner = $this->ownerRepository->find($id);
        $client = $this->clientRepository->newInstance();
        $client->owner = $owner;
        return view('client.create', compact('client'));
    }

    public function store(ClientCreateRequest $request)
    {
        try {
            $this->clientRepository->create($request->only('owner_name', 'owner_id', 'name', 'breed_id', 'neighborhood_id', 'address', 'phone1', 'phone2', 'email'));
            return redirect()->route('owner.index')->with('alertType', 'success')->with('message', 'Pet Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            $this->clientRepository->destroy($id);
            return redirect()->route('owner.index')->with('alertType', 'success')->with('message', 'Pet Deletado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }
}
