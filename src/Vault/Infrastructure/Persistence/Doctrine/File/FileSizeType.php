<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\File;

use Witrac\Shared\Infrastructure\Persistence\Doctrine\IntegerType;
use Witrac\Vault\Domain\File\FileSize;

class FileSizeType extends IntegerType
{
    protected function typeClassName(): string
    {
        return FileSize::class;
    }
}
