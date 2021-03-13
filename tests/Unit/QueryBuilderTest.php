<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests\Unit;

use Fbsouzas\QueryBuilder\QueryBuilder;
use Fbsouzas\QueryBuilder\Tests\TestCase;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilderTest extends TestCase
{
    private QueryBuilder $qb;

    public function setUp(): void
    {
        parent::setUp();

        $this->qb = new QueryBuilder();
    }

    /** @test */
    public function itMustReturnAnInstanceOfTheClass(): void
    {
        $query = $this->qb->to(Test::class);

        self::assertSame($this->qb, $query);
    }

    /** @test */
    public function itMustReturnAnInstanceOfTheEloquentBuilderClass(): void
    {
        $query = $this->qb
            ->to(Test::class)
            ->apply([]);

        self::assertInstanceOf(Builder::class, $query);
    }
}
