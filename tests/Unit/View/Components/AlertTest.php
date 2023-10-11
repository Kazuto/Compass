<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components\Auth;

use Illuminate\Testing\TestView;

it('shows text with correct styling', function ($type, $text, $class) {
    // When
    /** @var TestView $view */
    $view = $this->blade(
        '<x-alert :type="$type">{{ $text }}</x-alert>',
        ['type' => $type, 'text' => $text]
    );

    // Then
    $view->assertSee($text)
        ->assertSee($class);
})->with([
    ['type' => 'success', 'text' => 'Everything okay :)', 'class' => 'bg-green-600'],
    ['type' => 'info', 'text' => 'Just letting you know :)', 'class' => 'bg-blue-600'],
    ['type' => 'error', 'text' => 'Something went wrong :(', 'class' => 'bg-red-600'],
]);
