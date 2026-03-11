<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ProductDto;
use App\Enum\ProductTypeEnum;
use App\Service\Product\ProductManagerFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/products/{type<fruit|vegetable>}')]
final class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductManagerFactory $factory,
    ) {
    }

    #[Route('', name: 'api_products_list', methods: ['GET'])]
    public function list(ProductTypeEnum $type): JsonResponse
    {
        $manager = $this->factory->create($type);

        return $this->json($manager->list());
    }

    #[Route('/search', name: 'api_products_search', methods: ['GET'])]
    public function search(
        ProductTypeEnum $type,
        #[MapQueryParameter] string $query = ''
    ): JsonResponse {
        $manager = $this->factory->create($type);

        return $this->json($manager->search($query));
    }

    #[Route('/{id<\d+>}', name: 'api_products_get', methods: ['GET'])]
    public function get(ProductTypeEnum $type, int $id): JsonResponse
    {
        $manager = $this->factory->create($type);
        $product = $manager->find($id);

        if ($product === null) {
            throw $this->createNotFoundException('Product not found.');
        }

        return $this->json($product);
    }

    #[Route('', name: 'api_products_add', methods: ['POST'])]
    public function add(
        ProductTypeEnum $type,
        #[MapRequestPayload] ProductDto $dto
    ): JsonResponse {
        $manager = $this->factory->create($type);
        $manager->add($dto);

        return $this->json(['status' => 'success'], Response::HTTP_CREATED);
    }

    #[Route('/{id<\d+>}', name: 'api_products_remove', methods: ['DELETE'])]
    public function remove(ProductTypeEnum $type, int $id): JsonResponse
    {
        $manager = $this->factory->create($type);
        $manager->remove($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
