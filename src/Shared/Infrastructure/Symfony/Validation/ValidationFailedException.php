<?php

namespace Witrac\Shared\Infrastructure\Symfony\Validation;

use Exception;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationFailedException extends Exception
{
    public function __construct(
        private ConstraintViolationList $errors,
        string $message = 'Validation failed'
    ) {
        parent::__construct($message);
    }

    /**
     * @return ConstraintViolationList
     */
    public function getErrors(): ConstraintViolationList
    {
        return $this->errors;
    }
}
