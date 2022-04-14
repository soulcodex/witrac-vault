<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus\Event;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use function Lambdish\Phunctional\each;
use Witrac\Shared\Domain\Bus\Event\Event;
use Witrac\Shared\Domain\Bus\Event\EventBus;
use Witrac\Shared\Domain\Utils;

final class MySqlDoctrineEventBus implements EventBus
{
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function publish(Event ...$events): void
    {
        each($this->execute(), $events);
    }

    private function execute(): callable
    {
        return function (Event $event): void {
            $id = $this->connection->quote($event->eventId());
            $aggregateId = $this->connection->quote($event->aggregateId());
            $name = $this->connection->quote($event::eventName());
            $body = $this->connection->quote(Utils::jsonEncode($event->toPrimitives()));
            $date = Utils::fromStringToDate($event->occurredOn());
            $ocurredOn = $this->connection->quote(Utils::dateToDatabaseString($date));

            $eventInsertQuery = <<<EOF
                INSERT INTO `%s` (id, aggregate_id, name,  body, created_at)
                VALUES (%s, %s, %s, %s, %s)
            EOF;

            $this->connection->executeQuery(sprintf(
                $eventInsertQuery,
                self::STORE_ON,
                $id,
                $aggregateId,
                $name,
                $body,
                $ocurredOn
            ));
        };
    }
}
