<?php

namespace Witrac\Tests\Unit\Vault\Application\Command\Library;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Witrac\Shared\Domain\Bus\Event\Event;
use Witrac\Shared\Domain\Bus\Event\EventBus;
use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\Library\LibraryRepository;

abstract class LibraryCommandTestCase extends TestCase
{
    protected MockObject $repository;

    protected MockObject $eventBus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = self::createMock(LibraryRepository::class);
        $this->eventBus = self::createMock(EventBus::class);
    }

    /**
     * @return LibraryRepository
     */
    protected function repository(): LibraryRepository
    {
        return $this->repository;
    }

    /**
     * @return EventBus
     */
    protected function eventBus(): EventBus
    {
        return $this->eventBus;
    }

    /**
     * @param Library $libraryMother
     * @return void
     */
    protected function shouldSave(Library $libraryMother): void
    {
        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Library $library) use ($libraryMother) {
                return $this->lookSimilar($library->toArray(), $libraryMother->toArray());
            }));
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
     * @param array $libraryOne
     * @param array $libraryTwo
     *
     * @return bool
     */
    protected function lookSimilar(array $libraryOne, array $libraryTwo): bool
    {
        return $libraryOne['name'] === $libraryTwo['name'];
    }
}
