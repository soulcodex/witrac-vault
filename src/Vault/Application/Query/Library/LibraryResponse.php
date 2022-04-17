<?php

namespace Witrac\Vault\Application\Query\Library;

use DateTimeInterface;

final class LibraryResponse
{
    public function __construct(
        private string $id,
        private string $name,
        private int $files,
        private string $createdAt
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function files(): int
    {
        return $this->files;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
