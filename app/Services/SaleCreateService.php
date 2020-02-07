<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\User;
use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\ServicesType;
use BichoEnsaboado\Enums\PaymentMethodsType;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Services\CashBookMoveService;
use BichoEnsaboado\Repositories\ProductRepository;

class SaleCreateService
{

    private $saleRepository;
    private $diaryRepository;
    private $productRepository;
    private $cashBookMoveService;

    public function __construct(
        SaleRepository $saleRepository, 
        DiaryRepository $diaryRepository, 
        ProductRepository $productRepository,
        CashBookMoveService $cashBookMoveService
    )
    {
        $this->saleRepository =  $saleRepository;
        $this->diaryRepository = $diaryRepository;
        $this->productRepository = $productRepository;
        $this->cashBookMoveService = $cashBookMoveService;

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

        $diariesId = isset($attributes['diariesId']) ? $attributes['diariesId'] : [];
        foreach ($diariesId as $diaryId) {
            $this->attachDiary($sale, $diaryId);
        }

        $products = collect($attributes['products']);
        $this->attachProduct($sale, $products);
        
        $source = $this->defineSource($attributes['paymentMethod'], $attributes['cardMachine']);
        $sourceName = SourceType::getName($source);
        $this->cashBookMoveService->generateMovementEntry($attributes['amountSale'], $sourceName, $store, $source, $userLogged);
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
            $this->productRepository->writeOffInventory($productAttributes['id'], $productAttributes['units']);
        }
    }

    private function defineSource($paymentMethod, $cardMachine)
    {
        if($paymentMethod == PaymentMethodsType::CASH) return SourceType::CASH_DRAWER;
        if($cardMachine == SourceType::PAGSEGURO) return SourceType::PAGSEGURO;
    }
}