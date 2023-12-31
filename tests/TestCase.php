<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Mockery\MockInterface;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function invokeMethod($object, string $methodName, array $args = []): mixed
    {
        $class = new ReflectionClass(get_class($object));
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $args);
    }

    public function mockActionThrows(string $class, string $method = 'execute'): MockInterface
    {
        return $this->partialMock($class, function (MockInterface $mock) use ($method) {
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive($method)
                ->once()
                ->andThrows(Exception::class, 'Fun exception');
        });
    }

    public function mockActionReturns(string $class, mixed $return, string $method = 'execute'): MockInterface
    {
        return $this->partialMock($class, function (MockInterface $mock) use ($return, $method) {
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive($method)
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

    public function getStylesheetPath(): string
    {
        $manifest = json_decode(File::get(public_path('/build/manifest.json')), true);
        $filePath = Arr::get($manifest, 'resources/css/app.css')['file'];

        return public_path(
            str('build/')
                ->append($filePath)
                ->toString()
        );
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
