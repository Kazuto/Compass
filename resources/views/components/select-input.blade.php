@php
    use Illuminate\Support\Arr;
@endphp

<div class="mb-4">
    <label id="label-{{ $id }}" for="{{ $id }}" class="block mb-2" aria-label="{{ $label }}">{{ $label }}</label>
        <select id="{{ $id }}" name="{{ $name }}" aria-labelledby="label-{{ $name }}"
                class="w-full rounded-lg border border-gray-300 dark:border-black/[.15] bg-base-dark/[.025] dark:bg-black/[.075] dark:ring-1 dark:ring-inset dark:ring-black/5 dark:ring-base-light/[.075] text-base-dark dark:text-base-light py-2 px-3 transition-all duration-250 focus:outline focus:outline-2 focus:outline-accent-medium">
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
