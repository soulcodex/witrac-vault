<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\Library;

use Witrac\Shared\Infrastructure\Persistence\Doctrine\UuidType;
use Witrac\Vault\Domain\Library\LibraryUuid;

class LibraryUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return LibraryUuid::class;
    }
}
