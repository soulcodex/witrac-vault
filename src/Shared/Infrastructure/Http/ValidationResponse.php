<?php

namespace Witrac\Shared\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationResponse extends JsonResponse
{
    public function __construct(ConstraintViolationList $errors, int $status = Response::HTTP_BAD_REQUEST)
    {
        $errorsMap = ['message' => 'Validation exception has been raised'];

        foreach ($errors as $error) {
            $errorPath = rtrim(ltrim($error->getPropertyPath(), '['), ']');
            $errorsMap['violations'][$errorPath][] = $error->getMessage();
        }

        parent::__construct($errorsMap, $status);
    }
}
