<?php

declare(strict_types=1);

namespace Fbsouzas\FleryBuilder\Tests\Unit\Clauses;

use Fbsouzas\FleryBuilder\Clauses\ClauseChain;
use Fbsouzas\FleryBuilder\Tests\TestCase;
use Fbsouzas\FleryBuilder\Tests\TestClasses\Models\Test;
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
