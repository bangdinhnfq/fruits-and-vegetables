<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Dto\ProductDto;
use App\Entity\Product;

interface ProductManagerInterface
{
    public function list(): array;

    public function search(string $query): array;

    public function find(int $id): ?Product;

    public function add(ProductDto $dto): void;

    public function remove(int $id): void;
}
