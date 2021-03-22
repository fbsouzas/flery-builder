<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class Order implements Clause
{
    private Clause $next;

    public function __construct(Clause $next)
    {
        $this->next = $next;
    }

    public function apply(Builder $query, array $clauses): Builder
    {
        if ($this->hasOrderClause($clauses)) {
            $query = $this->order($query, $clauses['order']);
        }

        return $this->next->apply($query, $clauses);
    }

    private function hasOrderClause(array $clauses): bool
    {
        return array_key_exists('order', $clauses);
    }

    private function order(Builder $query, array $orderClause): Builder
    {
        foreach ($orderClause as $order => $attribute) {
            $query->orderBy($attribute, $order);
        }

        return $query;
    }
}