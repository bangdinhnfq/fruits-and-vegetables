<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\ApiResponseDto;
use App\Dto\ImportResponseDataDto;
use App\Dto\ImportResultDto;
use InvalidArgumentException;

final class ApiResponseMapper
{
    public function toImportResultDto(ApiResponseDto $apiResponse): ImportResultDto
    {
        $data = $apiResponse->getData();

        if ($data instanceof ImportResponseDataDto) {
            return new ImportResultDto(
                success: $apiResponse->isSuccess(),
                message: $apiResponse->getMessage() ?? '',
                imported: $data->getImported(),
                errors: $data->getErrors(),
                updated: $data->getUpdated()
            );
        }

        throw new InvalidArgumentException(
            sprintf('Cannot map ApiResponse with data of type %s to ImportResultDto', gettype($data))
        );
    }
}
