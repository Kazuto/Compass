@php
    use Illuminate\Support\Arr;
@endphp

<div class="mb-4 text-[var(--color-text)]">
    <label id="label-{{ $id }}" for="{{ $id }}" class="block mb-2" aria-label="{{ $label }}">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}" aria-labelledby="label-{{ $name }}"
            class="w-full rounded-lg bg-[var(--color-background)] border border-white/20 text-white py-2 px-3">
        @foreach($options as $option)
            <option
                value="{{ Arr::get($option, $optionValue) }}"
                @selected(Arr::get($option, $optionValue) === $selection)
            >
                {{ Arr::get($option, $optionLabel) }}
            </option>
        @endforeach
    </select>
</div>
