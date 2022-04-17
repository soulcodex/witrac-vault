<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse
{
    public function __construct(\Exception $exception, int $status = 500)
    {
        parent::__construct(
            [
                'error' => true,
                'message' => $exception->getMessage(),
            ],
            $status,
            [],
            false
        );
    }
}
