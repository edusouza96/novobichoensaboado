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

    public function index(Request $request)
    {
        $products = $this->productRepository->findByFilter($request->all(), true);
        return view('product.index', compact('products'));
    }

    public function destroy($id)
    {
        try {
            $this->productRepository->destroy($id);
            return redirect()->route('product.index')->with('alertType', 'success')->with('message', 'Produto Deletado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }
}
