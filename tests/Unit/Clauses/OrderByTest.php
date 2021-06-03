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
     * @dataProvider sortQueryStrings
     */
    public function itMustBeIncludeTheOrderClauseInTheQuery(string $sortQueryStrings): void
    {
        $order = new OrderBy($this->clauseMock);

        $query = $order->apply($this->builder, [
            'sort' => $sortQueryStrings,
        ]);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($this->mountAssertString($sortQueryStrings), $query->toSql());
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

    private function mountAssertString(string $sortQueryStrings): string
    {
        $mountedAssert = 'order by';
        $sortQueryStrings = explode(',', $sortQueryStrings);
        $sortQueryStringsLength = count($sortQueryStrings);

        foreach ($sortQueryStrings as $key => $sortQueryString) {
            $order = $this->order($sortQueryString);
            $column = str_replace('-', '', $sortQueryString);

            $mountedAssert .= " \"{$column}\" {$order}";

            if ($key !== $sortQueryStringsLength - 1) {
                $mountedAssert .= ',';
            }
        }

        return $mountedAssert;
    }

    private function order(string $sortQueryString): string
    {
        $order = 'asc';

        if ('-' === substr($sortQueryString, 0, 1)) {
            $order = 'desc';
        }

        return $order;
    }

    public function sortQueryStrings(): array
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
