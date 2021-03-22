<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

interface Clause
{
    public function apply(Builder $query, array $clauses): Builder;
}
