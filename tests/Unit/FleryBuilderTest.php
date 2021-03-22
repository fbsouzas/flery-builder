<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Tests\Unit;

use Fbsouzas\FleryBuilder\FleryBuilder;
use Fbsouzas\FleryBuilder\Tests\TestCase;
use Fbsouzas\FleryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class FleryBuilderTest extends TestCase
{
    /** @test */
    public function itMustReturnAnInstanceOfTheClass(): void
    {
        $query = FleryBuilder::to(Test::class);

        self::assertInstanceOf(FleryBuilder::class, $query);
    }

    /** @test */
    public function itMustReturnAnInstanceOfTheEloquentBuilderClass(): void
    {
        $query = FleryBuilder::to(Test::class)
            ->apply([]);

        self::assertInstanceOf(Builder::class, $query);
    }
}
