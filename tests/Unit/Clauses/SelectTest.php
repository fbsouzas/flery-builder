<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Tests\Unit\Clauses;

use Fbsouzas\FleryBuilder\Clauses\Select;
use Fbsouzas\FleryBuilder\Tests\TestCase;
use Fbsouzas\FleryBuilder\Tests\TestClasses\Models\Test;
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
            'fields' => $selectFields,
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
