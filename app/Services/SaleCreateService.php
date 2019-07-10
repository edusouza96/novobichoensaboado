<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\User;
use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\ServicesType;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Repositories\ProductRepository;

class SaleCreateService
{

    /** @var SaleRepository */
    private $saleRepository;

    /** @var DiaryRepository */
    private $diaryRepository;
    
    /** @var ProductRepository */
    private $productRepository;
 

    public function __construct(SaleRepository $saleRepository, DiaryRepository $diaryRepository, ProductRepository $productRepository)
    {
        $this->saleRepository =  $saleRepository;
        $this->diaryRepository = $diaryRepository;
        $this->productRepository = $productRepository;

    }

    public function create(array $attributes, User $userLogged, $store)
    {
        $sale = $this->saleRepository->save(
            $attributes['valueReceived'],
            $attributes['leftover'],
            $attributes['amountSale'],
            $attributes['paymentMethod'],
            $attributes['plots'],
            $attributes['promotionValue'],
            $userLogged, 
            $store
        );

        $this->attachDiary($sale, $attributes['diaryId']);

        $products = collect($attributes['products']);
        $this->attachProduct($sale, $products);
        
        return $sale->getId();

    }

    private function attachDiary(Sale $sale, $diaryId = null)
    {
        if(is_null($diaryId)) return false;

        $diary = $this->diaryRepository->find($diaryId);
        $this->saleRepository->attachDiary($sale, $diary);
    }

    private function attachProduct(Sale $sale, Collection $products)
    {
        $products = $products->where('type', ServicesType::PRODUCTS);

        foreach ($products as $productAttributes) {
            $product = $this->productRepository->find($productAttributes['id']);
            $product->quantity = $productAttributes['units'];
            $this->saleRepository->attachProduct($sale, $product);
        }
    }
}