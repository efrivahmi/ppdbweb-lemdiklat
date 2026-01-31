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

        <div class="flex items-center space-x-1">
            {{-- Notification Bell --}}
            <div class="mr-2">
                @livewire('components.notification-bell')
            </div>

            <div class="h-8 w-px bg-gray-300 mx-2 hidden md:block"></div>

             <div class="">
                <x-atoms.description class="font-medium text-gray-800" size="sm" align="right">
                    {{ Auth::user()->name }}
                </x-atoms.description>
                <x-atoms.description size="sm" color="gray-500" align="right">
                    {{ Auth::user()->email }}
                </x-atoms.description>
            </div>

            <x-atoms.dropdown>
                <x-slot name="trigger">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile"
                        class="w-8 h-8 rounded-full object-cover">
                </x-slot>
                <div class="py-2">
                    @foreach ($userMenuItems as $item)
                    <a href="{{ route($item['url']) }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                        <i class="{{ $item['icon'] }} mr-3 w-4 h-4"></i>
                        {{ $item['name'] }}
                    </a>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 py-2">
                    @livewire('auth.logout')
                </div>
            </x-atoms.dropdown>
        </div>
    </div>
</header>