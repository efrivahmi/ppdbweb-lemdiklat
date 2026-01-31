{{-- Sidebar Wrapper - takes space in flex layout on desktop --}}
<div class="shrink-0 lg:w-64">
    {{-- Mobile Overlay --}}
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false"
        class="fixed inset-0 z-20 bg-gray-900/50 lg:hidden" 
        style="top: 64px;"
        x-transition.opacity
    ></div>

    {{-- Sidebar Container --}}
    <div 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed lg:sticky top-16 lg:top-0 left-0 bottom-0 z-30 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out flex flex-col lg:h-[calc(100vh-64px)]"
    >
        {{-- Scrollable Navigation Area --}}
        <nav class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden px-4 py-6 space-y-1">
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

        {{-- Profile & Actions Footer --}}
        <div class="flex-shrink-0 p-4 border-t border-gray-100 space-y-2 bg-white">
            {{-- Profile Link --}}
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-emerald-50 transition-colors group">
                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="ri-user-settings-line text-emerald-600"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-600">Edit Profile</span>
            </a>
            
            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-red-50 transition-colors group">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="ri-logout-box-line text-red-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-red-600">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>
