<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests\Unit\Clauses;

use Fbsouzas\QueryBuilder\Clauses\ClauseChain;
use Fbsouzas\QueryBuilder\Tests\TestCase;
use Fbsouzas\QueryBuilder\Tests\TestClasses\Models\Test;
use Illuminate\Database\Eloquent\Builder;

class ClauseChainTest extends TestCase
{
    /** @test */
    public function itMustReturnAnInstanceOfTheEloquentBuilderClass(): void
    {
        $buider = (new Test())->newQuery();
        $clauseChain = new ClauseChain($buider, []);

        self::assertInstanceOf(Builder::class, $clauseChain->dispatch());
    }
}
