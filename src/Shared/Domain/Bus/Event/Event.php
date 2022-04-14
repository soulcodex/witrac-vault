<?php

namespace Witrac\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use Witrac\Shared\Domain\Utils;
use Witrac\Shared\Domain\ValueObject\Uuid;

abstract class Event
{
    private string $aggregateId;
    private string $eventId;
    private string $occurredOn;

    public function __construct(
        string $aggregateId,
        string $eventId = null,
        string $createdAt = null
    ) {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?? Uuid::generate();
        $this->occurredOn = $createdAt ?? Utils::fromDateToString(new DateTimeImmutable());
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $createdAt
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function setEventIdIfNull(string $id)
    {
        $this->eventId ??= $id;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}