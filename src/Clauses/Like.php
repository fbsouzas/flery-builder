<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Clauses;

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
        if ($this->hasLikeClause($clauses)) {
            $query = $this->like($query, $clauses['like']);
        }

        return $this->next->apply($query, $clauses);
    }

    private function hasLikeClause(array $clauses): bool
    {
        return array_key_exists('like', $clauses);
    }

    private function like(Builder $query, array $likeClause): Builder
    {
        foreach ($likeClause as $field => $value) {
            $query->where($field, 'like', "%{$value}%");
        }

        return $query;
    }
}
