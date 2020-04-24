<?php

namespace BichoEnsaboado\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Services\GenerateExcelReport;
use BichoEnsaboado\Repositories\OutlayRepository;
use BichoEnsaboado\Presenters\ChartPetsAttendedPresenter;
use BichoEnsaboado\Presenters\ChartSalesByPeriodPresenter;
use BichoEnsaboado\Presenters\ChartOutlayByPeriodPresenter;
use BichoEnsaboado\Presenters\ChartSearchesByPeriodPresenter;
use BichoEnsaboado\Presenters\ReportFinancialStatementPresenter;

class ReportController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;

    /** @var OutlayRepository */
    private $outlayRepository;
    
    /** @var SaleRepository */
    private $saleRepository;

    public function __construct(DiaryRepository $diaryRepository, OutlayRepository $outlayRepository, SaleRepository $saleRepository)
    {
        $this->diaryRepository = $diaryRepository;
        $this->outlayRepository = $outlayRepository;
        $this->saleRepository = $saleRepository;
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

    public function salesByPeriod(Request $request)
    {
        $report = $this->saleRepository->reportSalesByPeriod($request->all(), true);
        $sum = $this->saleRepository->reportSalesByPeriod($request->all(), false)->sum('total');
        return view('report.salesByPeriod', compact('report', 'sum'));
    }
    
    public function salesByPeriodExcel(Request $request)
    {
        $report = $this->saleRepository->reportSalesByPeriod($request->all(), false);
        return Excel::download(new GenerateExcelReport($report, 'report.excel.salesByPeriod'), 'RELATORIO_VENDAS_POR_PERIODO.xlsx');
    }
    
    public function salesByPeriodChart(Request $request)
    {
        $report = $this->saleRepository->reportSalesByPeriod($request->all(), false);
        return new ChartSalesByPeriodPresenter($report);
    }
    
    public function financialStatement(Request $request)
    {
        $outlays = $this->outlayRepository->reportOutlayByPeriod($request->all(), false);
        $sales = $this->saleRepository->reportSalesByPeriod($request->all(), false);

        $report = (new ReportFinancialStatementPresenter($outlays, $sales))->getByYear();
        
        return view('report.financialStatement', compact('report'));
    }
    
    public function financialStatementExcel(Request $request)
    {
        $outlays = $this->outlayRepository->reportOutlayByPeriod($request->all(), false);
        $sales = $this->saleRepository->reportSalesByPeriod($request->all(), false);

        $report = (new ReportFinancialStatementPresenter($outlays, $sales))->get();

        return Excel::download(new GenerateExcelReport($report, 'report.excel.financialStatement'), 'RELATORIO_BALANÇO_FINANCEIRO.xlsx');
    }
    
    public function financialStatementChart(Request $request)
    {
        $outlays = $this->outlayRepository->reportOutlayByPeriod($request->all(), false);
        $sales = $this->saleRepository->reportSalesByPeriod($request->all(), false);

        return (new ReportFinancialStatementPresenter($outlays, $sales))->getForChart();
    }

}