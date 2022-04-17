<?php

namespace Witrac\Tests\Unit\Vault\Application\Query\Library;

use Witrac\Tests\Support\Vault\Domain\Library\LibraryMother;
use Witrac\Vault\Application\Query\Library\Collection\LibraryCollectionQuery;
use Witrac\Vault\Application\Query\Library\Collection\LibraryCollectionQueryHandler;
use Witrac\Vault\Application\Query\Library\LibraryCollectionResponse;

class LibraryCollectionQueryHandlerTest extends LibraryQueryTestCase
{
    private LibraryCollectionQueryHandler $queryHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryHandler = new LibraryCollectionQueryHandler(
            $this->repository()
        );
    }

    public function testItCanRetrieveLibraryCollection(): void
    {
        $libraries = [LibraryMother::random()];

        $this->repositoryShouldReturn(...$libraries);

        $collection = ($this->queryHandler)(new LibraryCollectionQuery());

        self::assertInstanceOf(LibraryCollectionResponse::class, $collection);
        self::assertCount(1, $collection->libraries());
    }
}
