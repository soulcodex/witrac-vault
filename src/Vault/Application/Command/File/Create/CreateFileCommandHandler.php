<?php

namespace Witrac\Vault\Application\Command\File\Create;

use Exception;
use Witrac\Shared\Domain\Bus\Command\CommandHandler;
use Witrac\Shared\Domain\Bus\Event\EventBus;
use Witrac\Shared\Domain\Exception\FilesystemException;
use Witrac\Shared\Domain\Filesystem\Filesystem;
use Witrac\Shared\Domain\Repository\Exception\NotFoundException;
use Witrac\Vault\Domain\File\File;
use Witrac\Vault\Domain\File\FileRepository;
use Witrac\Vault\Domain\File\FileStatus;
use Witrac\Vault\Domain\File\FileUuid;
use Witrac\Vault\Domain\Library\LibraryRepository;

class CreateFileCommandHandler implements CommandHandler
{
    public function __construct(
        private FileRepository $fileRepository,
        private LibraryRepository $libraryRepository,
        private EventBus $eventBus,
        private Filesystem $filesystem
    ) {
    }

    /**
     * @throws FilesystemException
     * @throws NotFoundException
     */
    public function __invoke(CreateFileCommand $command): File
    {
        $fileIdentifier = FileUuid::generate();

        $library = $this->libraryRepository->findByIdOrFail($command->library());

        $this->filesystem->create(
            $filePath = sprintf('%s_%s', $fileIdentifier, round(microtime(true) * 1000)),
            $this->getFileContents($command->file()->getRealPath())
        );

        $file = File::create([
            'id' => $fileIdentifier,
            'name' => $command->fileName(),
            'path' => $filePath,
            'size' => $command->file()->getSize(),
            'mime' => mime_content_type($command->file()->getRealPath()),
            'status' => FileStatus::UPLOADED,
        ]);

        $this->fileRepository->save($file);
        $this->eventBus->publish(...$file->pullEvents());

        return $file;
    }

    /**
     * @throws FilesystemException
     */
    private function getFileContents(mixed $path): string
    {
        try {
            if (!is_string($path) && false === $path) {
                throw new FilesystemException('Invalid file path');
            }

            $content = file_get_contents($path);

            if (false === $content) {
                throw new FilesystemException(sprintf('File read operation failed for path <%s>', $path));
            }

            return $content;
        } catch (Exception $e) {
            throw new FilesystemException($e->getMessage());
        }
    }
}
