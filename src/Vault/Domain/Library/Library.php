<?php

namespace Witrac\Vault\Domain\Library;

use Witrac\Shared\Domain\Aggregate\AggregateRoot;
use Witrac\Shared\Domain\Utils;
use Witrac\Shared\Domain\ValueObject\Uuid;
use Witrac\Vault\Domain\Library\Event\LibraryCreatedEvent;

final class Library extends AggregateRoot
{
    private LibraryUuid $id;
    private LibraryName $name;
    private LibraryCreatedAt $createdAt;
    private ?LibraryUpdatedAt $updatedAt;

    public function __construct(
        LibraryUuid $id,
        LibraryName $name,
        LibraryCreatedAt $createdAt,
        ?LibraryUpdatedAt $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): LibraryUuid
    {
        return $this->id;
    }

    public function name(): LibraryName
    {
        return $this->name;
    }

    public function createdAt(): LibraryCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): LibraryUpdatedAt
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'createdAt' => $this->createdAt->value(),
            'updatedAt' => $this->updatedAt->value(),
        ];
    }

    public static function create(array $parameters): self
    {
        $library = new self(
            new LibraryUuid(Uuid::generate()),
            new LibraryName($parameters['name']),
            new LibraryCreatedAt(),
            new LibraryUpdatedAt(),
        );

        $library->record(new LibraryCreatedEvent($library));

        return $library;
    }

    public static function fromArray(array $parameters): self
    {
        return new self(
            new LibraryUuid($parameters['id']),
            new LibraryName($parameters['name']),
            new LibraryCreatedAt($parameters['createdAt']),
            new LibraryUpdatedAt(Utils::fromStringToDate($parameters['updatedAt']))
        );
    }
}
