<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Conditions;

use Illuminate\Database\Eloquent\Builder;

class Like implements Condition
{
    private Condition $next;

    public function __construct(Condition $next)
    {
        $this->next = $next;
    }

    public function apply(Builder $query, array $conditions): Builder
    {
        $isLike = array_key_exists('like', $conditions);

        if ($isLike) {
            foreach ($conditions['like'] as $field => $value) {
                $query->where($field, 'like', '%' . $value . '%');
            }
        }

        return $this->next->apply($query, $conditions);
    }
}