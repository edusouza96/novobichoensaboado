<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Repositories\ProductRepository;

class GenerateBarcodeService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

   
    public function generate()
    {
        $product = $this->productRepository->last();
        $barcode = $product->getBarcode();
        $code = (int) str_replace('BE', '', $barcode);
        return 'BE'.($code+1);
    }
}