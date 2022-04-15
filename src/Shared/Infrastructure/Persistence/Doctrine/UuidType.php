<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Witrac\Shared\Domain\Utils;
use Witrac\Shared\Domain\ValueObject\Uuid;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public function getName(): string
    {
        return self::customTypeName();
    }

    public static function customTypeName(): string
    {
        $nameSpace = explode('\\', static::class);

        return Utils::toSnakeCase(str_replace('Type', '', end($nameSpace)));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof Uuid) {
            return $value;
        }

        return $value->value();
    }
}
