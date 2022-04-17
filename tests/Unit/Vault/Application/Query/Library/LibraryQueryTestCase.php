<?php

namespace Witrac\Tests\Unit\Vault\Application\Query\Library;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\Library\LibraryRepository;

abstract class LibraryQueryTestCase extends TestCase
{
    protected MockObject $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = self::createMock(LibraryRepository::class);
    }

    protected function repository(): LibraryRepository
    {
        return $this->repository;
    }

    protected function repositoryShouldReturn(Library ...$libraries): void
    {
        $this->repository
            ->expects($this->any())
            ->method('all')
            ->willReturn($libraries);
    }
}
