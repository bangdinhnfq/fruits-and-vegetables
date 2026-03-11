<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ImportProductDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Product name cannot be blank')]
        #[Assert\Type(type: 'string', message: 'Product name must be a string')]
        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Product name must be at least 1 character long',
            maxMessage: 'Product name must not exceed 255 characters'
        )]
        private string $name,

        #[Assert\NotBlank(message: 'Product type cannot be blank')]
        #[Assert\Type(type: 'string', message: 'Product type must be a string')]
        #[Assert\Choice(
            choices: ['fruit', 'vegetable'],
            message: 'Product type must be either "fruit" or "vegetable"'
        )]
        private string $type,

        #[Assert\NotBlank(message: 'Quantity cannot be blank')]
        #[Assert\Type(type: ['int', 'float'], message: 'Quantity must be a number')]
        #[Assert\Positive(message: 'Quantity must be a positive number')]
        private float|int $quantity,

        #[Assert\NotBlank(message: 'Unit cannot be blank')]
        #[Assert\Type(type: 'string', message: 'Unit must be a string')]
        #[Assert\Choice(
            choices: ['g', 'kg'],
            message: 'Unit must be either "g" (grams) or "kg" (kilograms)'
        )]
        private string $unit = 'g',

        #[Assert\Type(type: ['string', 'int'], message: 'Request ID must be a string or integer')]
        private string|int|null $requestId = null
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuantity(): float|int
    {
        return $this->quantity;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getRequestId(): string|int|null
    {
        return $this->requestId;
    }

    public function getQuantityInGrams(): int
    {
        return match ($this->unit) {
            'kg' => (int)($this->quantity * 1000),
            default => (int)$this->quantity,
        };
    }
}
