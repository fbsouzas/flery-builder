<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests\Unit\Clauses;

use Fbsouzas\QueryBuilder\Clauses\Clause;
use Fbsouzas\QueryBuilder\Clauses\Order;
use Fbsouzas\QueryBuilder\Tests\TestCase;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Models\Test;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Mocks\ClauseMock;
use Illuminate\Database\Eloquent\Builder;

class OrderTest extends TestCase
{
    /**
     * @test
     * @dataProvider orderClauses
     */
    public function itMustBeIncludeTheOrderClauseInTheQuery(array $orderClause): void
    {
        $qb = (new Test())->newQuery();
        $mock = $this->getMockBuilder(Clause::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $mock->method('apply')
            ->willReturn($qb);

        /** @var Clause $mock */
        $order = new Order($mock);

        $query = $order->apply($qb, ['order' => $orderClause]);
        $orderAssertPrepared = $this->prepareOrderAssert($orderClause);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($orderAssertPrepared, $query->toSql());
    }

    private function prepareOrderAssert(array $orderClause): string
    {
        $orderAssert = 'order by';
        $orderClauseLastKey = array_key_last($orderClause);

        foreach ($orderClause as $order => $column) {
            $orderAssert .= " \"{$column}\" {$order}";

            if ($orderClauseLastKey !== $order) {
                $orderAssert .= ',';
            }
        }

        return $orderAssert;
    }

    public function orderClauses(): array
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
