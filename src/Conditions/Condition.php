<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Conditions;

use Illuminate\Database\Eloquent\Builder;

interface Condition
{
    public function apply(Builder $query, array $conditions): Builder;
}
