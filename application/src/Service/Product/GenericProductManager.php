<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Dto\ProductDto;
use App\Enum\ProductTypeEnum;
use App\Factory\ProductFactory;
use App\Repository\ProductRepository;
use InvalidArgumentException;

readonly class GenericProductManager implements ProductManagerInterface
{
    public function __construct(
        private ProductRepository $repository,
        private ProductFactory $factory,
        private ProductTypeEnum $type,
    ) {
    }

    public function list(): array
    {
        return $this->repository->listByType($this->type->value);
    }

    public function search(string $query): array
    {
        return $this->repository->searchByName($query, $this->type->value);
    }

    public function add(ProductDto $dto): void
    {
        $product = $this->factory->createFromProductDto($dto);
        $expectedClass = $this->type->getEntityClass();

        if (!$product instanceof $expectedClass) {
            $expectedName = basename(str_replace('\\', '/', $expectedClass));
            throw new InvalidArgumentException(sprintf('Product type mismatch: expected %s.', $expectedName));
        }

        $this->repository->add($product, true);
    }

    public function remove(int $id): void
    {
        $product = $this->repository->find($id);
        $expectedClass = $this->type->getEntityClass();

        if ($product instanceof $expectedClass) {
            $this->repository->remove($product, true);
        }
    }
}
