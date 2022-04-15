<?php

namespace Witrac\Shared\Domain\Filesystem;

use Witrac\Shared\Domain\Exception\FilesystemException;

interface Filesystem
{
    /**
     * @throws FilesystemException
     */
    public function create(string $path, string $content): void;

    /**
     * @throws FilesystemException
     */
    public function read(string $path);
}
