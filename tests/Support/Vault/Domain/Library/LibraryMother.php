<?php

namespace Witrac\Tests\Support\Vault\Domain\Library;

use Witrac\Vault\Domain\Library\Library;
use Witrac\Vault\Domain\Library\LibraryCreatedAt;
use Witrac\Vault\Domain\Library\LibraryName;
use Witrac\Vault\Domain\Library\LibraryUpdatedAt;
use Witrac\Vault\Domain\Library\LibraryUuid;

final class LibraryMother
{
    public const LIBRARY_NAMES = [
        'Fantasy',
        'My Travel Adventures',
        'Workstation',
        'Witrac',
    ];

    public static function createOne(array $params): Library
    {
        return new Library(
            new LibraryUuid(LibraryUuid::generate()),
            new LibraryName($params['name']),
            new LibraryCreatedAt($params['createdAt'] ?? null),
            new LibraryUpdatedAt($params['updatedAt'] ?? null)
        );
    }

    public static function random(): Library
    {
        $randomName = rand(0, count(self::LIBRARY_NAMES) - 1);

        return new Library(
            new LibraryUuid(LibraryUuid::generate()),
            new LibraryName(self::LIBRARY_NAMES[$randomName]),
            new LibraryCreatedAt(),
            new LibraryUpdatedAt()
        );
    }
}
