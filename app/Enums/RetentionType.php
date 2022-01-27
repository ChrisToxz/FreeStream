<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Views()
 * @method static static Datetime()
 */
final class RetentionType extends Enum
{
    const Views =   1;
    const Datetime =   2;
}
