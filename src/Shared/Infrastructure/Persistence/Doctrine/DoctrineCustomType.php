<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Persistence\Doctrine;

interface DoctrineCustomType
{
    public static function customTypeName(): string;
}
