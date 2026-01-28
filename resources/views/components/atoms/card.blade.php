@props([
    'className' => '',
    'padding' => 'p-5',
    'border' => true,
])

@php
$baseClasses = "bg-white rounded-3xl shadow-lg overflow-hidden";
$borderClass = $border ? "border border-gray-100" : "";
$classes = trim(implode(' ', [$baseClasses, $padding, $borderClass, $className]));
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>