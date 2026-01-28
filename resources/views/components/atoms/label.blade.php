@props([
    'for' => null,
    'className' => '',
])

@php
$baseClass = "block text-sm font-medium text-gray-800 mb-1";
$classes = trim($baseClass . ' ' . $className);
@endphp

<label 
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</label>