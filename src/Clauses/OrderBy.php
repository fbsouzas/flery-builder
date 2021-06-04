<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class OrderBy implements Clause
{
    private Clause $next;

    public function __construct(Clause $next)
    {
        $this->next = $next;
    }

    public function apply(Builder $query, array $queryStrings): Builder
    {
        if ($this->hasSortQueryString($queryStrings)) {
            $query = $this->orderBy($query, $queryStrings['sort']);
        }

        return $this->next->apply($query, $queryStrings);
    }

    /** @param array<String> $queryStrings */
    private function hasSortQueryString(array $queryStrings): bool
    {
        return array_key_exists('sort', $queryStrings);
    }

    private function orderBy(Builder $query, string $sortQueryString): Builder
    {
        $sorts = explode(',', $sortQueryString);

        foreach ($sorts as $sort) {
            $column = str_replace('-', '', $sort);
            $order = $this->order($sort);

            $query->orderBy($column, $order);
        }

        return $query;
    }

    private function order(string $sort): string
    {
        $order = 'asc';

        if ('-' === substr($sort, 0, 1)) {
            $order = 'desc';
        }

        return $order;
    }
}
