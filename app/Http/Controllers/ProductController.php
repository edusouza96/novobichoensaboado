<?php

namespace BichoEnsaboado\Http\Controllers;

use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Services\OutlayCreateService;
use BichoEnsaboado\Repositories\ProductRepository;
use BichoEnsaboado\Services\GenerateBarcodeService;
use BichoEnsaboado\Http\Requests\ProductCreateRequest;

class ProductController extends Controller
{
    /** @var ProductRepository */
    private $productRepository;
    
    /** @var GenerateBarcodeService */
    private $generateBarcodeService;
    
    /** @var OutlayCreateService */
    private $outlayCreateService;

    public function __construct(ProductRepository $productRepository, GenerateBarcodeService $generateBarcodeService, OutlayCreateService $outlayCreateService)
    {
        $this->productRepository = $productRepository;
        $this->generateBarcodeService = $generateBarcodeService;
        $this->outlayCreateService = $outlayCreateService;

    }

    public function findByName($name)
    {
        try{
            $products = $this->productRepository->findByName($name);
            return response()->json($products);
        }catch(\InvalidArgumentException $e){
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
        $barcode = $this->generateBarcodeService->generate();
        $product = $this->productRepository->newInstance();
        $product->setBarcode($barcode);
        return view('product.create', compact('product'));
    }

    public function store(ProductCreateRequest $request)
    {
        try {
            $this->productRepository->create($request->only('barcode', 'name','value_sales', 'value_buy', 'quantity'));
            
            if($request->has('has_outlay')) 
                $this->generateOulay($request->all());

            return redirect()->route('product.index')->with('alertType', 'success')->with('message', 'Produto Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        return view('product.edit', compact('product'));
    }
    
    public function barcode($id, $count = 1)
    {
        $product = $this->productRepository->find($id);
        return view('product.barcode', compact('product', 'count'));
    }

    public function update(ProductCreateRequest $request, $id)
    {
        try {
            $this->productRepository->update($id ,$request->only('barcode', 'name','value_sales', 'value_buy', 'quantity'));

            if($request->has('has_outlay')) 
                $this->generateOulay($request->all());

            return redirect()->route('product.index')->with('alertType', 'success')->with('message', 'Produto Atualizado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function lowQuantity()
    {
        try{
            $products = $this->productRepository->quantityLessThan();
            return response()->json($products);
        }catch(\InvalidArgumentException $e){
            dd($e->getMessage());
        }
    }

    private function generateOulay(array $attributesRequest)
    {
        $attributes = array(
            'date_pay' => date('Y-m-d'),
            'value' => $attributesRequest['value_outlay'],
            'paid' => true,
            'source' => $attributesRequest['source'],
            'description' => "Produto adicionado: ".$attributesRequest['name'],
            'cost_center' => $attributesRequest['cost_center'],
        );

        $store = auth()->user()->getStore()->getId();
        $this->outlayCreateService->create($attributes, auth()->user(), $store);
    }
}
