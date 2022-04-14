<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus\Exception;

use Witrac\Shared\Domain\Bus\Query\Query;

class QueryNotRegisteredError extends \Exception
{
    /**
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $message = sprintf(
            'Query with class %s has no handler registered',
            get_class($query)
        );

        parent::__construct($message);
    }
}
