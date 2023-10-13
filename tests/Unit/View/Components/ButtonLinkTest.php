<?php

namespace Tests\Unit\View\Components\Auth;

use Illuminate\Testing\TestView;

it('shows text with correct styling', function ($text, $type, $class) {
    // When
    /** @var TestView $view */
    $view = $this->blade(
        '<x-button-link href="#" :type="$type">{{ $text }}</x-button-link>',
        ['text' => $text, 'type' => $type]
    );

    // Then
    $view->assertSee($text)
        ->assertSee($class);
})->with([
    ['text' => 'Submit', 'type' => 'default', 'class' => ''],
    ['text' => 'Confirm', 'type' => 'warning', 'class' => 'bg-yellow-600'],
    ['text' => 'Delete', 'type' => 'danger', 'class' => 'bg-red-600'],
]);
