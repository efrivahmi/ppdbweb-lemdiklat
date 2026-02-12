@props([
    'icon' => '',
    'text' => '',
    'className' => '',
])

@php
$classes = trim("flex items-start gap-3 bg-lime-50 rounded-xl px-4 py-3 " . $className);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex-shrink-0 mt-0.5">
        @if($icon)
            <i class="{{ $icon }} w-5 h-5 md:w-6 md:h-6 text-lime-600"></i>
        @else
            {{ $iconSlot ?? '' }}
        @endif
    </div>
    <span class="text-gray-700 font-medium text-sm md:text-base leading-relaxed">{{ $text ?: $slot }}</span>
</div>