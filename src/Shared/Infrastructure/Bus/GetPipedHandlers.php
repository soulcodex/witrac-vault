<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus;

use Witrac\Shared\Domain\Bus\Event\EventSubscriber;
use function Lambdish\Phunctional\reduce;

class GetPipedHandlers
{
    public static function forPipedCallables(iterable $callables): array
    {
        return reduce(self::pipedCallablesReducer(), $callables, []);
    }

    private static function pipedCallablesReducer(): callable
    {
        return static function ($subscribers, EventSubscriber $subscriber): array {
            $subscribedEvents = $subscriber::subscribedTo();

            foreach ($subscribedEvents as $subscribedEvent) {
                $subscribers[$subscribedEvent][] = $subscriber;
            }

            return $subscribers;
        };
    }
}
