<?php

namespace BichoEnsaboado\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Services\GenerateExcelReport;
use BichoEnsaboado\Presenters\ChartSearchesByPeriodPresenter;
use BichoEnsaboado\Presenters\ChartPetsAttendedByPeriodPresenter;

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
    
    public function searchesbyPeriodChart(Request $request)
    {
        $report = $this->diaryRepository->reportSearchesbyPeriod($request->all(), false);
        return new ChartSearchesByPeriodPresenter($report);
    }
   
    public function petsAttendedByNeighborhood(Request $request)
    {
        $report = $this->diaryRepository->reportPetsAttendedByNeighborhood($request->all(), true);
        return view('report.petsAttendedByNeighborhood', compact('report'));
    }
    
    public function petsAttendedByNeighborhoodExcel(Request $request)
    {
        $report = $this->diaryRepository->reportPetsAttendedByNeighborhood($request->all(), false);
        return Excel::download(new GenerateExcelReport($report, 'report.excel.petsAttendedByNeighborhood'), 'RELATORIO_ATENDIMENTOS_POR_PERIODO.xlsx');
    }
    
    public function petsAttendedByNeighborhoodChart(Request $request)
    {
        $report = $this->diaryRepository->reportPetsAttendedByNeighborhood($request->all(), false);
        return new ChartPetsAttendedByPeriodPresenter($report);
    }



   
}