<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

interface Clause
{
    /** @param array<Mixed> $queryStrings */
    public function apply(Builder $query, array $queryStrings): Builder;
}
