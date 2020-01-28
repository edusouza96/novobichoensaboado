<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\ProductRepository;
use BichoEnsaboado\Http\Requests\ProductCreateRequest;

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

    public function create()
    {
        $product = $this->productRepository->newInstance();
        return view('product.create', compact('product'));
    }

    public function store(ProductCreateRequest $request)
    {
        try {
            $this->productRepository->create($request->only('barcode', 'name','value_sales', 'value_buy', 'quantity'));
            return redirect()->route('product.index')->with('alertType', 'success')->with('message', 'Produto Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }
}
