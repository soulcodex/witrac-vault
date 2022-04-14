<?php

namespace Witrac\Vault\Application\Command\Library\Create;

use Witrac\Shared\Domain\Bus\Command\Command;

final class CreateLibraryCommand implements Command
{
    public function __construct(private string $name)
    {
    }

    public function name(): string
    {
        return $this->name;
    }
}
