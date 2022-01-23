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
    const Original =   1;
    const X264 =   2;
    const Streamable = 3;
}
