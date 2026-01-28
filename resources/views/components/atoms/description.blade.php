@props([
    'size' => '',
    'mdSize' => '',
    'align' => '',
    'color' => 'zinc-600',
    'className' => '',
])

@php
$sizeStyles = [
    'xs' => 'text-xs',
    'sm' => 'text-sm',
    'md' => 'text-base',
    'lg' => 'text-lg',
    'xl' => 'text-xl',
];

$sizeClass = $sizeStyles[$size] ?? '';
$mdSizeClass = $mdSize && isset($sizeStyles[$mdSize]) ? 'md:' . $sizeStyles[$mdSize] : '';

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

$colorClass = 'text-' . $color;

$classes = trim(implode(' ', [
    '',
    $sizeClass,
    $mdSizeClass,
    $alignClass,
    $colorClass,
    $className
]));
@endphp

<p {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</p>