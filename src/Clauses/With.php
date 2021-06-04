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

    public function apply(Builder $query, array $queryStrings): Builder
    {
        if ($this->hasWithQueryString($queryStrings)) {
            $this->with($query, $queryStrings['with']);
        }

        return $this->next->apply($query, $queryStrings);
    }

    /** @param array<String> $queryStrings */
    private function hasWithQueryString(array $queryStrings): bool
    {
        return array_key_exists('with', $queryStrings);
    }

    private function with(Builder $query, string $withQueryString): Builder
    {
        $relationships = explode(';', $withQueryString);

        foreach ($relationships as $relationship) {
            $query->with($relationship);
        }

        return $query;
    }
}
