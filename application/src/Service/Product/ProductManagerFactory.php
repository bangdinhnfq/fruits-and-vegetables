<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Enum\ProductTypeEnum;
use App\Factory\ProductFactory;
use App\Repository\ProductRepository;

readonly class ProductManagerFactory
{
    public function __construct(
        private ProductRepository $repository,
        private ProductFactory $factory,
    ) {
    }

    public function create(ProductTypeEnum $type): ProductManagerInterface
    {
        return new GenericProductManager(
            $this->repository,
            $this->factory,
            $type,
        );
    }
}
