<?php

namespace Witrac\Tests\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

interface DatabaseCleaner
{
    public function clean(EntityManagerInterface $entityManager): void;
}
