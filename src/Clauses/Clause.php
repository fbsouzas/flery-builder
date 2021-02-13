<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

interface Clause
{
    public function apply(Builder $query, array $clauses): Builder;
}
