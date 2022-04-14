<?php

namespace Witrac\Shared\Domain\Exception;

use Exception;
use Throwable;

class InvalidJsonException extends Exception
{
    /**
     * @param string $json
     * @param int $code
     *
     * @param Throwable|null $previous
     */
    public function __construct(string $json = '', int $code = 0, Throwable $previous = null)
    {
        $message = sprintf("The string provided it's not a valid json: %s", $json);
        parent::__construct($message, $code, $previous);
    }
}
