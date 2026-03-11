<?php

declare(strict_types=1);

namespace App\Constant;

final class ImportValidationErrorsConstant
{
    public const EMPTY_REQUEST_BODY = 'Request body cannot be empty';
    public const INVALID_JSON_FORMAT = 'Invalid JSON format';
    public const EXPECTED_JSON_ARRAY = 'Expected JSON array of products';
    public const NO_PRODUCTS_PROVIDED = 'No products provided';
    public const NO_VALID_PRODUCTS = 'No valid products to import';

    public const ITEM_MUST_BE_ARRAY = 'Item must be an object/array';

    public const NAME_REQUIRED = 'Name is required';
    public const NAME_INVALID = 'Name must be string (max 255 characters)';

    public const TYPE_REQUIRED = 'Type is required';
    public const TYPE_INVALID = 'Type must be "fruit" or "vegetable"';

    public const QUANTITY_REQUIRED = 'Quantity is required';
    public const QUANTITY_INVALID = 'Quantity must be a positive number';

    public const UNIT_INVALID = 'Unit must be "g" or "kg"';

    public const IMPORT_COMPLETED = 'Import completed';
    public const IMPORT_FAILED = 'Import failed: %s';

    private function __construct()
    {
    }
}
