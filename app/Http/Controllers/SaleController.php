<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use BichoEnsaboado\Enums\PaymentMethodsType;
use BichoEnsaboado\Repositories\SaleRepository;

class SaleController extends Controller
{
    private $saleRepository;
    private $store = 1;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function findByDate(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
            $sales = $this->saleRepository->findByDate($date , $this->store);
            return response()->json($sales);
        } catch (Exception $ex) {
            dd('erro');
        }
    }

    public function ofDay(Request $request)
    {
        try {
            $sales = $this->saleRepository->findByFilter($request->all(), true);

            $total = $sales->sum('total');
            $cash = $sales->where('payment_method_id', PaymentMethodsType::CASH)->sum('total');
            $creditCard = $sales->where('payment_method_id', PaymentMethodsType::CREDIT_CARD)->sum('total');
            $debitCard = $sales->where('payment_method_id', PaymentMethodsType::DEBIT_CARD)->sum('total');

            return view('sales.of-day', compact('sales', 'total', 'cash', 'creditCard', 'debitCard'));
        } catch (Exception $ex) {
            dd('erro');
        }
    }
}