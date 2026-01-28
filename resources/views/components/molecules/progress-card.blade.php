@props([
    'title' => '',
    'progress' => 0,
    'icon' => '',
    'color' => 'lime',
    'url' => '#',
    'completeText' => 'Lihat Data',
    'incompleteText' => 'Lengkapi Data',
])

@php
$colorClasses = [
    'lime' => [
        'gradient' => 'from-lime-500 to-green-500',
        'bg' => 'bg-lime-100',
        'text' => 'text-lime-600',
        'ring' => 'text-lime-500',
        'hover' => 'hover:border-lime-300 hover:shadow-lime-100',
        'button' => 'bg-lime-500 hover:bg-lime-600 text-white',
    ],
    'indigo' => [
        'gradient' => 'from-indigo-500 to-purple-500',
        'bg' => 'bg-indigo-100',
        'text' => 'text-indigo-600',
        'ring' => 'text-indigo-500',
        'hover' => 'hover:border-indigo-300 hover:shadow-indigo-100',
        'button' => 'bg-indigo-500 hover:bg-indigo-600 text-white',
    ],
    'green' => [
        'gradient' => 'from-green-500 to-emerald-500',
        'bg' => 'bg-green-100',
        'text' => 'text-green-600',
        'ring' => 'text-green-500',
        'hover' => 'hover:border-green-300 hover:shadow-green-100',
        'button' => 'bg-green-500 hover:bg-green-600 text-white',
    ],
    'blue' => [
        'gradient' => 'from-blue-500 to-cyan-500',
        'bg' => 'bg-blue-100',
        'text' => 'text-blue-600',
        'ring' => 'text-blue-500',
        'hover' => 'hover:border-blue-300 hover:shadow-blue-100',
        'button' => 'bg-blue-500 hover:bg-blue-600 text-white',
    ],
    'purple' => [
        'gradient' => 'from-purple-500 to-pink-500',
        'bg' => 'bg-purple-100',
        'text' => 'text-purple-600',
        'ring' => 'text-purple-500',
        'hover' => 'hover:border-purple-300 hover:shadow-purple-100',
        'button' => 'bg-purple-500 hover:bg-purple-600 text-white',
    ],
];

$c = $colorClasses[$color] ?? $colorClasses['lime'];
$isComplete = $progress >= 100;
@endphp

<div class="relative overflow-hidden bg-white border border-gray-200 rounded-2xl p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl {{ $c['hover'] }} group">
    {{-- Decorative gradient orb --}}
    <div class="absolute -top-8 -right-8 w-24 h-24 bg-gradient-to-br {{ $c['gradient'] }} rounded-full opacity-10 group-hover:opacity-20 transition-opacity"></div>
    
    <div class="relative z-10">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $c['bg'] }} rounded-xl flex items-center justify-center">
                    <i class="{{ $icon }} {{ $c['text'] }} text-lg"></i>
                </div>
                <h3 class="text-sm font-semibold text-gray-800">{{ $title }}</h3>
            </div>
            
            {{-- Mini progress ring --}}
            <div class="relative w-12 h-12">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <path class="{{ $c['ring'] }} transition-all duration-1000" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none" stroke-dasharray="{{ min($progress, 100) }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    @if($isComplete)
                        <i class="ri-check-line {{ $c['text'] }} text-sm"></i>
                    @else
                        <span class="text-xs font-bold text-gray-700">{{ number_format($progress, 0) }}%</span>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Progress bar --}}
        <div class="mb-4">
            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                <div class="bg-gradient-to-r {{ $c['gradient'] }} h-2 rounded-full transition-all duration-700" 
                     style="width: {{ min($progress, 100) }}%"></div>
            </div>
        </div>
        
        {{-- Action button --}}
        <a href="{{ $url }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-xs font-medium {{ $isComplete ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : $c['button'] }} rounded-lg transition-all duration-200">
            @if($isComplete)
                <i class="ri-eye-line"></i>
            @else
                <i class="ri-edit-line"></i>
            @endif
            {{ $isComplete ? $completeText : $incompleteText }}
            <i class="ri-arrow-right-s-line"></i>
        </a>
    </div>
</div>