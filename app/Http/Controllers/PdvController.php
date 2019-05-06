<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\ServiceRepository;

class PdvController extends Controller
{
    /** @var ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

   
    public function index()
    {
        dd('hue');
    }

   
}
