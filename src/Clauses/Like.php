<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class Like implements Clause
{
    private Clause $next;

    public function __construct(Clause $next)
    {
        $this->next = $next;
    }

    public function apply(Builder $query, array $queryStrings): Builder
    {
        if ($this->hasSearchQueryString($queryStrings)) {
            $query = $this->like($query, $queryStrings['search']);
        }

        return $this->next->apply($query, $queryStrings);
    }

    /** @param array<Mixed> $queryStrings */
    private function hasSearchQueryString(array $queryStrings): bool
    {
        return array_key_exists('search', $queryStrings);
    }

    /** @param array<string, String> $searchQueryString */
    private function like(Builder $query, array $searchQueryString): Builder
    {
        foreach ($searchQueryString as $field => $value) {
            $query->where($field, 'like', "%{$value}%");
        }

        return $query;
    }
}
