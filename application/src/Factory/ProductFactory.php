<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\ImportProductDto;
use App\Dto\ProductDto;
use App\Entity\Fruit;
use App\Entity\Product;
use App\Entity\Vegetable;
use App\Enum\ProductTypeEnum;

class ProductFactory
{
    public function createFromImportProductDto(ImportProductDto $dto): Product
    {
        $type = ProductTypeEnum::from($dto->getType());
        $quantityInGrams = $dto->getQuantityInGrams();
        $requestId = $dto->getRequestId() !== null ? (string)$dto->getRequestId() : null;

        return match ($type) {
            ProductTypeEnum::FRUIT => new Fruit($dto->getName(), $quantityInGrams, $requestId),
            ProductTypeEnum::VEGETABLE => new Vegetable($dto->getName(), $quantityInGrams, $requestId),
        };
    }

    public function createFromProductDto(ProductDto $dto): Product
    {
        $quantityInGrams = $dto->getQuantityInGrams();

        return match ($dto->getType()) {
            ProductTypeEnum::FRUIT => new Fruit($dto->getName(), $quantityInGrams),
            ProductTypeEnum::VEGETABLE => new Vegetable($dto->getName(), $quantityInGrams),
        };
    }
}
