<?php

namespace BichoEnsaboado\Services;

use BichoEnsaboado\Models\Store;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Repositories\TreasureRepository;

class TreasureByStoreService
{
    private $treasureRepository;

    public function __construct(TreasureRepository $treasureRepository)
    {
        $this->treasureRepository = $treasureRepository;
    }

    public function createInitialSource(Store $store)
    {
        $this->treasureRepository->create($this->sourceSafeBoxData($store));
        $this->treasureRepository->create($this->sourceCashDrawerData($store));
        $this->treasureRepository->create($this->sourcePagseguroData($store));
        $this->treasureRepository->create($this->sourceBankData($store));
        $this->treasureRepository->create($this->sourceDeliveryFee($store));
    }

    private function sourceSafeBoxData(Store $store)
    {
        return array(
            'name' => SourceType::SAFE_BOX_NAME,
            'display' => SourceType::getDisplay(SourceType::SAFE_BOX_NAME),
            'value' => 0,
            'store_id' => $store->getId(),
            'card_machine' => 0,
            'source_id' => 1
        );
    }
    private function sourceCashDrawerData(Store $store)
    {
        return array(
            'name' => SourceType::CASH_DRAWER_NAME,
            'display' => SourceType::getDisplay(SourceType::CASH_DRAWER_NAME),
            'value' => 0,
            'store_id' => $store->getId(),
            'card_machine' => 0,
            'source_id' => 2
        );
    }
    private function sourcePagseguroData(Store $store)
    {
        return array(
            'name' => SourceType::PAGSEGURO_NAME,
            'display' => SourceType::getDisplay(SourceType::PAGSEGURO_NAME),
            'value' => 0,
            'store_id' => $store->getId(),
            'card_machine' => 1,
            'source_id' => 3
        );
    }
    private function sourceBankData(Store $store)
    {
        return array(
            'name' => SourceType::BANK_NAME,
            'display' => SourceType::getDisplay(SourceType::BANK_NAME),
            'value' => 0,
            'store_id' => $store->getId(),
            'card_machine' => 0,
            'source_id' => 4
        );
    }
    private function sourceDeliveryFee(Store $store)
    {
        return array(
            'name' => SourceType::DELIVERY_FEE,
            'display' => SourceType::getDisplay(SourceType::DELIVERY_FEE_NAME),
            'value' => 0,
            'store_id' => $store->getId(),
            'card_machine' => 1,
            'source_id' => 5
        );
    }

    public function deleteByStore($id)
    {
        $this->treasureRepository->deleteByStore($id);
    }
}