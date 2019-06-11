<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\RebateRepository;

class RebateController extends Controller
{
    /** @var RebateRepository */
    private $rebateRepository;

    public function __construct(RebateRepository $rebateRepository)
    {
        $this->rebateRepository = $rebateRepository;
    }
   
    public function findAll()
    {
        try{
            $rebates = $this->rebateRepository->all();
            return response()->json($rebates);
        }catch(\InvalidArgumentException  $e){
        }
    }

   
}
