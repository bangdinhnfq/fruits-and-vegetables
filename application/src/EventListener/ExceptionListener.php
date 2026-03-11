<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ProductImportException;
use App\Service\Response\ApiResponseFormatter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Global exception listener for handling application exceptions.
 *
 * This listener catches exceptions throughout the application and converts them
 * to appropriate JSON responses, providing consistent error handling across all endpoints.
 */
final readonly class ExceptionListener
{
    public function __construct(
        private ApiResponseFormatter $responseFormatter,
    ) {
    }

    /**
     * Handle exceptions and convert them to JSON responses.
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // Handle ProductImportException (includes JsonParsingException)
        if ($exception instanceof ProductImportException) {
            $response = new JsonResponse(
                $this->responseFormatter->formatError($exception->getMessage()),
                Response::HTTP_BAD_REQUEST
            );
            $event->setResponse($response);
            return;
        }

        // Handle other exceptions - only for non-404, non-405 errors
        if (!($exception instanceof BadRequestHttpException)) {
            return;
        }
    }
}
