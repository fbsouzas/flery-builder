<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder;

use Fbsouzas\FleryBuilder\Clauses\ClauseChain;
use Illuminate\Database\Eloquent\Builder;

class FleryBuilder
{
    private string $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public static function to(string $model): self
    {
        return new FleryBuilder($model);
    }

    public function apply(array $clauses): Builder
    {
        $query = (new $this->model())->newQuery();
        $chain = new ClauseChain($query, $clauses);

        return $chain->dispatch();
    }
}
