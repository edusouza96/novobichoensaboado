<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class SourceType extends Enum
{
    const SAFE_BOX = 1;
    const SAFE_BOX_NAME = 'safe_box';
    const CASH_DRAWER = 2;
    const CASH_DRAWER_NAME = 'cash_drawer';
    const PAGSEGURO = 3;
    const PAGSEGURO_NAME = 'pagseguro';
    const BANK = 4;
    const BANK_NAME = 'bank';

    public static function getDisplay($id)
    {
        switch ($id) {
            case self::SAFE_BOX:
                return 'Cofre';
            case self::CASH_DRAWER:
                return 'Gaveta';
            case self::PAGSEGURO:
                return 'PagSeguro';
            case self::BANK:
                return 'Banco';
            case self::SAFE_BOX_NAME:
                return 'Cofre';
            case self::CASH_DRAWER_NAME:
                return 'Gaveta';
            case self::PAGSEGURO_NAME:
                return 'PagSeguro';
            case self::BANK_NAME:
                return 'Banco';
        }
    }
    
    public static function getName($id)
    {
        switch ($id) {
            case self::SAFE_BOX:
                return self::SAFE_BOX_NAME;
            case self::CASH_DRAWER:
                return self::CASH_DRAWER_NAME;
            case self::PAGSEGURO:
                return self::PAGSEGURO_NAME;
            case self::BANK:
                return self::BANK_NAME;
        }
    }
}
