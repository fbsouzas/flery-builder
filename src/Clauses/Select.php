<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

class Select implements Clause
{
    public function apply(Builder $query, array $clauses): Builder
    {
        if ($this->hasSelectClause($clauses)) {
            $query->select(explode(',', $clauses['select']));
        }

        return $query;
    }

    private function hasSelectClause(array $clauses): bool
    {
        return array_key_exists('select', $clauses);
    }
}