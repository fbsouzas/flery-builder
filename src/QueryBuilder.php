<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder;

use Fbsouzas\QueryBuilder\Conditions\ConditionChain;
use Illuminate\Database\Eloquent\Model;

class QueryBuilder
{
    private Model $model;

    public function to(string $model): self
    {
        $this->model = new $model;

        return $this;
    }

    public function apply(array $conditions)
    {
        $builder = ($this->model)->newQuery();

        $chain = new ConditionChain($builder, $conditions);
        $query = $chain->dispatch();

        return $query;
    }
}
