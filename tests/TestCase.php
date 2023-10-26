<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
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

    public function mockSocialiteUser(string $name = null, string $nickName = null, string $email = null): void
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User')->makePartial();

        $abstractUser
            ->shouldReceive('getId')
            ->andReturn(rand())
            ->shouldReceive('getName')
            ->andReturn($name ?? Str::random(10))
            ->shouldReceive('getNickname')
            ->andReturn($nickName)
            ->shouldReceive('getEmail')
            ->andReturn($email ?? Str::random(10).'@gmail.com')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);
    }

    public function themeConfig(): array
    {
        return [
            'colors' => [
                'accent' => ['light' => '#FFFFFF', 'medium' => '#777777', 'dark' => '#000000'],
                'base' => ['light' => '#FFFFFF', 'medium' => '#777777', 'dark' => '#000000'],
            ],
        ];
    }
}
