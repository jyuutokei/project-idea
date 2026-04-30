@props(['is' => 'a'])


@php

$allowedTags = ['a', 'div', 'section', 'article', 'button', 'span'];
$tag = in_array($is, $allowedTags, true) ? $is : 'a';

@endphp

<{{ $tag }} {{ $attributes(['class' => 'border border-border rounded-lg bg-card md:text-sm p-4']) }}>
    {{ $slot }}
</{{ $tag }}>