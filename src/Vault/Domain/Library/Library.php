<?php

namespace Witrac\Vault\Domain\Library;

use Witrac\Shared\Domain\Aggregate\AggregateRoot;
use Witrac\Shared\Domain\Utils;
use Witrac\Shared\Domain\ValueObject\Uuid;
use Witrac\Vault\Domain\Library\Event\LibraryCreatedEvent;

final class Library extends AggregateRoot
{
    /**
     * @param LibraryUuid           $id
     * @param LibraryName           $name
     * @param LibraryCreatedAt      $createdAt
     * @param LibraryUpdatedAt|null $updatedAt
     */
    public function __construct(
        private LibraryUuid $id,
        private LibraryName $name,
        private LibraryCreatedAt $createdAt,
        private ?LibraryUpdatedAt $updatedAt = null
    ) {
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
            new LibraryCreatedAt(Utils::fromStringToDate($parameters['createdAt'])),
            new LibraryUpdatedAt(Utils::fromStringToDate($parameters['updatedAt']))
        );
    }
}
