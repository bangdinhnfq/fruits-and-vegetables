<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Dto\ImportResultDto;
use App\Exception\ProductImportException;
use App\Exception\ValidationException;

interface ProductImportServiceInterface
{
    /**
     * @throws ProductImportException
     * @throws ValidationException
     */
    public function importFromJson(string $jsonContent): ImportResultDto;
}
