<?php

declare(strict_types=1);

namespace App\Collection;

use App\Collection\Contract\ProductCollectionInterface;
use App\Entity\Product;

abstract class AbstractProductCollection implements ProductCollectionInterface
{
    protected array $items = [];

    public function add(Product $product): void
    {
        $this->items[] = $product;
    }

    public function remove(int $id): void
    {
        $this->items = array_filter($this->items, fn($item) => $item->getId() !== $id);
    }

    public function list(): array
    {
        return $this->items;
    }

    public function search(string $query): array
    {
        return array_filter(
            $this->items,
            fn($item) => stripos($item->getName(), $query) !== false
        );
    }
}
