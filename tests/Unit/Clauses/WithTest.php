<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Tests\Unit\Clauses;

use Fbsouzas\FleryBuilder\Clauses\Clause;
use Fbsouzas\FleryBuilder\Clauses\With;
use Fbsouzas\FleryBuilder\Tests\TestCase;
use Fbsouzas\FleryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class WithTest extends TestCase
{
    private Builder $builder;

    /** @var Clause $clauseMock */
    private object $clauseMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = (new Test())->newQuery();
        $this->clauseMock = $this->clauseMock($this->builder);
    }

    /** @test */
    public function itMustBeIncludeTheWithClauseInTheQuery(): void
    {
        $with = new With($this->clauseMock);

        $query = $with->apply($this->builder, [
            'with' => 'test1'
        ]);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString('select *', $query->toSql());
    }

    /** @return Clause */
    private function clauseMock(Builder $builder): object
    {
        $mock = $this->getMockBuilder(Clause::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $mock->method('apply')
            ->willReturn($builder);

        return $mock;
    }
}
