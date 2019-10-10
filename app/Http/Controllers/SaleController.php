<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
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
}
