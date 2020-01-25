<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\ServiceRepository;
use BichoEnsaboado\Http\Requests\ServiceCreateRequest;

class ServiceController extends Controller
{
    /** @var ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function findByBreed($id)
    {
        try{
            $services = $this->serviceRepository->findByBreed($id);
            return response()->json($services);
        }catch(\InvalidArgumentException  $e){
        }
    }
    
    public function allVet()
    {
        try{
            $services = $this->serviceRepository->allVet();
            return response()->json($services);
        }catch(\InvalidArgumentException  $e){
        }
    }
    
    public function index(Request $request)
    {
        $services = $this->serviceRepository->findByFilter($request->all(), true);
        return view('service.index', compact('services'));
    }

    public function create()
    {
        $service = $this->serviceRepository->newInstance();
        return view('service.create', compact('service'));
    }

    public function store(ServiceCreateRequest $request)
    {
        try {
            $this->serviceRepository->create($request->only('name', 'value','breed_id', 'package_type_id', 'pet', 'vet'));
            return redirect()->route('service.index')->with('alertType', 'success')->with('message', 'Serviço Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
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
            $this->serviceRepository->destroy($id);
            return redirect()->route('service.index')->with('alertType', 'success')->with('message', 'Serviço Deletado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }
}
