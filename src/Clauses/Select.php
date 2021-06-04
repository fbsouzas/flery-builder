<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class Select implements Clause
{
    public function apply(Builder $query, array $queryStrings): Builder
    {
        if ($this->hasFieldsQueryString($queryStrings)) {
            $query->select(explode(',', $queryStrings['fields']));
        }

        return $query;
    }

    /** @param array<String> $queryStrings */
    private function hasFieldsQueryString(array $queryStrings): bool
    {
        return array_key_exists('fields', $queryStrings);
    }
}
