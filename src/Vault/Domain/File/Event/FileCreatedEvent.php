<?php

namespace Witrac\Vault\Domain\File\Event;

use Witrac\Shared\Domain\Bus\Event\Event;
use Witrac\Vault\Domain\File\File;

final class FileCreatedEvent extends Event
{
    public function __construct(
        private File $file,
        string $eventId = null,
        string $createdAt = null
    ) {
        parent::__construct($file->id()->value(), $eventId, $createdAt);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $createdAt): Event
    {
        return new self(
            File::fromArray($body),
            $eventId,
            $createdAt
        );
    }

    public static function eventName(): string
    {
        return 'witrac.vault.file.v1.created';
    }

    public function toPrimitives(): array
    {
        return $this->file->toArray();
    }
}
