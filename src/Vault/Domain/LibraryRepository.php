<?php

namespace Witrac\Vault\Domain;

use Witrac\Shared\Domain\Repository\Exception\NotFoundException;
use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\Library\LibraryName;
use Witrac\Vault\Domain\Library\LibraryUuid;

interface LibraryRepository
{
    public function save(Library $library): void;

    public function findById(LibraryUuid $id): ?Library;

    /**
     * @throws NotFoundException
     */
    public function findByIdOrFail(LibraryUuid $id): Library;

    public function findByName(LibraryName $name): ?Library;
}
