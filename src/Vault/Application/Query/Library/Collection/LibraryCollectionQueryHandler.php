<?php

namespace Witrac\Vault\Application\Query\Library\Collection;

use Witrac\Shared\Domain\Bus\Query\QueryHandler;
use Witrac\Vault\Application\Query\Library\LibraryCollectionResponse;
use Witrac\Vault\Application\Query\Library\LibraryResponse;
use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\Library\LibraryRepository;

final class LibraryCollectionQueryHandler implements QueryHandler
{
    public function __construct(private LibraryRepository $libraryRepository)
    {
    }

    public function __invoke(LibraryCollectionQuery $query): LibraryCollectionResponse
    {
        $libraries = $this->libraryRepository->all();

        $librariesResponse = array_map(function (Library $library) {
            return new LibraryResponse(
                $library->id()->value(),
                $library->name()->value(),
                count($library->files()),
                $library->createdAt()->value()
            );
        }, $libraries);

        return new LibraryCollectionResponse(...$librariesResponse);
    }
}
