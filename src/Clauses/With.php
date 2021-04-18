<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class With implements Clause
{
    private Clause $next;

    public function __construct(Clause $next)
    {
        $this->next = $next;
    }

    public function apply(Builder $query, array $clauses): Builder
    {
        if ($this->hasWithClause($clauses)) {
            $this->with($query, $clauses['with']);
        }

        return $this->next->apply($query, $clauses);
    }

    private function hasWithClause(array $clauses): bool
    {
        return array_key_exists('with', $clauses);
    }

    private function with(Builder $query, string $withClause): Builder
    {
        $relationships = explode(',', $withClause);

        foreach ($relationships as $relationship) {
            $query->with($relationship);
        }

        return $query;
    }
}
