<?php

namespace Witrac\Vault\Application\Query\Library;

use Witrac\Shared\Domain\Bus\Query\Response;

final class LibraryCollectionResponse implements Response
{
    /**
     * @var LibraryResponse[]
     */
    private array $libraries;

    public function __construct(LibraryResponse ...$libraries)
    {
        $this->libraries = $libraries;
    }

    /**
     * @return LibraryResponse[]
     */
    public function libraries(): array
    {
        return $this->libraries;
    }
}
