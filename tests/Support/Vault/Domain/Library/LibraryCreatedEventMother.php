<?php

namespace Witrac\Tests\Support\Vault\Domain\Library;

use Witrac\Vault\Domain\Library\Event\LibraryCreatedEvent;
use Witrac\Vault\Domain\Library\Library;

final class LibraryCreatedEventMother
{
    public static function fromLibrary(Library $library): LibraryCreatedEvent
    {
        return new LibraryCreatedEvent($library);
    }
}
