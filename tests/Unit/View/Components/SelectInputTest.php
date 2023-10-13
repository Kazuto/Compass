<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components\Auth;

use App\View\Components\SelectInput;
use Illuminate\Testing\TestComponent;

it('generates label from name if not passed', function ($name, $label) {
    // When
    /** @var TestComponent $component */
    $component = $this->component(SelectInput::class,
        ['id' => $name, 'name' => $name, 'options' => collect([])]
    );

    // Then
    $component->assertSee($label)
        ->assertSee($name);
})->with([
    ['select-user', 'Select User'],
    ['record-to-delete', 'Record To Delete'],
]);

it('displays name of options', function () {
    // Given
    $options = collect([
        ['id' => 1, 'value' => 'Gail Garcia'],
        ['id' => 2, 'value' => 'Dina Curl'],
        ['id' => 3, 'value' => 'Cyrus Lee'],
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(SelectInput::class,
        ['id' => 'select-user', 'name' => 'select-user', 'options' => $options]
    );

    // Then
    $component->assertSeeInOrder($options->pluck('name')->toArray());
});

it('uses the value of option-label attribute as label for options', function () {
    // Given
    $options = collect([
        ['id' => 1, 'name' => 'Gail Garcia'],
        ['id' => 2, 'name' => 'Dina Curl'],
        ['id' => 3, 'name' => 'Cyrus Lee'],
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(SelectInput::class,
        ['id' => 'select-user', 'name' => 'select-user', 'options' => $options, 'optionLabel' => 'name']
    );

    // Then
    $component->assertSeeInOrder($options->pluck('name')->toArray());
});

it('uses the value of option-value attribute as value for options', function () {
    // Given
    $options = collect([
        ['key' => 1, 'value' => 'Gail Garcia'],
        ['key' => 2, 'value' => 'Dina Curl'],
        ['key' => 3, 'value' => 'Cyrus Lee'],
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(SelectInput::class,
        ['id' => 'select-user', 'name' => 'select-user', 'options' => $options, 'optionValue' => 'key']
    );

    // Then
    $component->assertSeeInOrder($options->pluck('key')->toArray());
});

it('selects options if selected attribute present', function () {
    // Given
    $options = collect([
        ['id' => 1, 'value' => 'Gail Garcia'],
        ['id' => 2, 'value' => 'Dina Curl'],
        ['id' => 3, 'value' => 'Cyrus Lee'],
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(SelectInput::class,
        ['id' => 'select-user', 'name' => 'select-user', 'options' => $options, 'selection' => 2]
    );

    // Then
    $component->assertSeeInOrder([
        'value="1"',
        'value="2"',
        'selected',
        'value="3"',
    ], false);
});
