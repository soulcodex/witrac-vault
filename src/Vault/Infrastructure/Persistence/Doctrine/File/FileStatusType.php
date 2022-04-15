<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\File;

use Witrac\Shared\Infrastructure\Persistence\Doctrine\StringType;
use Witrac\Vault\Domain\File\FileStatus;

class FileStatusType extends StringType
{
    protected function typeClassName(): string
    {
        return FileStatus::class;
    }
}
