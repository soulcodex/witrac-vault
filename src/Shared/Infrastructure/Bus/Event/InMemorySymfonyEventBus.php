<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus\Event;

use Witrac\Shared\Domain\Bus\Event\Event;
use Witrac\Shared\Domain\Bus\Event\EventBus;
use Witrac\Shared\Domain\ValueObject\Uuid;
use Witrac\Shared\Infrastructure\Bus\GetPipedHandlers;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final class InMemorySymfonyEventBus implements EventBus
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(GetPipedHandlers::forPipedCallables($commandHandlers))
            ),
        ]);
    }

    public function publish(Event ...$events): void
    {
        foreach ($events as $event) {
            try {
                $event->setEventIdIfNull(Uuid::generate());
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException $exception) {
            }
        }
    }
}
