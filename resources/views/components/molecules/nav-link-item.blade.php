@props([
    'name' => '',
    'url' => '#',
    'icon' => '',
    'className' => '',
    'activeClass' => '',
    'inactiveClass' => '',
    'children' => [],
    'dropdownClass' => '',
    'isDropdown' => false,
    'isMobile' => false,
    'isButton' => false,
    'currentUrl' => '',
])

@php
    $isActive =
        $currentUrl === $url ||
        (count($children) > 0 &&
            collect($children)->contains(function ($child) use ($currentUrl) {
                // Handle nested dropdown children
                if (isset($child['children'])) {
                    return collect($child['children'])->contains(fn($subChild) => isset($subChild['url']) && $currentUrl === $subChild['url']);
                }
                return isset($child['url']) && $currentUrl === $child['url'];
            }));

    $hasChildren = $isDropdown && count($children) > 0;
@endphp

@if (!$hasChildren)
    @if ($isButton)
        {{-- Button Style Link --}}
        <a href="{{ $url }}"
            class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300 bg-gradient-to-r from-lime-600 to-emerald-600 text-white shadow-md hover:from-lime-700 hover:to-emerald-700 hover:shadow-lg {{ $className }}">
            @if ($icon)
                <span class="w-5 h-5">
                    <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-5 h-5" />
                </span>
            @endif
            <span>{{ $name }}</span>
        </a>
    @else
        {{-- Regular Link --}}
        <a href="{{ $url }}"
            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $className }} {{ $isActive ? $activeClass : $inactiveClass }}">
            @if ($icon)
                <span class="w-5 h-5">
                    <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-5 h-5" />
                </span>
            @endif
            <span>{{ $name }}</span>
        </a>
    @endif
@else
    <div class="relative" x-data="{
        isDropdownOpen: false,
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        openDropdown() {
            this.isDropdownOpen = true;
        },
        closeDropdown() {
            this.isDropdownOpen = false;
        }
    }"
        @if (!$isMobile)
            x-on:mouseenter="openDropdown()"
            x-on:mouseleave="closeDropdown()"
        @else
            x-on:click.away="isDropdownOpen = false"
        @endif>
        
        @if (!$isMobile)
            <div class="flex items-center justify-between w-full gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 cursor-pointer {{ $className }} {{ $isActive ? $activeClass : $inactiveClass }}">
                <div class="flex items-center gap-2">
                    @if ($icon)
                        <span class="w-5 h-5">
                            <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-5 h-5" />
                        </span>
                    @endif
                    <span>{{ $name }}</span>
                </div>
                <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200"
                    x-bind:class="{ 'rotate-180': isDropdownOpen }" />
            </div>
        @else
            <button x-on:click="toggleDropdown()"
                class="flex items-center justify-between w-full gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $className }} {{ $isActive ? $activeClass : $inactiveClass }}">
                <div class="flex items-center gap-2">
                    @if ($icon)
                        <span class="w-5 h-5">
                            <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-5 h-5" />
                        </span>
                    @endif
                    <span>{{ $name }}</span>
                </div>
                <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200"
                    x-bind:class="{ 'rotate-180': isDropdownOpen }" />
            </button>
        @endif

        @if (!$isMobile)
            <div x-show="isDropdownOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute left-0 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-50 origin-top {{ $dropdownClass }}"
                style="display: none;">
                <div class="py-1">
                    @foreach ($children as $child)
                        @if (isset($child['isDropdown']) && $child['isDropdown'] && isset($child['children']))
                            {{-- Nested submenu --}}
                            <div class="relative group/submenu" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                <div class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 cursor-pointer">
                                    <x-heroicon-o-chevron-left class="w-4 h-4" />
                                    <span>{{ $child['name'] }}</span>
                                </div>
                                <div x-show="subOpen" x-transition
                                     class="absolute right-full top-0 mr-1 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                                     style="display: none;">
                                    <div class="py-1">
                                        @foreach ($child['children'] as $subChild)
                                            @php $isSubActive = isset($subChild['url']) && $currentUrl === $subChild['url']; @endphp
                                            <a href="{{ $subChild['url'] ?? '#' }}"
                                               class="flex items-center gap-2 px-4 py-2 text-sm transition-colors duration-200 hover:bg-gray-50 {{ $isSubActive ? 'bg-lime-50 text-lime-600 font-medium' : 'text-gray-700' }}">
                                                <span>{{ $subChild['name'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            @php
                                $isChildActive = isset($child['url']) && $currentUrl === $child['url'];
                            @endphp
                            <a href="{{ $child['url'] ?? '#' }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm transition-colors duration-200 hover:bg-gray-50 {{ $isChildActive ? 'bg-lime-50 text-lime-600 font-medium' : 'text-gray-700' }}">
                                @if (isset($child['icon']) && $child['icon'])
                                    <span class="w-4 h-4">
                                        <x-dynamic-component :component="'heroicon-o-' . $child['icon']" class="w-4 h-4" />
                                    </span>
                                @endif
                                <span>{{ $child['name'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @if ($isMobile)
            <div x-show="isDropdownOpen" x-transition class="mt-1 ml-4 space-y-1 {{ $dropdownClass }}">
                @foreach ($children as $child)
                    @if (isset($child['isDropdown']) && $child['isDropdown'] && isset($child['children']))
                        {{-- Nested submenu for mobile --}}
                        <div x-data="{ subOpen: false }">
                            <button @click="subOpen = !subOpen" type="button"
                                class="flex items-center justify-between w-full px-4 py-2 text-sm rounded-lg text-gray-600 hover:bg-gray-100">
                                <span>{{ $child['name'] }}</span>
                                <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': subOpen }" />
                            </button>
                            <div x-show="subOpen" x-transition class="ml-4 mt-1 space-y-1">
                                @foreach ($child['children'] as $subChild)
                                    @php $isSubActive = isset($subChild['url']) && $currentUrl === $subChild['url']; @endphp
                                    <a href="{{ $subChild['url'] ?? '#' }}" x-on:click="isDropdownOpen = false"
                                       class="flex items-center gap-2 px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $isSubActive ? 'bg-lime-100 text-lime-600 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                                        <span>{{ $subChild['name'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @php
                            $isChildActive = isset($child['url']) && $currentUrl === $child['url'];
                        @endphp
                        <a href="{{ $child['url'] ?? '#' }}" x-on:click="isDropdownOpen = false"
                            class="flex items-center gap-2 px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $isChildActive ? 'bg-lime-100 text-lime-600 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                            @if (isset($child['icon']) && $child['icon'])
                                <span class="w-4 h-4">
                                    <x-dynamic-component :component="'heroicon-o-' . $child['icon']" class="w-4 h-4" />
                                </span>
                            @endif
                            <span>{{ $child['name'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endif