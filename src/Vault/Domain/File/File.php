<?php

namespace Witrac\Vault\Domain\File;

use Witrac\Shared\Domain\Aggregate\AggregateRoot;
use Witrac\Shared\Domain\Utils;
use Witrac\Vault\Domain\File\Event\FileCreatedEvent;

final class File extends AggregateRoot
{
    /**
     * @param FileUuid           $id
     * @param FileName           $name
     * @param FilePath           $path
     * @param FileSize           $size
     * @param FileMime           $mime
     * @param FileStatus         $status
     * @param FileCreatedAt      $createdAt
     * @param FileUpdatedAt|null $updatedAt
     */
    public function __construct(
        private FileUuid $id,
        private FileName $name,
        private FilePath $path,
        private FileSize $size,
        private FileMime $mime,
        private FileStatus $status,
        private FileCreatedAt $createdAt,
        private ?FileUpdatedAt $updatedAt = null
    ) {
    }

    public function id(): FileUuid
    {
        return $this->id;
    }

    public function name(): FileName
    {
        return $this->name;
    }

    public function path(): FilePath
    {
        return $this->path;
    }

    public function size(): FileSize
    {
        return $this->size;
    }

    public function mime(): FileMime
    {
        return $this->mime;
    }

    public function status(): FileStatus
    {
        return $this->status;
    }

    public function createdAt(): FileCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?FileUpdatedAt
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'path' => $this->path->value(),
            'size' => $this->size->value(),
            'status' => $this->status->value(),
            'createdAt' => $this->createdAt->value(),
            'updatedAt' => $this->updatedAt->value(),
        ];
    }

    public static function create(array $parameters): self
    {
        $file = new self(
            new FileUuid($parameters['id']),
            new FileName($parameters['name']),
            new FilePath($parameters['path']),
            new FileSize($parameters['size']),
            new FileMime($parameters['mime']),
            new FileStatus($parameters['status']),
            new FileCreatedAt(),
            new FileUpdatedAt(),
        );

        $file->record(new FileCreatedEvent($file));

        return $file;
    }

    public static function fromArray(array $parameters): self
    {
        return new self(
            new FileUuid($parameters['id']),
            new FileName($parameters['name']),
            new FilePath($parameters['path']),
            new FileSize($parameters['size']),
            new FileMime($parameters['mime']),
            new FileStatus($parameters['status']),
            new FileCreatedAt(Utils::fromStringToDate($parameters['createdAt'])),
            new FileUpdatedAt(Utils::fromStringToDate($parameters['updatedAt'])),
        );
    }
}
