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

    public function apply(Builder $query, array $clauses): Builder
    {
        if ($this->hasSortClause($clauses)) {
            $query = $this->sort($query, $clauses['sort']);
        }

        return $this->next->apply($query, $clauses);
    }

    private function hasSortClause(array $clauses): bool
    {
        return array_key_exists('sort', $clauses);
    }

    private function sort(Builder $query, string $sortClause): Builder
    {
        $sortClause = explode(',', $sortClause);

        foreach ($sortClause as $clause) {
            $attribute = str_replace('-', '', $clause);
            $order = $this->order($clause);

            $query->orderBy($attribute, $order);
        }

        return $query;
    }

    private function order(string $sortClause): string
    {
        $order = 'asc';

        if ('-' === substr($sortClause, 0, 1)) {
            $order = 'desc';
        }

        return $order;
    }
}
