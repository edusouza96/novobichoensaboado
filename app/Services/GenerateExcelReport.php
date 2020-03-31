<?php

namespace BichoEnsaboado\Services;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GenerateExcelReport implements FromView, ShouldAutoSize
{
    private $report;
    private $view;

    public function __construct(Collection $report, $view)
    {
        $this->report = $report;
        $this->view = $view;
    }

    public function view(): View 
    {
        return view($this->view, [
            'report' => $this->report
        ]);
    }
  
}