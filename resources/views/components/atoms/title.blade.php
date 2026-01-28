@props([
    'text' => '',
    'highlight' => '',
    'size' => 'base',
    'mdSize' => '',
    'align' => 'left',
    'className' => '',
])

@php
$textSizes = [
    'xs' => 'text-xs',
    'sm' => 'text-sm',
    'base' => 'text-base',
    'md' => 'text-lg',
    'lg' => 'text-xl',
    'xl' => 'text-2xl',
    '2xl' => 'text-3xl',
    '3xl' => 'text-4xl',
    '4xl' => 'text-5xl',
    '5xl' => 'text-6xl',
    '6xl' => 'text-7xl',
];

$sizeClass = $textSizes[$size] ?? 'text-base';
$mdSizeClass = $mdSize && isset($textSizes[$mdSize]) ? 'md:' . $textSizes[$mdSize] : '';

$alignClass = '';
switch($align) {
    case 'left':
        $alignClass = 'text-left';
        break;
    case 'center':
        $alignClass = 'text-center';
        break;
    case 'right':
        $alignClass = 'text-right';
        break;
}

$classes = trim(implode(' ', [
    'font-bold text-gray-800',
    $sizeClass,
    $mdSizeClass,
    $alignClass,
    $className
]));

// Split text for highlighting
$parts = [];
if ($highlight && $text) {
    $parts = preg_split('/(' . preg_quote($highlight, '/') . ')/i', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
} else {
    $parts = [$text ?: $slot];
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($highlight && $text)
        @foreach($parts as $part)
            @if(strtolower($part) === strtolower($highlight))
                <span class="text-lime-500 dark:text-lime-400">{{ $part }}</span>
            @else
                <span>{{ $part }}</span>
            @endif
        @endforeach
    @else
        {{ $text ?: $slot }}
    @endif
</div>