<?php

declare(strict_types=1);

namespace App\Trait\Product;

use App\Constant\ImportValidationErrorsConstant;
use App\Dto\ImportResultDto;
use Throwable;

trait ImportResultBuilderTrait
{
    protected function buildResult(int $imported, array $errors, int $updated = 0): ImportResultDto
    {
        if (!empty($errors) && $imported === 0 && $updated === 0) {
            return new ImportResultDto(
                success: false,
                message: ImportValidationErrorsConstant::NO_VALID_PRODUCTS,
                imported: 0,
                errors: $errors,
                updated: 0,
            );
        }

        return new ImportResultDto(
            success: true,
            message: ImportValidationErrorsConstant::IMPORT_COMPLETED,
            imported: $imported,
            errors: !empty($errors) ? $errors : [],
            updated: $updated,
        );
    }

    protected function buildErrorResult(Throwable $exception): ImportResultDto
    {
        return new ImportResultDto(
            success: false,
            message: sprintf(ImportValidationErrorsConstant::IMPORT_FAILED, $exception->getMessage()),
            imported: 0,
            errors: [],
            updated: 0,
        );
    }
}
