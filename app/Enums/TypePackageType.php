<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class TypePackageType extends Enum
{
    const NOT_PACKAGE = 1;
    const PACKAGE_15_DAYS = 2;
    const PACKAGE_30_DAYS = 3;

    public static function getName($id)
    {
        switch ($id) {
            case self::NOT_PACKAGE: return '';
            case self::PACKAGE_15_DAYS: return 'Pacote 15 dias';
            case self::PACKAGE_30_DAYS: return 'Pacote 30 dias';
        }
    }
}
