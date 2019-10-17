<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class SourceType extends Enum
{
    const SAFE_BOX = 1;
    const SAFE_BOX_NAME = 'safe_box';
    const CASH_DRAWER = 2;
    const CASH_DRAWER_NAME = 'cash_drawer';

    public static function getDisplay($id)
    {
        switch ($id) {
            case self::SAFE_BOX:
                return 'Cofre';
            case self::CASH_DRAWER:
                return 'Gaveta';
        }
    }
    
    public static function getName($id)
    {
        switch ($id) {
            case self::SAFE_BOX:
                return self::SAFE_BOX_NAME;
            case self::CASH_DRAWER:
                return self::CASH_DRAWER_NAME;
        }
    }
}
