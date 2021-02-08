<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Conditions;

use Illuminate\Database\Eloquent\Builder;

class ConditionChain
{
    private Builder $query;
    private array $conditions;

    public function __construct(Builder $query, array $conditions)
    {
        $this->query = $query;
        $this->conditions = $conditions;
    }

    public function dispatch()
    {
        $select = new Select();
        $order = new Order($select);

        return $order->apply($this->query, $this->conditions);
    }
}
