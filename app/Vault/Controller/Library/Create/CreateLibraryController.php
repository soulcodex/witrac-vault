<?php

namespace App\Vault\Controller\Library\Create;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Witrac\Shared\Domain\Bus\Command\CommandBus;
use Witrac\Shared\Infrastructure\Http\ErrorResponse;
use Witrac\Shared\Infrastructure\Http\ValidationResponse;
use Witrac\Shared\Infrastructure\Symfony\Validation\ValidationFailedException;
use Witrac\Vault\Application\Command\Library\Create\CreateLibraryCommand;

class CreateLibraryController
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request): Response
    {
        try {
            CreateLibraryValidation::validated($request);

            $command = new CreateLibraryCommand($request->request->getAlpha('name'));

            $this->commandBus->dispatch($command);

            return new Response(null, Response::HTTP_CREATED);
        } catch (ValidationFailedException $e) {
            return new ValidationResponse($e->getErrors());
        } catch (Exception $e) {
            return new ErrorResponse($e);
        }
    }
}
