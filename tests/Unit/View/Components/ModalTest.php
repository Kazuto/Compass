<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components\Auth;

use Illuminate\Testing\TestView;

it('generates id from title if not passed', function ($title, $id) {
    // When
    /** @var TestView $view */
    $view = $this->blade(
        '<x-modal :title="$title">
            <x-slot name="button">Open Modal</x-slot>
        </x-modal>',
        ['title' => $title]
    );

    // Then
    $view->assertSee($id)
        ->assertSee($title);
})->with([
    ['title' => 'Delete record modal', 'id' => 'delete-record-modal'],
    ['title' => 'Edit record modal', 'id' => 'edit-record-modal'],
    ['title' => 'Create record modal', 'id' => 'create-record-modal'],
]);

it('displays button text from slot', function ($text) {
    // When
    /** @var TestView $view */
    $view = $this->blade(
        '<x-modal title="modal">
            <x-slot name="button">{{ $text }}</x-slot>
        </x-modal>',
        ['text' => $text]
    );

    // Then
    $view->assertSee($text);
})->with([
    'Open Modal', 'Delete record', 'Edit record', 'Create record',
]);
