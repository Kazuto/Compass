<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockActionThrows(string $class, string $method = 'execute', \Throwable $exception = null): MockInterface
    {
        return $this->partialMock($class, function (MockInterface $mock) use ($method, $exception) {
            $mock->shouldReceive($method)->once()
                ->andThrows($exception ?? Exception::class, 'Fun exception');
        });
    }
}
