<?php

namespace Witrac\Shared\Domain\Bus\Event;

interface EventBus
{
    public const STORE_ON = 'domain_events';

    public function publish(Event ...$events): void;
}
