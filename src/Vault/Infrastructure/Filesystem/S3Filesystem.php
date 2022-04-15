<?php

namespace Witrac\Vault\Infrastructure\Filesystem;

use League\Flysystem\FilesystemException as LeagueFilesystemException;
use League\Flysystem\FilesystemOperator;
use Witrac\Shared\Domain\Exception\FilesystemException;
use Witrac\Shared\Domain\Filesystem\Filesystem;

class S3Filesystem implements Filesystem
{
    public function __construct(
        private FilesystemOperator $awsStorage
    ) {
    }

    /**
     * @throws FilesystemException
     */
    public function create(string $path, string $content): void
    {
        try {
            $this->awsStorage->write($path, $content);
        } catch (LeagueFilesystemException $e) {
            throw new FilesystemException($e->getMessage());
        }
    }

    /**
     * @throws FilesystemException
     */
    public function read(string $path)
    {
        try {
            return $this->awsStorage->readStream($path);
        } catch (LeagueFilesystemException $e) {
            throw new FilesystemException($e->getMessage());
        }
    }
}
