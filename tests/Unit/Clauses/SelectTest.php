<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests\Unit\Clauses;

use Fbsouzas\QueryBuilder\Clauses\Select;
use Fbsouzas\QueryBuilder\Tests\TestCase;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class SelectTest extends TestCase
{
    private Select $select;
    private Builder $qb;

    public function setUp(): void
    {
        parent::setUp();

        $this->select = new Select();
        $this->qb = (new Test())->newQuery();
    }

    public function selectFields(): array
    {
        return [
            ['first_name'],
            ['first_name,age'],
            ['first_name,age,last_name'],
        ];
    }

    /**
     * @test
     * @dataProvider selectFields
     */
    public function itMustBeIncludeTheFieldsInTheQuerySelect(string $selectFields): void
    {
        $query = $this->select->apply($this->qb, [
            'select' => $selectFields,
        ]);

        $selectAssertPrepared = $this->prepareSelectAssert($selectFields);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($selectAssertPrepared, $query->toSql());
    }

    /** @test */
    public function itMustBeReturnAWildcardInTheQuerySelect(): void
    {
        $query = $this->select->apply($this->qb, []);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString('select *', $query->toSql());
    }

    private function prepareSelectAssert(string $selectFields): string
    {
        return 'select "' . implode('", "', explode(',', $selectFields));
    }
}
