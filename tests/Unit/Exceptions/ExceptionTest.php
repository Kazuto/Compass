<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use App\Exceptions\Exception;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has method forward', function () {
    // Given
    $exception = new Exception();

    // Then
    assertTrue(method_exists($exception, 'forward'));
});

it('has wraps exception with forward', function () {
    // Given
    $toWrap = DatabaseDoesNotExist::noColumnsSpecifiedForTable('lorem');
    $exception = Exception::forward($toWrap);

    // Then
    assertInstanceOf(Exception::class, $exception);
    assertEquals('No columns specified for table lorem', $exception->getMessage());
});
