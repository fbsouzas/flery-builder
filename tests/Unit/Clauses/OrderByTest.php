<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Tests\Unit\Clauses;

use Fbsouzas\FleryBuilder\Clauses\Clause;
use Fbsouzas\FleryBuilder\Clauses\OrderBy;
use Fbsouzas\FleryBuilder\Tests\TestCase;
use Fbsouzas\FleryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class OrderByTest extends TestCase
{
    private Builder $builder;
    private object $clauseMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = (new Test())->newQuery();
        $this->clauseMock = $this->clauseMock($this->builder);
    }

    /**
     * @test
     * @dataProvider provideOrderClauses
     */
    public function itMustBeIncludeTheOrderClauseInTheQuery(string $orderClause): void
    {
        $order = new OrderBy($this->clauseMock);

        $query = $order->apply($this->builder, [
            'sort' => $orderClause,
        ]);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($this->mountAssertString($orderClause), $query->toSql());
    }

    /** @test */
    public function itMustHaveNotOrderClauseInTheQuery(): void
    {
        $order = new OrderBy($this->clauseMock);

        $query = $order->apply($this->builder, []);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringNotContainsString('order', $query->toSql());
    }

    private function clauseMock(Builder $qb): object
    {
        $mock = $this->getMockBuilder(Clause::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $mock->method('apply')
            ->willReturn($qb);

        return $mock;
    }

    private function mountAssertString(string $orderClause): string
    {
        $mountedAssert = 'order by';
        $orderClause = explode(',', $orderClause);
        $orderClauseLength = count($orderClause);

        foreach ($orderClause as $key => $clause) {
            $order = $this->order($clause);
            $attribute = str_replace('-', '', $clause);

            $mountedAssert .= " \"{$attribute}\" {$order}";

            if ($key !== $orderClauseLength - 1) {
                $mountedAssert .= ',';
            }
        }

        return $mountedAssert;
    }

    private function order(string $sortClause): string
    {
        $order = 'asc';

        if ('-' === substr($sortClause, 0, 1)) {
            $order = 'desc';
        }

        return $order;
    }

    public function provideOrderClauses(): array
    {
        return [
            [
                'test',
            ],
            [
                '-test',
            ],
            [
                'test,-test',
            ],
        ];
    }
}
