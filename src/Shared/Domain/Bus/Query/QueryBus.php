<?php

namespace Witrac\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function fetch(Query $query): ?Response;
}