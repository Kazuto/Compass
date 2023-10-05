<div {{ $attributes->merge(['class' => 'mb-4 text-[var(--color-text)]']) }}>
    <label id="label-{{ $id }}" for="{{ $id }}" class="block mb-2" aria-label="{{ $label }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" aria-labelledby="label-{{ $name }}" class="w-full rounded-lg bg-[var(--color-background)] border border-white/20 text-white py-2 px-3" value="{{ $value }}" />
</div>