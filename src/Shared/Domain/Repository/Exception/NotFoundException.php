<?php

namespace Witrac\Shared\Domain\Repository\Exception;

use Exception;

class NotFoundException extends Exception
{
    /**
     * @param class-string $class
     */
    public function __construct(string $class)
    {
        $message = sprintf('Not found entity of class %s', $class);
        parent::__construct($message);
    }
}
