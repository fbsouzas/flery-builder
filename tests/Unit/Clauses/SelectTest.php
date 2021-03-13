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
    private Builder $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->select = new Select();
        $this->builder = (new Test())->newQuery();
    }

    /**
     * @test
     * @dataProvider provideSelectFields
     */
    public function itMustBeIncludeTheFieldsInTheQuerySelect(string $selectFields): void
    {
        $query = $this->select->apply($this->builder, [
            'select' => $selectFields,
        ]);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($this->mountAssertString($selectFields), $query->toSql());
    }

    /** @test */
    public function itMustBeReturnAWildcardInTheQuerySelect(): void
    {
        $query = $this->select->apply($this->builder, []);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString('select *', $query->toSql());
    }

    private function mountAssertString(string $selectFields): string
    {
        return 'select "' . implode('", "', explode(',', $selectFields));
    }

    public function provideSelectFields(): array
    {
        return [
            [
                'first_name',
            ],
            [
                'first_name,age',
            ],
            [
                'first_name,age,last_name',
            ],
        ];
    }
}
