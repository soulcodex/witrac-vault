<?php

namespace Witrac\Tests\Shared\Infrastructure\Doctrine;

interface DatabasePreparer
{
    public function beforeClass(): void;

    public function afterClass(): void;

    public function beforeTest(): void;

    public function afterTest(): void;
}
