<?php

declare(strict_types=1);

namespace App\Trait\UnitConverter;

use App\Enum\ProductUnitEnum;

trait UnitConverterTrait
{
    protected function convertToGrams(float|int $quantity, ProductUnitEnum $unit): int
    {
        return match ($unit) {
            ProductUnitEnum::KILOGRAM => (int)($quantity * 1000),
            ProductUnitEnum::GRAM => (int)$quantity,
        };
    }

    protected function convertFromGrams(int $quantityInGrams, ProductUnitEnum $toUnit): float|int
    {
        return match ($toUnit) {
            ProductUnitEnum::KILOGRAM => $quantityInGrams / 1000,
            ProductUnitEnum::GRAM => $quantityInGrams,
        };
    }
}
