<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class ImportResultDto implements ArrayAble
{
    public function __construct(
        private bool $success,
        private string $message,
        private int $imported,
        private array $errors = [],
        private int $updated = 0,
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getImported(): int
    {
        return $this->imported;
    }

    public function getUpdated(): int
    {
        return $this->updated;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'imported' => $this->imported,
            'updated' => $this->updated,
            'errors' => $this->errors,
        ];
    }
}
