@props(['label' => false, 'name', 'type' => 'text'])

<div class="space-y-2">
    @if ($label)
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    @endif

    @if ($type === 'textarea')
    <textarea name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'textarea']) }}>{{ old($name, '') }}</textarea>
    @else
    <input type="{{ $type }}" class="input" id="{{ $name }}" name="{{ $name }}"
        value="{{ $type !== 'password' ? old($name, '') : '' }}" {{ $attributes }}>
    @endif

    <x-form.error name="{{ $name }}" />
</div>