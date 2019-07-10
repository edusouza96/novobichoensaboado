<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Services\SaleCreateService;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Presenters\InvoicePresenter;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Repositories\DiaryRepository;

class PdvController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;
   
    /** @var SaleRepository */
    private $saleRepository;

    /** @var SaleCreateService */
    private $saleCreateService;

    /** @var UserRepository */
    private $userRepository;
    private $user;
    private $store = 1;

    public function __construct(
        DiaryRepository $diaryRepository, 
        SaleRepository $saleRepository,
        SaleCreateService $saleCreateService, 
        UserRepository $userRepository
    )
    {
        $this->diaryRepository = $diaryRepository;
        $this->saleRepository = $saleRepository;
        $this->saleCreateService = $saleCreateService;
        $this->userRepository = $userRepository;
        $this->user = $this->userRepository->find(1);
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
        $id = $this->saleCreateService->create($request->all(), $this->user, $this->store);
        return response(['id'=> $id], 201);
    }

    public function invoice($id)
    {
        $sale = $this->saleRepository->find($id);
        $sale = new InvoicePresenter($sale);
        return view('pdv.invoice', compact('sale'));
    }

   
}
