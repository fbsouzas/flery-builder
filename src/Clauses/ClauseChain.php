<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

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

    public function dispatch(): Builder
    {
        $select = new Select();
        $with = new With($select);
        $order = new Order($with);
        $like = new Like($order);

        return $like->apply($this->query, $this->clauses);
    }
}
