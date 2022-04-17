<?php

namespace Witrac\Tests\Support\Vault\Domain\File;

use Witrac\Vault\Domain\File\Event\FileCreatedEvent;
use Witrac\Vault\Domain\File\File;

final class FileCreatedEventMother
{
    public static function fromFile(File $file): FileCreatedEvent
    {
        return new FileCreatedEvent($file);
    }
}