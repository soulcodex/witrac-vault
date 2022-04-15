<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\File;

use Witrac\Shared\Infrastructure\Persistence\Doctrine\StringType;
use Witrac\Vault\Domain\File\FilePath;

class FilePathType extends StringType
{
    protected function typeClassName(): string
    {
        return FilePath::class;
    }
}
