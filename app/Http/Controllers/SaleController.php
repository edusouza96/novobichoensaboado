<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use BichoEnsaboado\Enums\ServicesType;
use BichoEnsaboado\Enums\PaymentMethodsType;
use BichoEnsaboado\Services\ChargebackService;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Presenters\SaleItemPresenter;

class SaleController extends Controller
{
    private $saleRepository;
    private $chargebackService;
    private $store = 1;
    private $userRepository;
    private $user;

    public function __construct(SaleRepository $saleRepository, ChargebackService $chargebackService, UserRepository $userRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->chargebackService = $chargebackService;
        $this->userRepository = $userRepository;
        $this->user = $this->userRepository->find(1);
    }

    public function chargeback(Request $request)
    {
        $sale = $this->chargebackService->make($request->item_id, $request->type, $this->user, $this->store);
        return response()->json($sale);
    }

    public function findByDate(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
            $sales = $this->saleRepository->findByDate($date , $this->store);
            return response()->json($sales);
        } catch (Exception $ex) {
            dd('erro SaleController::findByDate');
        }
    }

    public function ofDay(Request $request)
    {
        try {
            $sales = $this->saleRepository->findByFilter($request->all(), true, true);
            $salesToCalc = $this->saleRepository->findByFilter($request->all(), true, false);

            $total = $salesToCalc->sum('total');
            $cash = 0;
            $creditCard = 0;
            $debitCard = 0;

            foreach ($salesToCalc as $sale) {
                foreach ($sale->getSalePaymentMethod() as $paymentMethod) {
                    if($paymentMethod->getPaymentMethodId() == PaymentMethodsType::CASH)
                        $cash += $paymentMethod->getValueReceived() - $paymentMethod->getLeftover();
                    
                    if($paymentMethod->getPaymentMethodId() == PaymentMethodsType::CREDIT_CARD)
                        $creditCard += $paymentMethod->getValueReceived();
                    
                    if($paymentMethod->getPaymentMethodId() == PaymentMethodsType::DEBIT_CARD)
                        $debitCard += $paymentMethod->getValueReceived();

                }
            }
             
            return view('sales.of-day', compact('sales', 'total', 'cash', 'creditCard', 'debitCard'));
        } catch (Exception $ex) {
            dd('erro SaleController::ofDay');
        }
    }

    public function itemsBySale($id)
    {
        $sale = $this->saleRepository->find($id);
        $saleItems = $sale->getProducts()->map(function($product){
            return new SaleItemPresenter($product, ServicesType::PRODUCTS);
        });

        foreach ($sale->getDiary() as $diary) {
            if($diary->getServicePet())
                $saleItems->push(new SaleItemPresenter($diary, ServicesType::PET));

            if($diary->getServiceVet())
                $saleItems->push(new SaleItemPresenter($diary, ServicesType::VET));
                
            if($diary->getFetch())
                $saleItems->push(new SaleItemPresenter($diary, ServicesType::DELIVERY_FEE));
                
        }

        return response()->json($saleItems);
    }
}