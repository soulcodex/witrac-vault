<?php

namespace Witrac\Vault\Application\Command\Library\Create;

use Witrac\Shared\Domain\Bus\Command\CommandHandler;
use Witrac\Shared\Domain\Bus\Event\EventBus;
use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\LibraryRepository;

final class CreateLibraryCommandHandler implements CommandHandler
{
    public function __construct(
        private LibraryRepository $libraryRepository,
        private EventBus $eventBus
    ) {
    }

    /**
     * @param CreateLibraryCommand $command
     * @return Library
     */
    public function __invoke(CreateLibraryCommand $command): Library
    {
        $library = Library::create([
            'name' => $command->name(),
        ]);

        $this->libraryRepository->save($library);
        $this->eventBus->publish(...$library->pullEvents());

        return $library;
    }
}
