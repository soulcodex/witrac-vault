<?php

namespace App\Vault\Controller\Library;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Witrac\Shared\Domain\Bus\Command\CommandBus;

class UpdateLibraryController
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(string $id, Request $request): Response
    {
        dd($id);
        return new Response();
    }
}
