<?php

namespace Witrac\Tests\Unit\Vault\Application\Command\File;

use SplFileInfo;
use Witrac\Shared\Domain\Exception\FilesystemException;
use Witrac\Shared\Domain\Repository\Exception\NotFoundException;
use Witrac\Shared\Domain\ValueObject\Uuid;
use Witrac\Tests\Support\Vault\Domain\File\FileCreatedEventMother;
use Witrac\Tests\Support\Vault\Domain\File\FileMother;
use Witrac\Tests\Support\Vault\Domain\Library\LibraryMother;
use Witrac\Vault\Application\Command\File\Create\CreateFileCommand;
use Witrac\Vault\Application\Command\File\Create\CreateFileCommandHandler;
use Witrac\Vault\Domain\File\FileUuid;

class CreateFileCommandHandlerTest extends FileCommandTestCase
{
    private CreateFileCommandHandler $commandHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commandHandler = new CreateFileCommandHandler(
            $this->fileRepository(),
            $this->libraryRepository(),
            $this->eventBus(),
            $this->fileSystem()
        );
    }

    /**
     * @throws FilesystemException
     * @throws NotFoundException
     */
    public function testItCreateAFileSuccessfully(): void
    {
        $rawFile = new SplFileInfo('tests/Support/Mock/report.mock.csv');
        $library = LibraryMother::random();
        $file = FileMother::createOne([
            'id' => $fileId = Uuid::generate(),
            'name' => 'report.mock.csv',
            'mime' => 'text/csv',
            'path' => sprintf('%s_%s', $fileId, round(microtime(true) * 1000)),
            'size' => $rawFile->getSize(),
        ]);
        $event = FileCreatedEventMother::fromFile($file);

        $this->shouldRetrieveOwnerLibrary($library);
        $this->shouldPersistOnFilesystem();
        $this->shouldSave($file);
        $this->shouldPublishDomainEvent($event);

        ($this->commandHandler)(new CreateFileCommand(
            new FileUuid($fileId),
            $rawFile,
            'report.mock.csv',
            $library->id())
        );
    }
}
