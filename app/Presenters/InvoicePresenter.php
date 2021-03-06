<?php
namespace BichoEnsaboado\Presenters;

use BichoEnsaboado\Models\Sale;
use BichoEnsaboado\Enums\PaymentMethodsType;

class InvoicePresenter
{
    private $sale;
    private $diary;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
        $this->diaries = $sale->getDiary();
    }

    public function getOwnerName()
    {
        if($this->diaries->isEmpty()) return '';

        return $this->diaries->first()->getClient()->getOwnerName();
    }  
    public function getPetName()
    {
        if($this->diaries->isEmpty()) return '';

        $petNames = '';
        foreach($this->diaries as $diary){
            $petNames .= " <i class='fas fa-paw'></i> ".$diary->getClient()->getName();
        }
        return $petNames;
    }  
    public function getBreedName()
    {
        if($this->diaries->isEmpty()) return '';

        $breedNames = '';
        foreach($this->diaries as $diary){
            $breedNames .= " <i class='fas fa-paw'></i> ".$diary->getClient()->getBreed()->getName();
        }

        return $breedNames;
    }  

    public function getDate()
    {
        return $this->sale->getCreatedAt()->format('d/m/Y');
    }
    public function getId()
    {
        return str_pad($this->sale->getId(), 6, '0', STR_PAD_LEFT);
    }

    public function getSaleItems()
    {
        $items = collect([]);

        foreach($this->sale->getDiary() as $diary){
            // Serviço PET
            if (!is_null($diary->getServicePet())){
                $item = array();
                $item['units'] = 1;
                $item['barcode'] = null;
                $item['description'] = $diary->getServicePet()->getName().$diary->getNumberPackage();
                $item['unitaryValue'] = $diary->getServicePetValue();
                $item['unitaryValue_string'] = number_format($item['unitaryValue'], 2, ',', '');
                $item['amountValue'] = $diary->getServicePetValue();
                $item['amountValue_string'] = number_format($item['amountValue'], 2, ',', '');
                $items->push($item);
            }
           
            // Serviço VET
            if (!is_null($diary->getServiceVet())){
                $item = array();
                $item['units'] = 1;
                $item['barcode'] = null;
                $item['description'] = $diary->getServiceVet()->getName();
                $item['unitaryValue'] = $diary->getServiceVetValue();
                $item['unitaryValue_string'] = number_format($item['unitaryValue'], 2, ',', '');
                $item['amountValue'] = $diary->getServiceVetValue();
                $item['amountValue_string'] = number_format($item['amountValue'], 2, ',', '');
                $items->push($item);
            }

            // Serviço De Busca
            if ($diary->getFetch() > 0){
                $item = array();
                $item['units'] = 1;
                $item['barcode'] = null;
                $item['description'] = 'Serviço de Busca';
                $item['unitaryValue'] = $diary->getDeliveryFee();
                $item['unitaryValue_string'] = number_format($item['unitaryValue'], 2, ',', '');
                $item['amountValue'] = $diary->getDeliveryFee();
                $item['amountValue_string'] = number_format($item['amountValue'], 2, ',', '');
                $items->push($item);
            }

        }

        foreach($this->sale->getProducts() as $product){
            $item = array();
            $item['units'] = $product->pivot->quantity;
            $item['barcode'] = $product->getBarcode();
            $item['description'] = $product->getName();
            $item['unitaryValue'] = $product->pivot->unitary_value;
            $item['unitaryValue_string'] = number_format($item['unitaryValue'], 2, ',', '');
            $item['amountValue'] = $product->pivot->unitary_value * $product->pivot->quantity;
            $item['amountValue_string'] = number_format($item['amountValue'], 2, ',', '');
            $items->push($item);
        }
        return $items;
    }

    public function getTotal()
    {
        return number_format(
            $this->getSaleItems()->sum('amountValue') - $this->sale->getRebate(), 
            2, ',', '');
    }

    public function getValueReceived($i)
    {
        $salePaymentMethod = $this->sale->getSalePaymentMethod()->get($i);
        return number_format($salePaymentMethod->getValueReceived(), 2, ',', '');
    }
    public function getLeftover($i)
    {
        $salePaymentMethod = $this->sale->getSalePaymentMethod()->get($i);
        return number_format($salePaymentMethod->getLeftover(), 2, ',', '');
    }
    public function getDescriptivePaymentMethod($i)
    {
        $salePaymentMethod = $this->sale->getSalePaymentMethod()->get($i);
        switch ($salePaymentMethod->getPaymentMethodId()) {
            case PaymentMethodsType::CASH:
                return PaymentMethodsType::getName($salePaymentMethod->getPaymentMethodId());
            case PaymentMethodsType::DEBIT_CARD:
                return PaymentMethodsType::getName($salePaymentMethod->getPaymentMethodId());
            case PaymentMethodsType::CREDIT_CARD:
                return PaymentMethodsType::getName($salePaymentMethod->getPaymentMethodId())." - ".$salePaymentMethod->getPlots()." parcela(s)";
        }
    }

    public function countPaymentMethods()
    {
        return $this->sale->getSalePaymentMethod()->count();
    }
   
    public function hasRebate()
    {
        return (bool) $this->sale->getRebates();
    }
    public function getNameRebate()
    {
        return $this->sale->getRebates()->getName();
    }
    public function getValueRebate()
    {
        return number_format($this->sale->getRebate(), 2, ',', '');
    }
        
}