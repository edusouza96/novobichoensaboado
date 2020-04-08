<?php

namespace BichoEnsaboado\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Services\GenerateExcelReport;
use BichoEnsaboado\Repositories\OutlayRepository;
use BichoEnsaboado\Presenters\ChartPetsAttendedPresenter;
use BichoEnsaboado\Presenters\ChartOutlayByPeriodPresenter;
use BichoEnsaboado\Presenters\ChartSearchesByPeriodPresenter;

class ReportController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;

    /** @var OutlayRepository */
    private $outlayRepository;

    public function __construct(DiaryRepository $diaryRepository, OutlayRepository $outlayRepository)
    {
        $this->diaryRepository = $diaryRepository;
        $this->outlayRepository = $outlayRepository;
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
        return new ChartPetsAttendedPresenter($report);
    }
   
    public function petsAttendedByBreed(Request $request)
    {
        $report = $this->diaryRepository->reportPetsAttendedByBreed($request->all(), true);
        return view('report.petsAttendedByBreed', compact('report'));
    }
    
    public function petsAttendedByBreedExcel(Request $request)
    {
        $report = $this->diaryRepository->reportPetsAttendedByBreed($request->all(), false);
        return Excel::download(new GenerateExcelReport($report, 'report.excel.petsAttendedByBreed'), 'RELATORIO_ATENDIMENTOS_POR_RAÇA.xlsx');
    }
    
    public function petsAttendedByBreedChart(Request $request)
    {
        $report = $this->diaryRepository->reportPetsAttendedByBreed($request->all(), false);
        return new ChartPetsAttendedPresenter($report);
    }
    
    public function outlayByPeriod(Request $request)
    {
        $report = $this->outlayRepository->reportOutlayByPeriod($request->all(), true);
        $sum = $this->outlayRepository->reportOutlayByPeriod($request->all(), false)->sum('value');
        return view('report.outlayByPeriod', compact('report', 'sum'));
    }
    
    public function outlayByPeriodExcel(Request $request)
    {
        $report = $this->outlayRepository->reportOutlayByPeriod($request->all(), false);
        return Excel::download(new GenerateExcelReport($report, 'report.excel.outlayByPeriod'), 'RELATORIO_DESPESAS_POR_PERIODO.xlsx');
    }
    
    public function outlayByPeriodChart(Request $request)
    {
        $report = $this->outlayRepository->reportOutlayByPeriod($request->all(), false);
        return new ChartOutlayByPeriodPresenter($report);
    }


   
}