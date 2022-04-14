<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus\Command;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Throwable;
use Witrac\Shared\Domain\Bus\Command\Command;
use Witrac\Shared\Domain\Bus\Command\CommandBus;
use Witrac\Shared\Infrastructure\Bus\Exception\CommandNotRegisteredError;
use Witrac\Shared\Infrastructure\Bus\GetHandlersByFirstParameter;

class InMemorySymfonyCommandBus implements CommandBus
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(GetHandlersByFirstParameter::forCallables($commandHandlers))
            ),
        ]);
    }

    /**
     * @throws Throwable
     * @throws CommandNotRegisteredError
     */
    public function dispatch(Command $job): void
    {
        try {
            $this->bus->dispatch($job);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredError($job);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious();
        }
    }
}
