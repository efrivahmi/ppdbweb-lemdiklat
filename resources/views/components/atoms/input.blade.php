@props([
    'type' => 'text',
    'id' => null,
    'name' => null,
    'placeholder' => '',
    'className' => '',
])

@php
$baseClass = "w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out";
$classes = trim($baseClass . ' ' . $className);
@endphp

<input
    type="{{ $type }}"
    @if($id) id="{{ $id }}" @endif
    @if($name) name="{{ $name }}" @endif
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
/>