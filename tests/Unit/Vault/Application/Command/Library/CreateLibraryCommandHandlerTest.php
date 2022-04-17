<?php

namespace Witrac\Tests\Unit\Vault\Application\Command\Library;

use Witrac\Tests\Support\Vault\Domain\Library\LibraryCreatedEventMother;
use Witrac\Tests\Support\Vault\Domain\Library\LibraryMother;
use Witrac\Vault\Application\Command\Library\Create\CreateLibraryCommand;
use Witrac\Vault\Application\Command\Library\Create\CreateLibraryCommandHandler;

class CreateLibraryCommandHandlerTest extends LibraryCommandTestCase
{
    private CreateLibraryCommandHandler $commandHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandHandler = new CreateLibraryCommandHandler(
            $this->repository(),
            $this->eventBus()
        );
    }

    public function testItCreateALibrarySuccessfully(): void
    {
        $libraryName = 'Witrac Technical Test';
        $library = LibraryMother::createOne(['name' => $libraryName]);
        $event = LibraryCreatedEventMother::fromLibrary($library);

        $this->shouldSave($library);
        $this->shouldPublishDomainEvent($event);

        ($this->commandHandler)(new CreateLibraryCommand($libraryName));
    }
}
