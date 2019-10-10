<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class SourceType extends Enum
{
    const SAFE_BOX = 1;
    const CASH_DRAWER = 2;

    public static function getName($id)
    {
        switch ($id) {
            case self::SAFE_BOX:
                return 'Cofre';
            case self::CASH_DRAWER:
                return 'Gaveta';
        }
    }
}
