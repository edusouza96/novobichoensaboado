<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethodsType extends Enum
{
    const CASH = 1;
    const CREDIT_CARD = 2;
    const DEBIT_CARD = 3;

    public static function getName($id)
    {
        switch ($id) {
            case self::CASH:
                return 'Dinheiro';
            case self::CREDIT_CARD:
                return 'Cartão de Crédito';
            case self::DEBIT_CARD:
                return 'Cartão de Débito';
        }
    }
}
