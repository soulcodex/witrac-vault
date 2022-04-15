<?php

namespace Witrac\Vault\Infrastructure\Persistence\Doctrine\File;

use Witrac\Shared\Infrastructure\Persistence\Doctrine\UuidType;
use Witrac\Vault\Domain\File\FileUuid;

class FileUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return FileUuid::class;
    }
}
