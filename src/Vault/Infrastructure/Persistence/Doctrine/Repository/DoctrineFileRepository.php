<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Witrac\Shared\Domain\Repository\Exception\NotFoundException;
use Witrac\Shared\Infrastructure\Persistence\DoctrineRepository;
use Witrac\Vault\Domain\File\File;
use Witrac\Vault\Domain\File\FileRepository;
use Witrac\Vault\Domain\File\FileUuid;
use Witrac\Vault\Domain\Library\LibraryUuid;

class DoctrineFileRepository extends DoctrineRepository implements FileRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, File::class);
    }

    public function save(File $file): void
    {
        $this->persist($file);
    }

    public function findById(FileUuid $id): ?File
    {
        try {
            return $this->findOneBy(['id' => $id->value()]);
        } catch (NotFoundException) {
            return null;
        }
    }

    public function findByIdOrFail(FileUuid $id): File
    {
        return $this->findOneBy(['id' => $id->value()]);
    }

    public function findByLibrary(LibraryUuid $id): array
    {
        return [];
    }
}
