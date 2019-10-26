<?php

namespace BichoEnsaboado\Http\Controllers;

use BichoEnsaboado\Repositories\CostCenterRepository;

class CostCenterController extends Controller
{
    private $costCenterRepository;

    public function __construct(CostCenterRepository $costCenterRepository)
    {
        $this->costCenterRepository = $costCenterRepository;
    }

    public function allOptions()
    {
        try {
            $costCenter = $this->costCenterRepository->all();
            return response()->json($costCenter);
        } catch (\InvalidArgumentException $e) {
        }
    }
}
