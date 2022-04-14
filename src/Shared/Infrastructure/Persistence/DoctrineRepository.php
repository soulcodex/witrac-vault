<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Witrac\Shared\Domain\Aggregate\AggregateRoot;
use Witrac\Shared\Domain\Repository\Exception\NotFoundException;

abstract class DoctrineRepository
{
    protected string $entityClass;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, string $entityClass)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush($entity);
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush($entity);
    }

    protected function repository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->entityClass);
    }

    /**
     * @throws NotFoundException
     */
    public function findOneBy(array $parameters, array $sortBy = null)
    {
        $entity = $this->repository()->findOneBy($parameters, $sortBy);

        if (null === $entity) {
            throw new NotFoundException($this->entityClass);
        }

        return $entity;
    }
}
