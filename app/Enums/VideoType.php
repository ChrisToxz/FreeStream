<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Original()
 * @method static static X264()
 * @method static static Streamable()
 */
final class VideoType extends Enum
{
    const Original =   0;
    const X264 =   1;
    const Streamable = 2;
}
