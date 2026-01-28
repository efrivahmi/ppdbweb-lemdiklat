@props([
    'trigger' => '',
    'triggerClass' => 'py-1 px-1 text-gray-600 hover:text-lime-600 hover:bg-lime-100 rounded-lg',
    'position' => 'right',
    'width' => 'w-48',
    'maxHeight' => '',
    'showArrow' => false,
    'closeOnClick' => true,
    'className' => '',
])

@php
$positionClasses = [
    'left' => 'left-0',
    'right' => 'right-0',
    'center' => 'left-1/2 transform -translate-x-1/2',
];

$positionClass = $positionClasses[$position] ?? $positionClasses['right'];
$maxHeightClass = $maxHeight ? $maxHeight : '';
@endphp

<div class="relative" x-data="{ open: false }" {{ $attributes }}>
    <button 
        @click="open = !open"
        class="{{ $triggerClass }}"
        :aria-expanded="open"
        aria-haspopup="true"
    >
        {!! $trigger !!}
        @if($showArrow)
            <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200" 
                x-bind:class="{ 'rotate-180': open }" />
        @endif
    </button>

    <div 
        x-show="open" 
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute {{ $positionClass }} mt-2 {{ $width }} bg-white rounded-lg shadow-lg border border-gray-200 z-50 {{ $maxHeightClass }} {{ $className }}"
        style="display: none;"
        @if($closeOnClick)
            @click="open = false"
        @endif
    >
        {{ $slot }}
    </div>
</div>