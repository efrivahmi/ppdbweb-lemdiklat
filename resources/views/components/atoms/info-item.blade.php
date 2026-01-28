@props([
    'icon' => '',
    'text' => '',
    'className' => '',
])

@php
$classes = trim("flex items-center gap-3 bg-lime-50 rounded-xl px-4 py-3 " . $className);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="{{ $icon }} w-5 h-5 text-lime-600"></i>
    @else
        {{ $iconSlot ?? '' }}
    @endif
    <span class="text-gray-700 font-medium">{{ $text ?: $slot }}</span>
</div>