<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Conditions;

use Illuminate\Database\Eloquent\Builder;

class Select implements Condition
{
    public function apply(Builder $query, array $conditions): Builder
    {
        $isSelect = array_key_exists('select', $conditions);

        if ($isSelect) {
            $query->select(explode(',', $conditions['select']));
        }

        return $query;
    }
}