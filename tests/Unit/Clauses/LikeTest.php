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
    private builder $builder;
    private object $clauseMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = (new Test())->newQuery();
        $this->clauseMock = $this->clauseMock($this->builder);
    }

    /**
     * @test
     * @dataProvider provideLikeClauses
     */
    public function itMustBeIncludeTheLikeClauseInTheQuery(array $likeClause): void
    {
        $like = new Like($this->clauseMock);

        $query = $like->apply($this->builder, [
            'like' => $likeClause,
        ]);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($this->mountAssertString($likeClause), $query->toSql());
    }

    /** @test */
    public function itMustHaveNotLikeClauseInTheQuery(): void
    {
        $like = new Like($this->clauseMock);

        $query = $like->apply($this->builder, []);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringNotContainsString('like', $query->toSql());
    }

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

    private function mountAssertString(array $likeClause): string
    {
        $mountedAssert = 'where ';
        $likeClauseLastKey = array_key_last($likeClause);

        foreach ($likeClause as $column => $value) {
            $mountedAssert = $this->addLikeClauseInTheAssertString($mountedAssert, $column, $likeClauseLastKey);
        }

        return $mountedAssert;
    }

    private function addLikeClauseInTheAssertString(string $mountedAssert, string $column, string $likeClauseLastKey): string
    {
        $mountedAssert .= "\"{$column}\" like ?";

        if ($this->isNotTheLastLikeClause($column, $likeClauseLastKey)) {
            $mountedAssert .= ' and ';
        }

        return $mountedAssert;
    }

    private function isNotTheLastLikeClause(string $column, string $likeClauseLastKey): bool
    {
        return $column !== $likeClauseLastKey;
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
