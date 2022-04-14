<?php

namespace Witrac\Shared\Domain\Bus\Event;

use function Lambdish\Phunctional\reindex;
use Witrac\Shared\Domain\Exception\EventMappingException;

final class EventMapper
{
    private array $mapping;

    /**
     * @param array<class-string> $mapping
     */
    public function __construct(array $mapping)
    {
        $this->mapping = reindex(fn (string $class) => ($class)::eventName(), $mapping);
    }

    /**
     * @throws EventMappingException
     */
    public function for(string $name)
    {
        if (!isset($this->mapping[$name])) {
            throw new EventMappingException(sprintf('No event class mapped for <%s>', $name));
        }

        return $this->mapping[$name];
    }
}
