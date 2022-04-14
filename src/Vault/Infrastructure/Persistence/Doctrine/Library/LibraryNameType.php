<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\Library;

use Witrac\Shared\Infrastructure\Persistence\Doctrine\StringType;
use Witrac\Vault\Domain\Library\LibraryName;

class LibraryNameType extends StringType
{
    protected function typeClassName(): string
    {
        return LibraryName::class;
    }
}
