<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Bus;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reindex;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class GetHandlersByFirstParameter
{
    public static function forCallables(iterable $callables): array
    {
        return map(self::unFlatten(), reindex(self::classExtractor(new self()), $callables));
    }

    private static function classExtractor(self $parameterExtractor): callable
    {
        return static fn (callable $handler): string => $parameterExtractor->extract($handler);
    }

    private static function unFlatten(): callable
    {
        return static fn ($value) => [$value];
    }

    /**
     * @throws ReflectionException
     */
    public function extract($class): ?string
    {
        $reflector = new ReflectionClass($class);
        $method = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    private function firstParameterClassFrom(ReflectionMethod $method): string
    {
        return $method->getParameters()[0]->getType()->getName();
    }

    private function hasOnlyOneParameter(ReflectionMethod $method): bool
    {
        return 1 === $method->getNumberOfParameters();
    }
}
