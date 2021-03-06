<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder;

use Fbsouzas\QueryBuilder\Clauses\ClauseChain;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilder
{
    private string $model;

    public function to(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function apply(array $clauses): Builder
    {
        $query = (new $this->model)->newQuery();
        $chain = new ClauseChain($query, $clauses);

        return $chain->dispatch();
    }
}
