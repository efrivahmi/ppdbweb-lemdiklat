<div x-data="{ sidebarOpen: @entangle('sidebarOpen') }"
     x-on:click.away="if (window.innerWidth < 1024) sidebarOpen = false"
     class="flex flex-col h-full bg-white border-r border-gray-200"
     >

    {{-- Mobile Overlay Trigger (Hidden on Desktop) --}}
    <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-gray-900/50 lg:hidden" x-transition.opacity></div>

    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
         class="fixed lg:static inset-y-0 left-0 z-30 w-[16rem] bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col h-full">

        {{-- Filament-style Brand Header --}}
        <div class="h-16 flex items-center px-6 border-b border-gray-100 shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="relative w-8 h-8 flex items-center justify-center bg-gradient-to-br from-lime-400 to-lime-600 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                    <span class="text-white font-bold text-lg">TN</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-gray-900 tracking-tight leading-none group-hover:text-lime-600 transition-colors">PPDB</span>
                    <span class="text-[10px] font-medium text-gray-500 uppercase tracking-wider leading-none mt-1">Admin Panel</span>
                </div>
            </a>
        </div>

        {{-- Scrollable Navigation Area --}}
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
            @foreach ($menuItems as $item)
                @if(isset($item['header']))
                     <div class="px-3 mb-2 mt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        {{ $item['header'] }}
                    </div>
                @else
                    <x-molecules.sidebar-link
                        :item="$item"
                        :currentPath="$currentPath"
                        :expandedItems="$expandedItems"
                        wire:key="admin-sidebar-item-{{ $item['key'] }}" />
                @endif
            @endforeach
        </nav>

        {{-- Footer / User Profile (Optional, similar to Filament sidebar footer) --}}
        <div class="p-4 border-t border-gray-100 shrink-0">
            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full bg-gray-200 object-cover">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>