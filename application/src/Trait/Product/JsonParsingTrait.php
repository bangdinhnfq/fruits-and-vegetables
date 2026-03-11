<?php

declare(strict_types=1);

namespace App\Trait\Product;

use App\Constant\ImportValidationErrorsConstant;
use App\Exception\JsonParsingException;

trait JsonParsingTrait
{
    /**
     * @throws JsonParsingException
     */
    protected function parseJson(string $jsonContent): mixed
    {
        $data = json_decode($jsonContent, true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonParsingException(ImportValidationErrorsConstant::INVALID_JSON_FORMAT);
        }

        return $data;
    }

    /**
     * @throws JsonParsingException
     */
    protected function validateJsonStructure(mixed $data): void
    {
        if (!is_array($data)) {
            throw new JsonParsingException(ImportValidationErrorsConstant::EXPECTED_JSON_ARRAY);
        }

        if (empty($data)) {
            throw new JsonParsingException(ImportValidationErrorsConstant::NO_PRODUCTS_PROVIDED);
        }
    }
}
