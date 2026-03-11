<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Dto\ProductDto;

interface ProductManagerInterface
{
    public function list(): array;

    public function search(string $query): array;

    public function add(ProductDto $dto): void;

    public function remove(int $id): void;
}
