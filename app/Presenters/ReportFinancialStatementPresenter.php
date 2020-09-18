<?php
namespace BichoEnsaboado\Presenters;

use JsonSerializable;
use Illuminate\Support\Collection;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\AliquotType;
use Illuminate\Contracts\Support\Arrayable;
use BichoEnsaboado\Enums\PaymentMethodsType;

class ReportFinancialStatementPresenter implements Arrayable, JsonSerializable
{
    private $report;

    public function __construct(Collection $outlays, Collection $sales)
    {
        $outlays = $this->formatOutlays($outlays);
        $sales = $this->formatSales($sales);

        $this->report = $this->union($outlays, $sales)->sortKeys();
    }

    public function get()
    {
        return $this->report->map(function ($item, $key) {
            return [
                'year' => substr($key, 3),
                'period' => $key,
                'delivery_fee' => $this->getDeliveryFee($item),
                'sales_cash' => $this->getSalesCash($item),
                'sales_debit_card' => $this->applyAliquot($this->getSalesDebitCard($item), AliquotType::ALIQUOT_DEBIT),
                'sales_credit_card_1x' => $this->applyAliquot($this->getSalesCreditCard1x($item), AliquotType::ALIQUOT_CREDIT1X),
                'sales_credit_card_2x' => $this->applyAliquot($this->getSalesCreditCard2x($item), AliquotType::ALIQUOT_CREDIT2X),
                'sales_credit_card_3x' => $this->applyAliquot($this->getSalesCreditCard3x($item), AliquotType::ALIQUOT_CREDIT3X),
                'sales_total' => $this->getSalesTotal($item),
                'outlay_safe_box' => $this->getOutlaySafeBox($item),
                'outlay_cash_drawer' => $this->getOutlayCashDrawer($item),
                'outlay_pagseguro' => $this->getOutlayPagseguro($item),
                'outlay_bank' => $this->getOutlayBank($item),
                'outlay_total' => $this->getOutlayTotal($item),
            ];
        });
    }
    public function getForChart()
    {
        return $this->report->map(function ($item, $key) {
            return [
                'year' => substr($key, 3),
                'period' => $key,
                'sales_total' => $this->getSalesTotal($item),
                'outlay_total' => $this->getOutlayTotal($item),
            ];
        });
    }

    private function getOutlayTotal($item)
    {
        $total = $item->where('type', 'outlay')
            ->sum(function ($outlay) {
                return $outlay['data']->getValue();
            });

        return $total + $this->getDeliveryFee($item);

    }
    private function getOutlayBank($item)
    {
        return $item->where('type', 'outlay')
            ->sum(function ($outlay) {
                return $outlay['data']->getSource()->getId() == SourceType::BANK
                ? $outlay['data']->getValue()
                : 0;
            });
    }
    private function getOutlayPagseguro($item)
    {
        return $item->where('type', 'outlay')
            ->sum(function ($outlay) {
                return $outlay['data']->getSource()->getId() == SourceType::PAGSEGURO
                ? $outlay['data']->getValue()
                : 0;
            });
    }
    private function getOutlayCashDrawer($item)
    {
        return $item->where('type', 'outlay')
            ->sum(function ($outlay) {
                return $outlay['data']->getSource()->getId() == SourceType::CASH_DRAWER
                ? $outlay['data']->getValue()
                : 0;
            });
    }
    private function getOutlaySafeBox($item)
    {
        return $item->where('type', 'outlay')
            ->sum(function ($outlay) {
                return $outlay['data']->getSource()->getId() == SourceType::SAFE_BOX
                ? $outlay['data']->getValue()
                : 0;
            });
    }
    private function getSalesTotal($item)
    {
        return $item->where('type', 'sale')
            ->sum(function ($sale) {
                return $sale['data']->getCalcValueTotal();
            });
    }
    private function getSalesCreditCard3x($item)
    {
        return $item->where('type', 'sale')
            ->sum(function ($sale) {
                return $sale['data']->getSalePaymentMethod()
                    ->where('payment_method_id', PaymentMethodsType::CREDIT_CARD)
                    ->where('plots', '>=', 3)
                    ->sum('value_received');
            });
    }
    private function getSalesCreditCard2x($item)
    {
        return $item->where('type', 'sale')
            ->sum(function ($sale) {
                return $sale['data']->getSalePaymentMethod()
                    ->where('payment_method_id', PaymentMethodsType::CREDIT_CARD)
                    ->where('plots', 2)
                    ->sum('value_received');
            });
    }
    private function getSalesCreditCard1x($item)
    {
        return $item->where('type', 'sale')
            ->sum(function ($sale) {
                return $sale['data']->getSalePaymentMethod()
                    ->where('payment_method_id', PaymentMethodsType::CREDIT_CARD)
                    ->where('plots', 1)
                    ->sum('value_received');
            });
    }

    private function getSalesDebitCard($item)
    {
        return $item->where('type', 'sale')
            ->sum(function ($sale) {
                return $sale['data']->getSalePaymentMethod()
                    ->where('payment_method_id', PaymentMethodsType::DEBIT_CARD)
                    ->sum('value_received');
            });
    }

    private function getSalesCash($item)
    {
        return $item->where('type', 'sale')
            ->sum(function ($sale) {
                return $sale['data']->getSalePaymentMethod()
                    ->where('payment_method_id', PaymentMethodsType::CASH)
                    ->sum(function ($paymentMethod) {
                        return $paymentMethod->getCalcValueTotal();
                    });
            });
    }
    private function getDeliveryFee($item)
    {
        return $item->where('type', 'sale')
            ->sum(function ($sale) {
                return $sale['data']->getSalePaymentMethod()
                    ->where('delivery_fee', true)
                    ->sum(function ($paymentMethod) {
                        return $paymentMethod->getCalcValueTotal();
                    });
            });
    }
    public function getByYear()
    {
        $report = $this->get();
        return $report->groupBy('year');
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    private function formatOutlays(Collection $outlays)
    {
        return $outlays->map(function ($outlay) {
            return [
                'type' => 'outlay',
                'data' => $outlay,
                'date' => $outlay->getDatePay()->format('m/Y'),
                'year' => $outlay->getDatePay()->format('Y'),
            ];
        });
    }

    private function formatSales(Collection $sales)
    {
        return $sales->map(function ($sale) {
            return [
                'type' => 'sale',
                'data' => $sale,
                'date' => $sale->getCreatedAt()->format('m/Y'),
                'year' => $sale->getCreatedAt()->format('Y'),
            ];
        });
    }

    private function union(Collection $outlays, Collection $sales)
    {
        $report = collect();
        $report = $report->merge($outlays);
        $report = $report->merge($sales);

        return $report->groupBy('date');
    }

    public function toArray()
    {return [];}

    private function applyAliquot($value, $aliquot)
    {
        return  $value - ($value * $aliquot) / 100;
    }
}
