<?php

namespace Witrac\Shared\Domain\ValueObject;

use DateTimeInterface;
use Witrac\Shared\Domain\Utils;

class UpdatedAt
{
    protected ?DateTimeInterface $date = null;

    public function __construct(?DateTimeInterface $date = null)
    {
        $this->date = $date;
    }

    public function date(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function value(): ?string
    {
        return $this->date() instanceof DateTimeInterface ? Utils::fromDateToString($this->date()) : null;
    }
}
