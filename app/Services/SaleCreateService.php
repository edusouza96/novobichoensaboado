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
use BichoEnsaboado\Repositories\SalePaymentMethodRepository;

class SaleCreateService
{

    private $saleRepository;
    private $diaryRepository;
    private $productRepository;
    private $cashBookMoveService;
    private $salePaymentMethodRepository;

    public function __construct(
        SaleRepository $saleRepository, 
        SalePaymentMethodRepository $salePaymentMethodRepository,
        DiaryRepository $diaryRepository, 
        ProductRepository $productRepository,
        CashBookMoveService $cashBookMoveService
    )
    {
        $this->saleRepository =  $saleRepository;
        $this->diaryRepository = $diaryRepository;
        $this->productRepository = $productRepository;
        $this->cashBookMoveService = $cashBookMoveService;
        $this->salePaymentMethodRepository = $salePaymentMethodRepository;

    }

    public function create(array $attributes, User $userLogged, $store)
    {
        $hasSecondMethod = filter_var($attributes['hasSecondMethod'],FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE);

        $sale = $this->saleRepository->save(
            $attributes['amountSale'],
            $attributes['promotionValue'],
            $userLogged, 
            $store
        );

        if($attributes['rebate'])  $this->saleRepository->attachRebate($sale, $attributes['rebate']);

        $diariesId = isset($attributes['diariesId']) ? $attributes['diariesId'] : [];
        foreach ($diariesId as $diaryId) {
            $this->attachDiary($sale, $diaryId);
        }

        $products = collect($attributes['products']);
        $this->attachProduct($sale, $products);

        $source = $this->defineSource($attributes['paymentMethod'], $attributes['cardMachine']);
        $sourceName = SourceType::getName($source);
        $value = $hasSecondMethod ? $attributes['valueReceived'] : $this->applyPromotion($attributes['amountSale'], $attributes['promotionValue']);
        $cashBookMove = $this->cashBookMoveService->generateMovementEntry($value, $sourceName, $store, $source, $userLogged);

        $this->salePaymentMethodRepository->save(
            $sale, 
            $attributes['valueReceived'],
            $attributes['leftover'],
            $attributes['paymentMethod'],
            $attributes['plots'],
            $cashBookMove
        );
        
        if($hasSecondMethod){
            $source = $this->defineSource($attributes['paymentMethod2'], $attributes['cardMachine2']);
            $sourceName = SourceType::getName($source);
            $cashBookMove = $this->cashBookMoveService->generateMovementEntry(abs($attributes['leftover']), $sourceName, $store, $source, $userLogged);

            $this->salePaymentMethodRepository->save(
                $sale, 
                $attributes['valueReceived2'],
                $attributes['leftover2'],
                $attributes['paymentMethod2'],
                $attributes['plots2'],
                $cashBookMove
            );
        }

        return $sale->getId();

    }

    private function applyPromotion($value, $promotion)
    {
        return $value - $promotion;
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