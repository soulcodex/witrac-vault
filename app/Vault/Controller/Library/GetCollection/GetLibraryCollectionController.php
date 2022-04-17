<?php

namespace App\Vault\Controller\Library\GetCollection;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Witrac\Shared\Domain\Bus\Query\QueryBus;
use Witrac\Vault\Application\Query\Library\Collection\LibraryCollectionQuery;
use Witrac\Vault\Application\Query\Library\LibraryResponse;

class GetLibraryCollectionController
{
    public function __construct(
        private QueryBus $queryBus
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $libraries = $this->queryBus->fetch(new LibraryCollectionQuery());

        $librariesCollection = fn (LibraryResponse $library) => [
          'id' => $library->id(),
          'name' => $library->name(),
          'files' => $library->files(),
          'createdAt' => $library->createdAt(),
        ];

        return new JsonResponse(
            array_map($librariesCollection, $libraries->libraries()),
            Response::HTTP_OK
        );
    }
}
