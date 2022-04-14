<?php

namespace Witrac\Shared\Domain\Bus\Event;

interface EventSubscriber
{
    public static function subscribedTo(): array;
}