<?php

declare(strict_types=1);

namespace App\Service\Response;

use App\Dto\ApiResponseDto;
use Symfony\Component\HttpFoundation\Response;

final readonly class ApiResponseFormatter
{
    public function formatSuccess(string $message, mixed $data = null): ApiResponseDto
    {
        return new ApiResponseDto(
            data: $data,
            message: $message,
            success: true
        );
    }

    public function formatError(string $message, mixed $data = null): ApiResponseDto
    {
        return new ApiResponseDto(
            data: $data,
            message: $message,
            success: false
        );
    }

    public function getStatusCode(bool $success, array $errors = []): int
    {
        if ($success) {
            return Response::HTTP_CREATED;
        }

        return Response::HTTP_BAD_REQUEST;
    }
}
