<div x-data="{ sidebarOpen: @entangle('sidebarOpen') }"
     x-on:click.away="if (window.innerWidth < 1024) sidebarOpen = false">

    <button x-on:click="sidebarOpen = !sidebarOpen"
            class="fixed top-2 left-4 z-30 lg:hidden text-gray-900 p-2 rounded-lg">
        <x-heroicon-o-bars-3 class="w-6 h-6" />
    </button>

    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
         class="z-40 w-64 h-full bg-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static fixed overflow-y-auto">

        <nav class="px-3 py-6 space-y-1">
            @foreach ($menuItems as $item)
                <x-molecules.sidebar-link
                    :item="$item"
                    :currentPath="$currentPath"
                    :expandedItems="$expandedItems"
                    wire:key="guru-sidebar-item-{{ $item['key'] }}" />
            @endforeach
        </nav>
    </div>
</div>