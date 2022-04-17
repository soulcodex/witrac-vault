<?php

namespace Witrac\Tests\Unit\Vault\Application\Command\File;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Witrac\Shared\Domain\Bus\Event\Event;
use Witrac\Shared\Domain\Bus\Event\EventBus;
use Witrac\Shared\Domain\Filesystem\Filesystem;
use Witrac\Vault\Domain\File\File;
use Witrac\Vault\Domain\File\FileRepository;
use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\Library\LibraryRepository;

abstract class FileCommandTestCase extends TestCase
{
    protected MockObject $fileRepository;

    protected MockObject $libraryRepository;

    protected MockObject $eventBus;

    protected MockObject $fileSystem;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileRepository = self::createMock(FileRepository::class);
        $this->libraryRepository = self::createMock(LibraryRepository::class);
        $this->eventBus = self::createMock(EventBus::class);
        $this->fileSystem = self::createMock(Filesystem::class);
    }

    public function fileRepository(): FileRepository
    {
        return $this->fileRepository;
    }

    public function libraryRepository(): LibraryRepository
    {
        return $this->libraryRepository;
    }

    public function eventBus(): EventBus
    {
        return $this->eventBus;
    }

    public function fileSystem(): Filesystem
    {
        return $this->fileSystem;
    }

    public function shouldSave(File $fileMother): void
    {
        $this->fileRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function (File $file) use ($fileMother) {
                return $this->lookSimilar($file->toArray(), $fileMother->toArray());
            }));
    }

    public function shouldPersistOnFilesystem(): void
    {
        $this->fileSystem
            ->expects($this->once())
            ->method('create');
    }

    public function shouldRetrieveOwnerLibrary(Library $library): void
    {
        $this->libraryRepository
            ->expects($this->once())
            ->method('findByIdOrFail')
            ->willReturn($library);
    }

    /**
     * @param Event $event
     * @return void
     */
    protected function shouldPublishDomainEvent(Event $event): void
    {
        $this->eventBus->method('publish')
            ->with($this->callback(function (Event $ev) use ($event) {
                return $this->lookSimilar($ev->toPrimitives(), $event->toPrimitives());
            }));
    }

    /**
     * @param array $file
     * @param array $other
     *
     * @return bool
     */
    protected function lookSimilar(array $file, array $other): bool
    {
        return $file['name'] === $other['name']
            && $file['size'] === $other['size']
            && $file['status'] === $other['status'];
    }
}
