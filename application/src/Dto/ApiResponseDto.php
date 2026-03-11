<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class ApiResponseDto
{
    public function __construct(
        private mixed $data = null,
        private ?string $message = null,
        private bool $success = true
    ) {
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function toArray(): array
    {
        $responseData = $this->data instanceof Arrayable
            ? $this->data->toArray()
            : $this->data;

        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $responseData,
        ];
    }
}
