<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus\Event;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use function Lambdish\Phunctional\map;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Witrac\Shared\Domain\Bus\Event\Event;
use Witrac\Shared\Domain\Bus\Event\EventMapper;
use Witrac\Shared\Domain\Utils;
use Witrac\Shared\Infrastructure\Bus\GetPipedHandlers;

final class MySqlDoctrineEventConsumer
{
    private Connection $connection;
    private MessageBus $bus;
    private EventMapper $eventMapper;

    public function __construct(
        iterable $commandHandlers,
        EntityManagerInterface $entityManager,
        EventMapper $eventMapper
    ) {
        $this->connection = $entityManager->getConnection();
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(GetPipedHandlers::forPipedCallables($commandHandlers))
            ),
        ]);
        $this->eventMapper = $eventMapper;
    }

    public function consume(Event $event): void
    {
        try {
            $this->bus->dispatch($event);
        } catch (NoHandlerForMessageException $exception) {
        }
    }

    /**
     * @return Event[]
     *
     * @throws Exception
     */
    public function getEventsToConsume(int $quantity = 100): array
    {
        $consumeEventsQuery = <<<EOF
            SELECT * FROM `%s` ORDER BY created_at LIMIT %d
        EOF;

        $rawEvents = $this->connection
            ->executeQuery(sprintf($consumeEventsQuery, MySqlDoctrineEventBus::DOMAIN_EVENTS_TABLE, $quantity))
            ->fetchAllAssociative();

        return map($this->constructEvent(), $rawEvents);
    }

    private function constructEvent(): callable
    {
        return function (array $rawEvent): Event {
            $class = $this->eventMapper->for($rawEvent['name']);

            return ($class)::fromPrimitives(
                $rawEvent['aggregate_id'],
                Utils::jsonDecode($rawEvent['body']),
                $rawEvent['id'],
                $rawEvent['created_at']
            );
        };
    }
}
