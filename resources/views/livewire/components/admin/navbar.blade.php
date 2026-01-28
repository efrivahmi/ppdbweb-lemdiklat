<header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
    
    {{-- Left: Mobile Toggle & Page Title (Optional) --}}
    <div class="flex items-center gap-4">
        {{-- Mobile Menu Trigger --}}
        <button 
            @click="sidebarOpen = true"
            class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-lime-500"
        >
            <span class="sr-only">Open sidebar</span>
            <x-heroicon-o-bars-3 class="w-6 h-6" />
        </button>

        {{-- Optional: Breadcrumbs or Page Title could go here --}}
    </div>

    {{-- Right: Actions & User Menu --}}
    <div class="flex items-center gap-4">
        
        {{-- Real-time Notification Bell --}}
        @livewire('components.notification-bell')
        
        {{-- User Menu --}}
        <x-atoms.dropdown position="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center gap-2 transition-opacity hover:opacity-80 focus:outline-none">
                    <img class="h-8 w-8 rounded-full object-cover border border-gray-200" 
                         src="{{ Auth::user()->profile_photo_url }}" 
                         alt="{{ Auth::user()->name }}" />
                    
                    <div class="hidden md:flex flex-col items-start">
                        <span class="text-sm font-semibold text-gray-700 leading-none">{{ Auth::user()->name }}</span>
                        {{-- <span class="text-xs text-gray-500 mt-0.5">Administrator</span> --}}
                    </div>
                    
                    <x-heroicon-m-chevron-down class="h-4 w-4 text-gray-400 hidden md:block" />
                </button>
            </x-slot>

            <div class="py-1">
                <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-sm text-gray-500">Signed in as</p>
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-lime-600">
                    Profile Settings
                </a>
                
                <div class="border-t border-gray-100"></div>
                
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <a href="{{ route('logout') }}"
                       @click.prevent="$root.submit();"
                       class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        Log Out
                    </a>
                </form>
            </div>
        </x-atoms.dropdown>
    </div>
</header>