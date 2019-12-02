<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use BichoEnsaboado\Repositories\SaleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use BichoEnsaboado\Services\SalesOfDay\CollectionSales;

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
            $sales = $this->saleRepository->findByDate($date, $this->store);
            return response()->json($sales);
        } catch (Exception $ex) {
            dd('erro');
        }
    }

    public function ofDay(Request $request)
    {
        try {
            $salesPaginator = $this->saleRepository->findByFilter($request->all(), true);
            dd($salesPaginator->toArray()['data']);
            $sales = ($salesPaginator->toArray());
            $sales = new CollectionSales(collect($sales));
            $sales = $sales->list();
            $total = 0; //$sales->sum('total');
            $cash = 0; //$sales->where('payment_method_id', PaymentMethodsType::CASH)->sum('total');
            $creditCard = 0; //$sales->where('payment_method_id', PaymentMethodsType::CREDIT_CARD)->sum('total');
            $debitCard = 0; //$sales->where('payment_method_id', PaymentMethodsType::DEBIT_CARD)->sum('total');

            return view('sales.of-day', compact('sales', 'total', 'cash', 'creditCard', 'debitCard'));
        } catch (Exception $ex) {
            dd('erro');
        }
    }

    public function paginate($items, $request)
    {
        $perPage = 15;
        $page = $request->page;
        $parameters = explode('&',$request->getQueryString());
        foreach ($parameters as $key=> $value) {

            if(strpos($value, 'page')){
                $parameters[$key] = null;
            }
        }
        dd( $request->fullUrl());
        $options = ['path' => $request->getPathInfo(), 'query' => $parameters];
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
