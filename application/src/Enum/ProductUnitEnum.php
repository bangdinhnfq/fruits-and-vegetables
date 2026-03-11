<?php

declare(strict_types=1);

namespace App\Enum;

enum ProductUnitEnum: string
{
    case GRAM = 'g';
    case KILOGRAM = 'kg';

    public const DEFAULT_UNIT = self::GRAM;
    public const KG_TO_G_MULTIPLIER = 1000;
}
