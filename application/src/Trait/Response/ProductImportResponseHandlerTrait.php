<?php

declare(strict_types=1);

namespace App\Trait\Response;

use App\Dto\ImportResponseDataDto;
use App\Dto\ImportResultDto;
use App\Mapper\ApiResponseMapper;
use App\Service\Response\ApiResponseFormatter;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ProductImportResponseHandlerTrait
{
    public function createImportResponse(
        ImportResultDto $importResult,
        ApiResponseFormatter $responseFormatter,
        ApiResponseMapper $apiResponseMapper
    ): JsonResponse {
        $statusCode = $responseFormatter->getStatusCode($importResult->isSuccess());

        $responseData = new ImportResponseDataDto(
            imported: $importResult->getImported(),
            updated: $importResult->getUpdated(),
            errors: $importResult->getErrors(),
        );

        if (!$importResult->isSuccess()) {
            $errorResponse = $responseFormatter->formatError(
                $importResult->getMessage(),
                $responseData
            );

            return new JsonResponse($errorResponse->toArray(), $statusCode);
        }

        $successMessage = sprintf(
            '%d product(s) imported, %d product(s) updated successfully',
            $importResult->getImported(),
            $importResult->getUpdated()
        );

        $successResponse = $responseFormatter->formatSuccess($successMessage, $responseData);
        $mappedResponse = $apiResponseMapper->toImportResultDto($successResponse);

        return new JsonResponse($mappedResponse->toArray(), $statusCode);
    }
}
