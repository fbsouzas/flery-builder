<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class ClauseChain
{
    private Builder $query;
    private array $clauses;

    public function __construct(Builder $query, array $clauses)
    {
        $this->query = $query;
        $this->clauses = $clauses;
    }

    public function dispatch()
    {
        $select = new Select();
        $order = new Order($select);
        $like = new Like($order);

        return $like->apply($this->query, $this->clauses);
    }
}
