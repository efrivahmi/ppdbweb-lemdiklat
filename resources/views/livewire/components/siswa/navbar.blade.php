<header class="bg-white border-b border-gray-200">
    <div class="flex items-center justify-between py-2 px-4">
        <div class="hidden lg:flex items-center space-x-3">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col">
                <x-atoms.title text="Lemdiklat Taruna Nusantara Indonesia" size="sm" class="text-gray-900 text-sm lg:text-xl" />
                <x-atoms.description class="text-gray-600 text-xs">SMA Taruna Nusantara Indonesia | SMK Taruna Nusantara Jaya</x-atoms.description>
            </div>
        </div>

        <div class="flex-1 max-w-md mx-4">
        </div>

        {{-- Right: Notification Bell & User Info --}}
        <div class="flex items-center gap-2 md:gap-4">
            {{-- Notification Bell --}}
            @livewire('components.notification-bell')

            {{-- Divider --}}
            <div class="h-8 w-px bg-gray-200 hidden md:block"></div>

            {{-- User Profile Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                {{-- Trigger --}}
                <button 
                    @click="open = !open"
                    class="flex items-center gap-2 md:gap-3 hover:bg-gray-50 rounded-lg px-2 py-1.5 transition-colors focus:outline-none cursor-pointer"
                >
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-sm font-semibold text-gray-900 leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</span>
                    </div>
                    
                    <img class="h-8 w-8 md:h-10 md:w-10 rounded-full object-cover border-2 border-gray-100" 
                         src="{{ Auth::user()->profile_photo_url }}" 
                         alt="{{ Auth::user()->name }}" />
                    
                    <i class="ri-arrow-down-s-line text-lg text-gray-400 hidden md:block transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
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
                    <div class="py-2">
                        @foreach ($userMenuItems as $item)
                        <a href="{{ route($item['url']) }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="{{ $item['icon'] }} text-lg"></i>
                            {{ $item['name'] }}
                        </a>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 py-2">
                        @livewire('auth.logout')
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>