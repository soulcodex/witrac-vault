<?php

namespace Witrac\Vault\Domain\Library\Event;

use Witrac\Shared\Domain\Bus\Event\Event;
use Witrac\Vault\Domain\Library\Library;

final class LibraryCreatedEvent extends Event
{
    public function __construct(
        private Library $library,
        string $eventId = null,
        string $createdAt = null
    ) {
        parent::__construct(
            $this->library->id(),
            $eventId,
            $createdAt
        );
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $createdAt): Event
    {
        return new self(
            Library::fromArray($body),
            $eventId,
            $createdAt
        );
    }

    public static function eventName(): string
    {
        return 'witrac.vault.library.created';
    }

    public function toPrimitives(): array
    {
        return $this->library->toArray();
    }
}
