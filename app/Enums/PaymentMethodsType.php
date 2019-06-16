<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethodsType extends Enum
{
    const CASH = 1;
    const CREDIT_CARD = 2;
    const DEBIT_CARD = 3;
}
