<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Services\BuySearchService;
use BichoEnsaboado\Services\SaleCreateService;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Presenters\InvoicePresenter;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\DiaryRepository;
use Illuminate\Database\DatabaseManager;

class PdvController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;
   
    /** @var SaleRepository */
    private $saleRepository;

    /** @var SaleCreateService */
    private $saleCreateService;
    
    /** @var BuySearchService */
    private $buySearchService;
    
    /** @var DatabaseManager */
    private $db;

    public function __construct(
        DiaryRepository $diaryRepository, 
        SaleRepository $saleRepository,
        SaleCreateService $saleCreateService, 
        BuySearchService $buySearchService,
        DatabaseManager $db
    )
    {
        $this->diaryRepository = $diaryRepository;
        $this->saleRepository = $saleRepository;
        $this->saleCreateService = $saleCreateService;
        $this->buySearchService = $buySearchService;
        $this->db = $db;
    }
   
    public function index($id = null)
    {
        try {
            $ids = null;

            if($id){
                $diary = $this->diaryRepository->find($id);
                $diaries = $this->buySearchService->getDiariesSameOwner($diary);
                $ids = $diaries->pluck('id');
            }

            return view('pdv.index', compact('ids'));
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', '');
        }
    }

    public function getBuys($ids)
    {
        try {
            $buys = $this->buySearchService->getBuys(explode(',', $ids));
            return response()->json($buys);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function registerPayment(Request $request)
    {
        $this->db->beginTransaction();
        try {
            $store = auth()->user()->getStore()->getId();
            $id = $this->saleCreateService->create($request->all(), auth()->user(), $store);
            
            if($request->get('diariesId'))
                $this->diaryRepository->paid($request->get('diariesId'));
                
            $this->db->commit();
            return response(['id'=> $id], 201);
        } catch (\Exception $ex) {
            $this->db->rollback();
            dd($ex->getMessage());
        }
    }

    public function invoice($id)
    {
        try{
            $sale = $this->saleRepository->find($id);
            $sale = new InvoicePresenter($sale);
            return view('pdv.invoice', compact('sale'));
        }catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', 'Não Encontrado Registro de Venda');
        }
    }

   
}
