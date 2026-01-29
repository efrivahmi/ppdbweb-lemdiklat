<header class="flex items-center justify-between h-16 px-4 md:px-6 bg-white border-b border-gray-200 w-full shrink-0">
    
    {{-- Left: Logo & School Name --}}
    <div class="flex items-center gap-3">
        {{-- Mobile Menu Trigger --}}
        <button 
            @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500"
        >
            <span class="sr-only">Open sidebar</span>
            <x-heroicon-o-bars-3 class="w-6 h-6" />
        </button>
        
        {{-- Logo & School Name --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 md:gap-3">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-8 h-8 md:w-10 md:h-10 object-contain">
            <div class="flex flex-col">
                <span class="text-xs md:text-sm font-bold text-gray-900 leading-tight">Lemdiklat Taruna Nusantara Indonesia</span>
                <span class="text-[8px] md:text-[10px] text-gray-500 leading-tight">SMA Taruna Nusantara Indonesia | SMK Taruna Nusantara Jaya</span>
            </div>
        </a>
    </div>

    {{-- Right: Notification Bell & User Info --}}
    <div class="flex items-center gap-2 md:gap-4">
        
        {{-- Real-time Notification Bell --}}
        @livewire('components.notification-bell')
        
        {{-- Divider --}}
        <div class="h-8 w-px bg-gray-200 hidden md:block"></div>
        
        {{-- User Profile Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            {{-- Trigger --}}
            <button 
                @click="open = !open"
                class="flex items-center gap-2 md:gap-3 hover:bg-gray-50 rounded-lg px-1.5 md:px-2 py-1.5 transition-colors focus:outline-none cursor-pointer"
            >
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-semibold text-gray-900 leading-none">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</span>
                </div>
                
                <img class="h-8 w-8 md:h-10 md:w-10 rounded-full object-cover border-2 border-emerald-100" 
                     src="{{ Auth::user()->profile_photo_url }}" 
                     alt="{{ Auth::user()->name }}" />
                
                <x-heroicon-m-chevron-down class="h-4 w-4 text-gray-400 hidden md:block transition-transform duration-200" x-bind:class="{ 'rotate-180': open }" />
            </button>

            {{-- Dropdown Menu --}}
            <div 
                x-show="open" 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50 overflow-hidden"
                style="display: none;"
            >
                {{-- User Info Header --}}
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                    <p class="text-xs text-gray-500">Signed in as</p>
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                {{-- Edit Profile --}}
                <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                    <i class="ri-user-settings-line text-lg"></i>
                    Edit Profile
                </a>
                
                <div class="border-t border-gray-100"></div>
                
                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                        <i class="ri-logout-box-line text-lg"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>