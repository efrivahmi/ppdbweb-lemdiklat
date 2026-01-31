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

        <div class="grid grid-flow-col items-center gap-4 md:gap-6">
            
            {{-- 1. Notification Bell --}}
            <div class="flex items-center justify-center">
                @livewire('components.notification-bell')
            </div>

            {{-- 2. Vertical Separator --}}
            <div class="hidden md:block h-8 w-px bg-gray-200"></div>

            {{-- 3. User Identification --}}
            <div class="hidden md:flex flex-col items-end mr-1 space-y-0.5">
                <span class="block text-sm font-bold text-gray-800 leading-none">
                    {{ Auth::user()->name }}
                </span>
                <span class="block text-[11px] font-medium text-gray-500 uppercase tracking-wider leading-none">
                    {{ Auth::user()->email }}
                </span>
            </div>

            {{-- 4. Profile Dropdown --}}
            <div class="relative">
                <x-atoms.dropdown>
                    <x-slot name="trigger">
                        <button class="flex items-center justify-center transition-transform hover:scale-105 focus:outline-none">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-gray-100">
                        </button>
                    </x-slot>
                    <div class="py-2 w-48">
                        <!-- Account Management Header -->
                        <div class="block px-4 py-2 text-xs text-gray-400 uppercase tracking-wider font-semibold">
                            Manage Account
                        </div>
                        
                        @foreach ($userMenuItems as $item)
                        <a href="{{ route($item['url']) }}"
                            class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                            <i class="{{ $item['icon'] }} mr-3 w-4 h-4 text-gray-400 group-hover:text-blue-500"></i>
                            {{ $item['name'] }}
                        </a>
                        @endforeach
                        
                        <div class="border-t border-gray-100 my-1"></div>
                        
                        <div class="block px-4 py-1">
                            @livewire('auth.logout')
                        </div>
                    </div>
                </x-atoms.dropdown>
            </div>
        </div>
    </div>
</header>