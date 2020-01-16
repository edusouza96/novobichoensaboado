<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;

use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\ClientRepository;

class ClientController extends Controller
{
    /** @var ClientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function findByName($name)
    {
        try{
            $clients = $this->clientRepository->findByName($name);
            return response()->json($clients);
        }catch(\InvalidArgumentException  $e){
        }
    }

    public function create()
    {
        $client = $this->clientRepository->newInstance();
        return view('client.create', compact('client'));
    }

    public function store(Request $request)
    {
        try {
            $this->clientRepository->create($request->only());
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
