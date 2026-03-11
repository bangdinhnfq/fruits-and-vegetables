<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class ImportResponseDataDto implements ArrayAble
{
    public function __construct(
        private int $imported,
        private int $updated = 0,
        private array $errors = [],
    ) {
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
            'imported' => $this->imported,
            'updated' => $this->updated,
            'errors' => $this->errors,
        ];
    }
}
