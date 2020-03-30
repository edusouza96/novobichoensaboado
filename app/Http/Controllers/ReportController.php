<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\DiaryRepository;

class ReportController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;

    public function __construct(DiaryRepository $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }
   
    public function searchesbyPeriod(Request $request)
    {
        $report = $this->diaryRepository->reportSearchesbyPeriod($request->all(), true);
        $sumDeliveryFee = $this->diaryRepository->reportSearchesbyPeriod($request->all(), false)->sum('delivery_fee');
        return view('report.searchesbyPeriod', compact('report', 'sumDeliveryFee'));
    }

    
   
}
