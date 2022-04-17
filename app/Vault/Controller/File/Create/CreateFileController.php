<?php

namespace App\Vault\Controller\File\Create;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Witrac\Shared\Domain\Bus\Command\CommandBus;
use Witrac\Shared\Infrastructure\Http\ErrorResponse;
use Witrac\Shared\Infrastructure\Http\ValidationResponse;
use Witrac\Shared\Infrastructure\Symfony\Validation\ValidationFailedException;
use Witrac\Vault\Application\Command\File\Create\CreateFileCommand;
use Witrac\Vault\Domain\Library\LibraryUuid;

class CreateFileController
{
    public function __construct(
        private CommandBus $commandBus,
        private ParameterBagInterface $bag
    ) {
    }

    public function __invoke(Request $request): Response
    {
        try {
            CreateFileValidation::validated($request, $this->bag);

            /** @var UploadedFile $file */
            $file = $request->files->get('file');

            $command = new CreateFileCommand(
                $file,
                $file->getClientOriginalName(),
                new LibraryUuid($request->request->get('library'))
            );

            $this->commandBus->dispatch($command);

            return new Response(null, Response::HTTP_CREATED);
        } catch (ValidationFailedException $e) {
            return new ValidationResponse($e->getErrors());
        } catch (Exception $e) {
            return new ErrorResponse($e);
        }
    }
}
