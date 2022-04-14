<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus\Query;

use Witrac\Shared\Domain\Bus\Query\Query;
use Witrac\Shared\Domain\Bus\Query\QueryBus;
use Witrac\Shared\Domain\Bus\Query\Response;
use Witrac\Shared\Infrastructure\Bus\Exception\QueryNotRegisteredError;
use Witrac\Shared\Infrastructure\Bus\GetHandlersByFirstParameter;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class InMemorySymfonyQueryBus implements QueryBus
{
    private MessageBus $bus;

    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(GetHandlersByFirstParameter::forCallables($queryHandlers))
            ),
        ]);
    }

    /**
     * @throws QueryNotRegisteredError
     */
    public function fetch(Query $query): ?Response
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException $unused) {
            throw new QueryNotRegisteredError($query);
        }
    }
}
