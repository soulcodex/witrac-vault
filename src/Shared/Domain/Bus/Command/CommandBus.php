<?php

namespace Witrac\Shared\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $job): void;
}
