<?php

namespace BichoEnsaboado\Enums;

use BenSampo\Enum\Enum;

final class StatusType extends Enum
{
    const SCHEDULED = 1;
    const PRESENT = 2;
    const FINISHED = 3;
    const CANCELED = 4;
}
