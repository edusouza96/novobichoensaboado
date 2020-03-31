<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Services\GenerateExcelReport;

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
    
    public function searchesbyPeriodExcel(Request $request)
    {
        $report = $this->diaryRepository->reportSearchesbyPeriod($request->all(), false);
        return Excel::download(new GenerateExcelReport($report, 'report.excel.searchesbyPeriod'), 'RELATORIO_BUSCAS_POR_PERIODO.xlsx');
    }

    
   
}
