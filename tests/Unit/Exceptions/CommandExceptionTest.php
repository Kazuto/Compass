<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use App\Exceptions\CommandException;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has method forward', function () {
    // Given
    $exception = new CommandException();

    // Then
    assertTrue(method_exists($exception, 'forward'));
});

it('has wraps exception with forward', function () {
    // Given
    $toWrap = DatabaseDoesNotExist::noColumnsSpecifiedForTable('lorem');
    $exception = CommandException::forward($toWrap);

    // Then
    assertInstanceOf(CommandException::class, $exception);
    assertEquals('No columns specified for table lorem', $exception->getMessage());
});

it('has return correct message when calling unsuccessful', function () {
    // Given
    $exception = CommandException::unsuccessful();

    // Then
    assertInstanceOf(CommandException::class, $exception);
    assertEquals('The command did not execute successfully.', $exception->getMessage());
});
