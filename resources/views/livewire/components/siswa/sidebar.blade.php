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
                    wire:key="siswa-sidebar-item-{{ $item['key'] }}"/>
            @endforeach

            {{-- Menu ini muncul sejak tanggal pengumuman dan seterusnya --}}
            @if ($gelombangActive?->isPengumumanTerbuka())
                <x-molecules.sidebar-link 
                    :item="[
                        'key' => 'status-penerimaan',
                        'name' => 'Status Penerimaan',
                        'url' => route('siswa.status-penerimaan'),
                        'icon' => 'ri-verified-badge-line',
                        'type' => 'link'
                    ]"
                    :currentPath="$currentPath" 
                    :expandedItems="$expandedItems"
                    wire:key="siswa-sidebar-item-status-penerimaan"
                />
            @endif
        </nav>
    </div>
</div>