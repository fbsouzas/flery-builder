<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder;

use Fbsouzas\QueryBuilder\Clauses\ClauseChain;
use Illuminate\Database\Eloquent\Model;

class QueryBuilder
{
    private Model $model;

    public function to(string $model): self
    {
        $this->model = new $model;

        return $this;
    }

    public function apply(array $clauses)
    {
        $builder = ($this->model)->newQuery();

        $chain = new ClauseChain($builder, $clauses);
        $query = $chain->dispatch();

        return $query;
    }
}
