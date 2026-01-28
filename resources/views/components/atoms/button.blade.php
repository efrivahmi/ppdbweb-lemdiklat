{{-- resources/views/components/atoms/button.blade.php --}}
@props([
    'type' => 'button',
    'disabled' => false,
    'isLoading' => false,
    'loadingText' => 'Loading...',
    'heroicon' => '',
    'iconPosition' => 'left',
    'variant' => 'primary',
    'theme' => 'light',
    'size' => 'md',
    'rounded' => 'md',
    'shadow' => '',
    'className' => '',
    'isFullWidth' => false,
])

@php
$baseClasses = "font-semibold transition-all flex items-center justify-center focus:outline-none relative overflow-hidden select-none";

$sizeClasses = [
    'sm' => 'px-4 py-2 text-sm min-h-[36px] gap-1.5',
    'md' => 'px-4 py-2.5 text-base min-h-[44px] gap-2',
    'lg' => 'px-6 py-3 text-lg min-h-[52px] gap-2.5',
];

$iconSizes = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
];

$roundedClasses = [
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    'full' => 'rounded-full',
];

$shadowClasses = [
    'none' => '',
    'sm' => 'shadow-sm hover:shadow-md',
    'md' => 'shadow-md hover:shadow-lg',
    'lg' => 'shadow-lg hover:shadow-xl',
];

$variants = [
    'light' => [
        'primary' => 'bg-sky-500 hover:bg-sky-600 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-600 text-white',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-white',
        'success' => 'bg-lime-500 hover:bg-lime-600 text-white',
        'outline' => 'border-2 border-white text-white bg-transparent hover:bg-white hover:text-black',
        'ghost' => 'bg-transparent text-white',
    ],
    'dark' => [
        'primary' => 'bg-sky-600 hover:bg-sky-700 text-white',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'warning' => 'bg-yellow-600 hover:bg-yellow-700 text-white',
        'success' => 'bg-lime-600 hover:bg-lime-700 text-white',
        'outline' => 'border-2 border-black text-black bg-transparent hover:bg-black hover:text-white',
        'ghost' => 'border-2 border-lime-600 text-lime-600 bg-transparent hover:bg-lime-600 hover:text-white',
    ],
];

$variantClasses = $variants[$theme][$variant] ?? $variants['light']['primary'];
$disabledClasses = ($disabled || $isLoading) ? 'opacity-50 cursor-not-allowed' : '';

$finalClasses = trim(implode(' ', [
    $baseClasses,
    $sizeClasses[$size] ?? $sizeClasses['md'],
    $roundedClasses[$rounded] ?? $roundedClasses['md'],
    $shadowClasses[$shadow] ?? '',
    $variantClasses,
    $disabledClasses,
    $isFullWidth ? 'w-full' : '',
    $className
]));

$iconSizeClass = $iconSizes[$size] ?? $iconSizes['md'];
$iconComponent = $heroicon ? 'heroicon-o-' . $heroicon : '';
@endphp

<button
    type="{{ $type }}"
    @if($disabled || $isLoading) disabled @endif
    {{ $attributes->merge(['class' => $finalClasses]) }}
>
    @if($isLoading)
        <div class="flex items-center justify-center gap-2">
            <div class="animate-spin rounded-full border-2 border-t-transparent border-current w-4 h-4"></div>
            @if($loadingText)
                <span>{{ $loadingText }}</span>
            @endif
        </div>
    @else
        @if($iconPosition === 'right')
            @if($slot->isNotEmpty())
                <span>{{ $slot }}</span>
            @endif
            @if($heroicon)
                <x-dynamic-component 
                    :component="$iconComponent" 
                    class="{{ $iconSizeClass }}" 
                />
            @endif
        @else
            @if($heroicon)
                <x-dynamic-component 
                    :component="$iconComponent" 
                    class="{{ $iconSizeClass }}" 
                />
            @endif
            @if($slot->isNotEmpty())
                <span>{{ $slot }}</span>
            @endif
        @endif
    @endif
</button>