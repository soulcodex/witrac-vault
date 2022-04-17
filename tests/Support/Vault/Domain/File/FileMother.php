<?php

namespace Witrac\Tests\Support\Vault\Domain\File;

use Witrac\Vault\Domain\File\File;
use Witrac\Vault\Domain\File\FileCreatedAt;
use Witrac\Vault\Domain\File\FileMime;
use Witrac\Vault\Domain\File\FileName;
use Witrac\Vault\Domain\File\FilePath;
use Witrac\Vault\Domain\File\FileSize;
use Witrac\Vault\Domain\File\FileStatus;
use Witrac\Vault\Domain\File\FileUpdatedAt;
use Witrac\Vault\Domain\File\FileUuid;

final class FileMother
{
    public static function createOne(array $params): File
    {
        return new File(
            new FileUuid($params['id']),
            new FileName($params['name'] ?? 'report.xls'),
            new FilePath($params['path']),
            new FileSize($params['size'] ?? rand(1000, 2000)),
            new FileMime($params['mime'] ?? 'application/vnd.ms-excel'),
            new FileStatus($params['status'] ?? FileStatus::UPLOADED),
            new FileCreatedAt($params['createdAt'] ?? null),
            new FileUpdatedAt($params['updatedAt'] ?? null)
        );
    }
}
