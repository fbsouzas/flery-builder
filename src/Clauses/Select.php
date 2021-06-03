<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class Select implements Clause
{
    public function apply(Builder $query, array $clauses): Builder
    {
        if ($this->hasFieldsClause($clauses)) {
            $query->select(explode(',', $clauses['fields']));
        }

        return $query;
    }

    private function hasFieldsClause(array $clauses): bool
    {
        return array_key_exists('fields', $clauses);
    }
}
