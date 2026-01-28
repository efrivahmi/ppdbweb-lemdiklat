@props([
    'item' => [],
    'level' => 0,
    'currentPath' => '',
    'expandedItems' => [],
    'className' => '',
])

@php
// Use exact route name comparison instead of URL comparison to avoid double active states
$isActiveLink = function($routeName) use ($currentPath) {
    return $currentPath === $routeName;
};

// Check if any child is active (for parent highlighting)
$isActiveParent = function($children) use ($currentPath) {
    if (!isset($children) || !is_array($children)) return false;
    foreach ($children as $child) {
        if (isset($child['route_name']) && $currentPath === $child['route_name']) {
            return true;
        }
    }
    return false;
};

$hasChildren = isset($item['children']) && count($item['children']) > 0;
$isActive = isset($item['route_name']) ? $isActiveLink($item['route_name']) : false;
$isParentActive = $hasChildren ? $isActiveParent($item['children']) : false;
$paddingClass = $level === 0 ? 'pl-4' : 'pl-8';
$itemKey = $item['key'] ?? ($item['name'] ?? '');
$isExpanded = in_array($itemKey, $expandedItems);

$baseClasses = "flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group relative";

// Filament-like Active State: Substance over decoration
// Active: Subtle background, colored text, no border
// Inactive: Gray text, hover background
$activeClasses = $isActive 
    ? 'bg-lime-500/10 text-lime-600' 
    : ($isParentActive ? 'bg-gray-50 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900');

$iconClasses = $isActive ? 'text-lime-600' : ($isParentActive ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500');
@endphp

@if(isset($item['type']) && $item['type'] === 'folder')
    <div 
        class="space-y-1 {{ $className }}"
        x-data="{ isExpanded: @js($isExpanded) }"
    >
        <button
            x-on:click="isExpanded = !isExpanded; $wire.dispatch('toggle-expanded', { key: '{{ $itemKey }}' })"
            class="w-full justify-between {{ $baseClasses }} {{ $paddingClass }} {{ $activeClasses }}"
            type="button"
            aria-expanded="false"
            x-bind:aria-expanded="isExpanded"
        >
            <div class="flex items-center gap-3 min-w-0 flex-1">
                @if(isset($item['icon']))
                    <div class="flex-shrink-0">
                        <i class="{{ $item['icon'] }} w-5 h-5 {{ $iconClasses }} transition-colors duration-200"></i>
                    </div>
                @endif
                <span class="font-medium truncate">{{ $item['name'] ?? '' }}</span>
            </div>
            
            <div class="flex-shrink-0 ml-2">
                <x-heroicon-o-chevron-right class="w-4 h-4 transition-transform duration-200 {{ $iconClasses }}" 
                   x-bind:class="{ 'rotate-90': isExpanded }"/>
            </div>
        </button>
        
        <div 
            x-show="isExpanded" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="space-y-1 pl-4"
        >
            @if($hasChildren)
                @foreach($item['children'] as $child)
                    <div class="relative">
                        <div class="absolute left-2 top-0 bottom-0 w-px bg-gray-200"></div>
                        <div class="absolute left-2 top-4 w-3 h-px bg-gray-200"></div>
                        <x-molecules.sidebar-link
                            :item="array_merge($child, ['key' => $itemKey . '-' . ($child['name'] ?? ''), 'type' => 'link'])"
                            :level="$level + 1"
                            :currentPath="$currentPath"
                            :expandedItems="$expandedItems"
                            class="ml-4"
                        />
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@else
    <a
        href="{{ $item['url'] ?? '#' }}"
        wire:click="$dispatch('sidebar-link-clicked')"
        class="{{ $baseClasses }} {{ $paddingClass }} {{ $activeClasses }} {{ $className }}"
        @if($isActive) aria-current="page" @endif
    >
        <div class="flex items-center gap-3 min-w-0 flex-1">
            @if(isset($item['icon']))
                <div class="flex-shrink-0">
                    <i class="{{ $item['icon'] }} w-5 h-5 {{ $iconClasses }} transition-colors duration-200"></i>
                </div>
            @endif
            <span class="font-medium truncate">{{ $item['name'] ?? '' }}</span>
        </div>
        
        @if(isset($item['external']) && $item['external'])
            <div class="flex-shrink-0">
                <x-heroicon-o-link class="w-3 h-3 text-gray-400 group-hover:text-lime-500 transition-colors duration-200"/>
            </div>
        @endif
    </a>
@endif