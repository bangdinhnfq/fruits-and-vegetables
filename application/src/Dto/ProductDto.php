<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\ProductTypeEnum;
use App\Enum\ProductUnitEnum;
use App\Trait\UnitConverter\UnitConverterTrait;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ProductDto
{
    use UnitConverterTrait;

    public function __construct(
        #[Assert\NotBlank]
        private string $name,

        #[Assert\NotBlank]
        private ProductTypeEnum $type,

        #[Assert\NotBlank]
        #[Assert\PositiveOrZero]
        private float $quantity,

        #[Assert\NotBlank]
        private ProductUnitEnum $unit
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ProductTypeEnum
    {
        return $this->type;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnit(): ProductUnitEnum
    {
        return $this->unit;
    }

    public function getQuantityInGrams(): int
    {
        return $this->convertToGrams($this->quantity, $this->unit);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
            'quantity' => $this->convertToGrams($this->quantity, $this->unit),
            'unit' => ProductUnitEnum::GRAM->value,
        ];
    }
}
