<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Constant\ImportValidationErrorsConstant;
use App\Dto\ImportProductDto;
use App\Enum\ProductTypeEnum;
use App\Enum\ProductUnitEnum;

final class ImportProductValidator
{
    private const MAX_NAME_LENGTH = 255;
    private const MIN_QUANTITY = 0;

    public function validate(ImportProductDto $dto): array
    {
        return array_filter([
            'name' => $this->validateName($dto->getName()),
            'type' => $this->validateType($dto->getType()),
            'quantity' => $this->validateQuantity($dto->getQuantity()),
            'unit' => $this->validateUnit($dto->getUnit()),
        ]);
    }

    private function validateName(mixed $name): ?string
    {
        if (empty($name)) {
            return ImportValidationErrorsConstant::NAME_REQUIRED;
        }

        if (!is_string($name) || strlen($name) > self::MAX_NAME_LENGTH) {
            return ImportValidationErrorsConstant::NAME_INVALID;
        }

        return null;
    }

    private function validateType(mixed $type): ?string
    {
        if (empty($type)) {
            return ImportValidationErrorsConstant::TYPE_REQUIRED;
        }

        if (is_string($type) && ProductTypeEnum::tryFrom($type) !== null) {
            return null;
        }

        return ImportValidationErrorsConstant::TYPE_INVALID;
    }

    private function validateQuantity(mixed $quantity): ?string
    {
        if (!is_numeric($quantity) || (float)$quantity <= self::MIN_QUANTITY) {
            return ImportValidationErrorsConstant::QUANTITY_INVALID;
        }

        return null;
    }

    private function validateUnit(mixed $unit): ?string
    {
        if (is_string($unit) && ProductUnitEnum::tryFrom($unit) !== null) {
            return null;
        }

        return ImportValidationErrorsConstant::UNIT_INVALID;
    }
}
