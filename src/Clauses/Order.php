<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

class Order implements Clause
{
    private Clause $next;

    public function __construct(Clause $next)
    {
        $this->next = $next;
    }

    public function apply(Builder $query, array $clauses): Builder
    {
        if ($this->hasOrderClause($clauses)) {
            foreach ($clauses['order'] as $order => $attribute) {
                $query->orderBy($attribute, $order);
            }
        }

        return $this->next->apply($query, $clauses);
    }

    private function hasOrderClause(array $clauses): bool
    {
        return array_key_exists('order', $clauses);
    }
}