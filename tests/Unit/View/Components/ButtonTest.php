<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components\Auth;

use Illuminate\Testing\TestView;

it('shows text with correct styling', function ($text, $danger, $class) {
    // When
    /** @var TestView $view */
    $view = $this->blade(
        '<x-button :danger="$danger">{{ $text }}</x-button>',
        ['text' => $text, 'danger' => $danger]
    );

    // Then
    $view->assertSee($text)
        ->assertSee($class);
})->with([
    ['text' => 'Submit', 'danger' => false, 'class' => ''],
    ['text' => 'Delete', 'danger' => true, 'class' => 'bg-red-600'],
]);
