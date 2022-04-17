<?php

namespace Witrac\Vault\Application\Command\File\Create;

use SplFileInfo;
use Witrac\Shared\Domain\Bus\Command\Command;
use Witrac\Vault\Domain\File\FileUuid;
use Witrac\Vault\Domain\Library\LibraryUuid;

final class CreateFileCommand implements Command
{
    public function __construct(
        private FileUuid $id,
        private SplFileInfo $file,
        private string $fileName,
        private LibraryUuid $library
    ) {
    }

    public function id(): FileUuid
    {
        return $this->id;
    }

    public function file(): SplFileInfo
    {
        return $this->file;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }

    public function library(): LibraryUuid
    {
        return $this->library;
    }
}
