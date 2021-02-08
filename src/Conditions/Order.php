<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Conditions;

use Illuminate\Database\Eloquent\Builder;

class Order implements Condition
{
    private Condition $next;

    public function __construct(Condition $next)
    {
        $this->next = $next;
    }

    public function apply(Builder $query, array $conditions): Builder
    {
        $isOrder = array_key_exists('order', $conditions);

        if ($isOrder) {
            foreach ($conditions['order'] as $order => $attribute) {
                $query->orderBy($attribute, $order);
            }
        }

        return $this->next->apply($query, $conditions);
    }
}