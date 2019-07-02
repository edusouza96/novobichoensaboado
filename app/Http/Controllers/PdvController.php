<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Services\SaleCreateService;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\DiaryRepository;

class PdvController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;

    /** @var SaleCreateService */
    private $saleCreateService;

    public function __construct(DiaryRepository $diaryRepository, SaleCreateService $saleCreateService)
    {
        $this->diaryRepository = $diaryRepository;
        $this->saleCreateService = $saleCreateService;
    }
   
    public function index($id = null)
    {
        try {
            $diary = is_null($id) ? null : $this->diaryRepository->find($id);

            $jsonPet = $diary ? $diary->toJsonPet() : null;
            $jsonVet = $diary ? $diary->toJsonVet() : null;
            $jsonDeliveryFee = $diary ? $diary->toJsonDeliveryFee() : null;
            
            return view('pdv.index', compact('jsonPet', 'jsonVet', 'jsonDeliveryFee', 'id'));
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', '');
        }
    }

    public function registerPayment(Request $request)
    {
        $this->saleCreateService->create($request->all());
        return response(['id'=> '123'], 201);
    }

    public function invoice($id)
    {
        dd('nota fiscal');
    }

   
}
