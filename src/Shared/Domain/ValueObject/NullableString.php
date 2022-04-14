<?php

namespace Witrac\Shared\Domain\ValueObject;

class NullableString
{
    protected ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
