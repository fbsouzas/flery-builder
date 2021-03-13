<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests\Unit;

use Fbsouzas\QueryBuilder\QueryBuilder;
use Fbsouzas\QueryBuilder\Tests\TestCase;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilderTest extends TestCase
{
    /** @test */
    public function itMustReturnAnInstanceOfTheClass(): void
    {
        $query = QueryBuilder::to(Test::class);

        self::assertInstanceOf(QueryBuilder::class, $query);
    }

    /** @test */
    public function itMustReturnAnInstanceOfTheEloquentBuilderClass(): void
    {
        $query = QueryBuilder::to(Test::class)
            ->apply([]);

        self::assertInstanceOf(Builder::class, $query);
    }
}
