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
     * @dataProvider fieldsQueryString
     */
    public function itMustBeIncludeTheFieldsInTheQuerySelect(string $fieldsQueryString): void
    {
        $query = $this->select->apply($this->builder, [
            'fields' => $fieldsQueryString,
        ]);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString($this->mountAssertString($fieldsQueryString), $query->toSql());
    }

    /** @test */
    public function itMustBeReturnAWildcardInTheQuerySelect(): void
    {
        $query = $this->select->apply($this->builder, []);

        self::assertInstanceOf(Builder::class, $query);
        self::assertStringContainsString('select *', $query->toSql());
    }

    private function mountAssertString(string $fieldsQueryString): string
    {
        return 'select "' . implode('", "', explode(',', $fieldsQueryString));
    }

    /** @return array<Array> */
    public function fieldsQueryString(): array
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
