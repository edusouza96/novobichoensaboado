<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\NeighborhoodRepository;

class NeighborhoodController extends Controller
{
    private $neighborhoodRepository;

    public function __construct(NeighborhoodRepository $neighborhoodRepository)
    {
        $this->neighborhoodRepository = $neighborhoodRepository;
    }

    public function index(Request $request)
    {
        $neighborhoods = $this->neighborhoodRepository->findByFilter($request->all(), true);
        return view('neighborhood.index', compact('neighborhoods'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
