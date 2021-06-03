<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Clauses;

use Illuminate\Database\Eloquent\Builder;

final class ClauseChain
{
    private Builder $query;
    private array $queryStrings;

    public function __construct(Builder $query, array $queryStrings)
    {
        $this->query = $query;
        $this->queryStrings = $queryStrings;
    }

    public function dispatch(): Builder
    {
        $select = new Select();
        $with = new With($select);
        $orderBy = new OrderBy($with);
        $like = new Like($orderBy);

        return $like->apply($this->query, $this->queryStrings);
    }
}
