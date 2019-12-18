<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Models\User;
use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\ServicesType;
use BichoEnsaboado\Enums\PaymentMethodsType;
use BichoEnsaboado\Repositories\SaleRepository;
use BichoEnsaboado\Services\CashBookMoveService;
use BichoEnsaboado\Repositories\OutlayRepository;

class chargebackService
{
    private $saleRepository;
    private $cashBookMoveService;
    private $outlayRepository;

    public function __construct(SaleRepository $saleRepository, CashBookMoveService $cashBookMoveService, OutlayRepository $outlayRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->cashBookMoveService = $cashBookMoveService;
        $this->outlayRepository = $outlayRepository;

    }

    public function make($id, $type, $user, $store)
    {
        switch ($type) {
            case ServicesType::PRODUCTS:
                $sale = $this->searchInformationsAboutSaleProduct($id);
                $this->deleteProduct($id, $sale->get('item_sale_id'));
                break;

            case ServicesType::PET:
                $sale = $this->searchInformationsAboutSalePet($id);
                $this->removePet($id, $sale);
                break;                                                                
                
            case ServicesType::VET:
                $sale = $this->searchInformationsAboutSaleVet($id);
                $this->removeVet($id, $sale);
                break;                                                                      
                
            case ServicesType::DELIVERY_FEE:
                $sale = $this->searchInformationsAboutSaleDeliveryFee($id);
                $this->removeDeliveryFee($id, $sale);
                break;     
            
            default: return false;
        }

        $moves = $this->createCashBookMove($sale, $user);
        $this->createOutlay($sale, $user, $moves, $store);
        $this->updateSale($sale);
        return $sale;
    }

    private function searchInformationsAboutSaleProduct($id)
    {
        $sale = $this->saleRepository->findProduct($id);
        return collect(array(
            'sale_id' => $sale->sale_id,
            'sale_total' => $sale->total,
            'item_sale_id' => $sale->product_id,
            'item_sale_name' => $sale->name,
            'item_sale_value' => $sale->unitary_value * $sale->quantity,
            'item_sale_quantity' => $sale->quantity,
            'payment_method_id' => $sale->payment_method_id,
            'store' => $sale->getStore(),
        ));
    }
    private function searchInformationsAboutSaleDeliveryFee($id)
    {
        $sale = $this->saleRepository->findDiary($id);
        return collect(array(
            'sale_id' => $sale->sale_id,
            'sale_total' => $sale->total,
            'item_sale_id' => $sale->diary_id,
            'item_sale_name' => 'Serviço de busca',
            'item_sale_value' => $sale->delivery_fee,
            'item_sale_gross' => $sale->gross,
            'item_sale_quantity' => 1,
            'payment_method_id' => $sale->payment_method_id,
            'store' => $sale->getStore(),
        ));
    }
    private function searchInformationsAboutSaleVet($id)
    {
        $sale = $this->saleRepository->findDiary($id);
        return collect(array(
            'sale_id' => $sale->sale_id,
            'sale_total' => $sale->total,
            'item_sale_id' => $sale->diary_id,
            'item_sale_name' => "Serviço Vet".$sale->service_vet_id,
            'item_sale_value' => $sale->service_vet_value,
            'item_sale_gross' => $sale->gross,
            'item_sale_quantity' => 1,
            'payment_method_id' => $sale->payment_method_id,
            'store' => $sale->getStore(),
        ));
    }
    private function searchInformationsAboutSalePet($id)
    {
        $sale = $this->saleRepository->findDiary($id);
        return collect(array(
            'sale_id' => $sale->sale_id,
            'sale_total' => $sale->total,
            'item_sale_id' => $sale->diary_id,
            'item_sale_name' => "Serviço Pet".$sale->service_pet_id,
            'item_sale_value' => $sale->service_pet_value,
            'item_sale_gross' => $sale->gross,
            'item_sale_quantity' => 1,
            'payment_method_id' => $sale->payment_method_id,
            'store' => $sale->getStore(),
        ));
    }
    private function removeDeliveryFee($id, Collection $sale)
    {
        $gross = $sale->get('item_sale_gross') - $sale->get('item_sale_value');
        return $this->saleRepository->removeDeliveryFee($id, $gross);
    }
    private function removePet($id, Collection $sale)
    {
        $gross = $sale->get('item_sale_gross') - $sale->get('item_sale_value');
        return $this->saleRepository->removePet($id, $gross);
    }
    private function removeVet($id, Collection $sale)
    {
        $gross = $sale->get('item_sale_gross') - $sale->get('item_sale_value');
        return $this->saleRepository->removeVet($id, $gross);
    }
    private function deleteProduct($saleId, $productId)
    {
        return $this->saleRepository->deleteProduct($saleId, $productId);
    }
    private function createCashBookMove(Collection $sale, User $user)
    {
        $source = SourceType::CASH_DRAWER;
        $sourceName = SourceType::getName($source);

        return $this->cashBookMoveService->generateMovementOut(
            $sale->get('item_sale_value'),
            $sourceName, 
            $sale->get('store'),
            $source,
            $user
        );
    }
    private function createOutlay(Collection $sale, User $user,  $moves, $store)
    {
        $this->outlayRepository->save(
            "ID {$sale->get('sale_id')} da venda, do produto/serviço {$sale->get('item_sale_quantity')}x {$sale->get('item_sale_name')} de valor total das unidades R$ ".number_format($sale->get('item_sale_value'), 2, ',', ''), 
            $sale->get('item_sale_value'),
            Carbon::now(), 
            SourceType::CASH_DRAWER, 
            1004, 
            $moves, 
            true, 
            $user, 
            $store
        );
            

    }
    private function updateSale($sale)
    {
        $id = $sale->get('sale_id');
        $total = $sale->get('sale_total') - $sale->get('item_sale_value');
        return $this->saleRepository->updateSaleAfterChargeback($id, $total);
    }
}