<?php

declare(strict_types=1);

namespace App\Trait\Request;

use App\Exception\ProductImportException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

trait GetContentRequestTrait
{
    /**
     * @throws ProductImportException
     */
    protected function getRequestContent(Request $request): string
    {
        $content = $request->getContent();

        if (is_string($content) && trim($content) !== '') {
            return $content;
        }

        $file = $request->files->get('file');

        if ($file instanceof UploadedFile && $file->isValid()) {
            $fileContent = file_get_contents($file->getPathname());

            if ($fileContent === false) {
                throw new ProductImportException('Failed to read uploaded file.');
            }

            return $fileContent;
        }

        throw new ProductImportException('No valid content found in request.');
    }
}
