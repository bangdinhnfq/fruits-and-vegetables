<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ProductImportException;
use App\Exception\ValidationException;
use App\Mapper\ApiResponseMapper;
use App\Service\Product\ProductImportServiceInterface;
use App\Service\Request\RequestValidator;
use App\Service\Response\ApiResponseFormatter;
use App\Trait\Request\GetContentRequestTrait;
use App\Trait\Response\ProductImportResponseHandlerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/products/import', name: 'api_products_import_')]
class ProductImportController extends AbstractController
{
    use GetContentRequestTrait;
    use ProductImportResponseHandlerTrait;

    public function __construct(
        private readonly ProductImportServiceInterface $productImportService,
        private readonly ApiResponseFormatter $responseFormatter,
        private readonly RequestValidator $requestValidator,
        private readonly ApiResponseMapper $apiResponseMapper,
    ) {
    }

    /**
     * @throws ValidationException
     * @throws ProductImportException
     */
    #[Route('', name: 'index', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $this->requestValidator->validateImportRequest($request);
        $content = $this->getRequestContent($request);
        $importResult = $this->productImportService->importFromJson($content);

        return $this->createImportResponse(
            $importResult,
            $this->responseFormatter,
            $this->apiResponseMapper
        );
    }
}
