<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\ProductRepository;

class ProductController extends Controller
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function findByName($name)
    {
        try{
            $products = $this->productRepository->findByName($name);
            return response()->json($products);
        }catch(\InvalidArgumentException  $e){
        }
    }

}
