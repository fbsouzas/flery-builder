<?php

declare(strict_types=1);

namespace Fbsouzas\QueryBuilder\Tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use Illuminate\Database\Capsule\Manager;

class TestCase extends PhpUnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $config = [
            'testing' => [
                'driver' => $_ENV['DB_DRIVER'],
                'database' => $_ENV['DB_DATABASE'],
                'prefix' => '',
            ],
        ];

        $db = new Manager();

        $db->addConnection($config[$_ENV['APP_ENV']]);
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}
