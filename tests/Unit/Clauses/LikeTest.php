<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests\Unit\Clauses;

use Fbsouzas\QueryBuilder\Clauses\Clause;
use Fbsouzas\QueryBuilder\Clauses\Like;
use Fbsouzas\QueryBuilder\Tests\TestCase;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class LikeTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideLikeClauses
     */
    public function itMustBeIncludeTheLikeClauseInTheQuery(array $likeClause): void
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
        $like = new Like($mock);

        $query = $like->apply($qb, [
            'like' => $likeClause,
        ]);
        $preparedAssert = $this->prepareLikeAssert($likeClause);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($preparedAssert, $query->toSql());
    }

    private function prepareLikeAssert(array $likeClause): string
    {
        $preparedAssert = 'where ';
        $likeClauseLastKey = array_key_last($likeClause);

        foreach ($likeClause as $column => $value) {
            $preparedAssert .= "\"{$column}\" like ?";

            if ($column !== $likeClauseLastKey) {
                $preparedAssert .= ' and ';
            }
        }

        return $preparedAssert;
    }

    public function provideLikeClauses(): array
    {
        return [
            [
                [
                    'test' => 'test',
                ],
            ],
            [
                [
                    'test' => 'test',
                    'test1' => 'test1',
                ],
            ],
            [
                [
                    'test' => 'test',
                    'test1' => 'test1',
                    'test2' => 'test2',
                ],
            ],
        ];
    }
}
