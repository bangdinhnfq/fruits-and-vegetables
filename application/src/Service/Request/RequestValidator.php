<?php

declare(strict_types=1);

namespace App\Service\Request;

use App\Constant\ImportValidationErrorsConstant;
use App\Exception\ProductImportException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

final class RequestValidator
{
    /**
     * @throws ProductImportException
     */
    public function validateImportRequest(Request $request): void
    {
        if (trim($request->getContent()) !== '') {
            return;
        }

        $file = $request->files->get('file');

        if ($file instanceof UploadedFile && $file->isValid()) {
            return;
        }

        throw new ProductImportException(ImportValidationErrorsConstant::EMPTY_REQUEST_BODY);
    }
}
