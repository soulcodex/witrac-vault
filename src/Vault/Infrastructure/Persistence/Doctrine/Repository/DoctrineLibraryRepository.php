<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Witrac\Shared\Domain\Repository\Exception\NotFoundException;
use Witrac\Shared\Infrastructure\Persistence\DoctrineRepository;
use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\Library\LibraryName;
use Witrac\Vault\Domain\Library\LibraryUuid;
use Witrac\Vault\Domain\Library\LibraryRepository;

class DoctrineLibraryRepository extends DoctrineRepository implements LibraryRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Library::class);
    }

    /**
     * @return Library[]
     */
    public function all(): array
    {
        return $this->repository()->findAll();
    }

    public function save(Library $library): void
    {
        $this->persist($library);
    }

    public function findById(LibraryUuid $id): ?Library
    {
        try {
            return $this->findOneBy(['id' => $id->value()]);
        } catch (NotFoundException) {
            return null;
        }
    }

    public function findByIdOrFail(LibraryUuid $id): Library
    {
        return $this->findOneBy(['id' => $id->value()]);
    }

    public function findByName(LibraryName $name): ?Library
    {
        try {
            return $this->findOneBy(['name' => $name->value()]);
        } catch (NotFoundException) {
            return null;
        }
    }
}
