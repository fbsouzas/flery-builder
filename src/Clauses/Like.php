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

    public function apply(Builder $query, array $clauses): Builder
    {
        if ($this->hasSearchClause($clauses)) {
            $query = $this->like($query, $clauses['search']);
        }

        return $this->next->apply($query, $clauses);
    }

    private function hasSearchClause(array $clauses): bool
    {
        return array_key_exists('search', $clauses);
    }

    private function like(Builder $query, array $likeClause): Builder
    {
        foreach ($likeClause as $field => $value) {
            $query->where($field, 'like', "%{$value}%");
        }

        return $query;
    }
}
