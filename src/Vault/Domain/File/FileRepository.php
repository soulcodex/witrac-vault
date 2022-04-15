<?php

namespace Witrac\Vault\Domain\File;

use Witrac\Shared\Domain\Repository\Exception\NotFoundException;
use Witrac\Vault\Domain\Library\LibraryUuid;

interface FileRepository
{
    public function save(File $file): void;

    public function findById(FileUuid $id): ?File;

    /**
     * @throws NotFoundException
     */
    public function findByIdOrFail(FileUuid $id): File;

    /**
     * @return File[]
     */
    public function findByLibrary(LibraryUuid $id): array;
}
