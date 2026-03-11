<?php

declare(strict_types=1);

namespace App\Repository\Contract;

use App\Collection\Contract\ProductCollectionInterface;
use App\Dto\ProductDto;

interface ProductRepositoryInterface
{
    public function save(ProductDto $productDto): void;

    public function list(): ProductCollectionInterface;

    public function remove(int $id): void;
}
