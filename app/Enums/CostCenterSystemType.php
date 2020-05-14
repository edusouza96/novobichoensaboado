<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class CostCenterSystemType extends Enum
{
    const CATEGORY_SISTEMA = '1000';
    
    const COST_CENTER_APORTE = '1001';
    const COST_CENTER_APORTE_CAIXA_INICIAL = '1002';
    const COST_CENTER_SANGRIA = '1003';
    
    const COST_CENTER_EMPLOYEE_SALARY = '2000';

    const GROUP_CATEGORY_SISTEM = ['1001', '1002', '1003'];
    const GROUP_CONTRIBUTE = ['1001', '1002'];
}
