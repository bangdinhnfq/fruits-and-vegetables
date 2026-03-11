<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Dto\ImportProductDto;
use App\Dto\ImportResultDto;
use App\Entity\Product;
use App\Factory\ProductFactory;
use App\Repository\ProductRepository;
use App\Trait\Product\ImportResultBuilderTrait;
use App\Trait\Product\JsonParsingTrait;
use Exception;
use Throwable;

final class ProductImportService implements ProductImportServiceInterface
{
    use JsonParsingTrait;
    use ImportResultBuilderTrait;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ImportProductValidator $validator,
        private readonly ProductFactory $productFactory,
    ) {
    }

    public function importFromJson(string $jsonContent): ImportResultDto
    {
        try {
            $data = $this->parseJson($jsonContent);
            $this->validateJsonStructure($data);

            $dtos = array_map($this->createDtoFromArray(...), $data);
            $existingProducts = $this->findExistingProducts($dtos);

            $errors = [];
            $imported = 0;
            $updated = 0;

            foreach ($dtos as $index => $dto) {
                $validationErrors = $this->validator->validate($dto);

                if ($validationErrors !== []) {
                    $errors[$index] = $validationErrors;
                    continue;
                }

                try {
                    $requestId = $dto->getRequestId();
                    $product = $requestId !== null ? ($existingProducts[$requestId] ?? null) : null;

                    if ($product !== null) {
                        $product = $this->updateProduct($product, $dto);
                        $updated++;
                    } else {
                        $product = $this->createProduct($dto);
                        $imported++;
                    }

                    if ($requestId !== null) {
                        $existingProducts[$requestId] = $product;
                    }
                } catch (Exception $e) {
                    $errors[$index] = ['error' => $e->getMessage()];
                }
            }

            $this->productRepository->flush();

            return $this->buildResult($imported, $errors, $updated);
        } catch (Throwable $e) {
            return $this->buildErrorResult($e);
        }
    }

    /**
     * @param ImportProductDto[] $dtos
     * @return array<string, Product>
     */
    private function findExistingProducts(array $dtos): array
    {
        $requestIds = array_filter(
            array_map(fn(ImportProductDto $dto) => $dto->getRequestId(), $dtos),
            fn(?string $id) => $id !== null
        );

        if ($requestIds === []) {
            return [];
        }

        return $this->productRepository->findByRequestIds(array_unique($requestIds));
    }

    private function updateProduct(Product $product, ImportProductDto $dto): Product
    {
        if ($product->getType()->value !== $dto->getType()) {
            $this->productRepository->remove($product);

            return $this->createProduct($dto);
        }

        $product->setName($dto->getName());
        $product->setQuantity($dto->getQuantityInGrams());

        return $product;
    }

    private function createProduct(ImportProductDto $dto): Product
    {
        $product = $this->productFactory->createFromImportProductDto($dto);
        $this->productRepository->add($product);

        return $product;
    }

    private function createDtoFromArray(array $data): ImportProductDto
    {
        return new ImportProductDto(
            name: $data['name'] ?? '',
            type: $data['type'] ?? '',
            quantity: $data['quantity'] ?? 0,
            unit: $data['unit'] ?? 'g',
            requestId: isset($data['id']) ? (string)$data['id'] : null,
        );
    }
}
