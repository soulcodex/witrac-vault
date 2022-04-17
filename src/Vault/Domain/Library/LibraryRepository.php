<?php

namespace Witrac\Vault\Domain\Library;

use Witrac\Shared\Domain\Repository\Exception\NotFoundException;

interface LibraryRepository
{
    /**
     * @return Library[]
     */
    public function all(): array;

    public function save(Library $library): void;

    public function findById(LibraryUuid $id): ?Library;

    /**
     * @throws NotFoundException
     */
    public function findByIdOrFail(LibraryUuid $id): Library;

    public function findByName(LibraryName $name): ?Library;
}
