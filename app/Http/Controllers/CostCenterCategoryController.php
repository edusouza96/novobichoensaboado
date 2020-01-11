<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\CostCenterCategoryRepository;

class CostCenterCategoryController extends Controller
{
    private $costCenterCategoryRepository;

    public function __construct(CostCenterCategoryRepository $costCenterCategoryRepository)
    {
        $this->costCenterCategoryRepository = $costCenterCategoryRepository;
    }

    public function allOptions()
    {
        try {
            $costCenterCategory = $this->costCenterCategoryRepository->all();
            return response()->json($costCenterCategory);
        } catch (\InvalidArgumentException $e) {
        }
    }

}
