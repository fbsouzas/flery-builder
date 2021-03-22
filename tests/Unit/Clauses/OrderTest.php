<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Tests\Unit\Clauses;

use Fbsouzas\FleryBuilder\Clauses\Clause;
use Fbsouzas\FleryBuilder\Clauses\Order;
use Fbsouzas\FleryBuilder\Tests\TestCase;
use Fbsouzas\FleryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class OrderTest extends TestCase
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
    public function itMustBeIncludeTheOrderClauseInTheQuery(array $orderClause): void
    {
        $order = new Order($this->clauseMock);

        $query = $order->apply($this->builder, [
            'order' => $orderClause,
        ]);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($this->mountAssertString($orderClause), $query->toSql());
    }

    /** @test */
    public function itMustHaveNotOrderClauseInTheQuery(): void
    {
        $order = new Order($this->clauseMock);

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

    private function mountAssertString(array $orderClause): string
    {
        $mountedAssert = 'order by';
        $orderClauseLastKey = array_key_last($orderClause);

        foreach ($orderClause as $order => $column) {
            $mountedAssert = $this->addOrderClauseInTheAssertString(
                $mountedAssert,
                $order,
                $column,
                $orderClauseLastKey
            );
        }

        return $mountedAssert;
    }

    private function addOrderClauseInTheAssertString(
        string $mountedAssert,
        string $order,
        string $column,
        string $orderClauseLastKey
    ): string {
        $mountedAssert .= " \"{$column}\" {$order}";

        if ($this->isNotTheLastOrderClause($order, $orderClauseLastKey)) {
            $mountedAssert .= ',';
        }

        return $mountedAssert;
    }

    private function isNotTheLastOrderClause(string $order, string $orderClauseLastKey): bool
    {
        return $orderClauseLastKey !== $order;
    }

    public function provideOrderClauses(): array
    {
        return [
            [
                [
                    'asc' => 'test',
                ],
            ],
            [
                [
                    'desc' => 'test',
                ],
            ],
            [
                [
                    'asc' => 'test',
                    'desc' => 'test',
                ],
            ],
        ];
    }
}
