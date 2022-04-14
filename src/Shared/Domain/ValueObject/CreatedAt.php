<?php

namespace Witrac\Shared\Domain\ValueObject;

use DateTimeInterface;
use Witrac\Shared\Domain\Utils;

class CreatedAt
{
    protected DateTimeInterface $date;

    public function __construct(DateTimeInterface $date = null)
    {
        if (!$date instanceof DateTimeInterface) {
            $date = new \DateTimeImmutable();
        }

        $this->date = $date;
    }

    public function date(): DateTimeInterface
    {
        return $this->date;
    }

    public function value(): string
    {
        return Utils::fromDateToString($this->date());
    }
}
