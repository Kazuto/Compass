<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockActionThrows(string $class): MockInterface
    {
        return $this->partialMock($class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andThrows(Exception::class, 'Fun exception');
        });
    }

    public function mockActionReturns(string $class, mixed $return): MockInterface
    {
        return $this->partialMock($class, function (MockInterface $mock) use ($return) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturns($return);
        });
    }
}
