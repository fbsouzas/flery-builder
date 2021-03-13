<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests\Unit;

use Fbsouzas\QueryBuilder\QueryBuilder;
use Fbsouzas\QueryBuilder\Tests\TestCase;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilderTest extends TestCase
{
    private QueryBuilder $queryBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->queryBuilder = new QueryBuilder();
    }

    /** @test */
    public function itMustReturnAnInstanceOfTheClass(): void
    {
        $query = $this->queryBuilder->to(Test::class);

        self::assertSame($this->queryBuilder, $query);
    }

    /** @test */
    public function itMustReturnAnInstanceOfTheEloquentBuilderClass(): void
    {
        $query = $this->queryBuilder
            ->to(Test::class)
            ->apply([]);

        self::assertInstanceOf(Builder::class, $query);
    }
}
