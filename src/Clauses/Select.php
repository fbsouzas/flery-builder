<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class Select implements Clause
{
    public function apply(Builder $query, array $clauses): Builder
    {
        $isSelect = array_key_exists('select', $clauses);

        if ($isSelect) {
            $query->select(explode(',', $clauses['select']));
        }

        return $query;
    }
}
