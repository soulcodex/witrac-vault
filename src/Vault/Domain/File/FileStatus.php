<?php

namespace Witrac\Vault\Domain\File;

use Witrac\Shared\Domain\ValueObject\NotNullString;

class FileStatus extends NotNullString
{
    public const UPLOADED = 'UPLOADED';
    public const READY_TO_UPLOAD = 'READY_TO_UPLOAD';
    public const TRASHED = 'TRASHED';

    public static function uploaded(): self
    {
        return new self(self::UPLOADED);
    }

    public static function readyToUpload(): self
    {
        return new self(self::READY_TO_UPLOAD);
    }

    public static function trashed(): self
    {
        return new self(self::TRASHED);
    }
}
