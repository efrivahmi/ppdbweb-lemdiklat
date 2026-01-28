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

        <div class="flex items-center space-x-2">
            <div class="">
                <x-atoms.description class="font-medium text-gray-800" size="sm" align="right">
                    {{ Auth::user()->name }}
                </x-atoms.description>
                <x-atoms.description size="sm" color="gray-500" align="right">
                    {{ Auth::user()->email }}
                </x-atoms.description>
            </div>
            <x-atoms.dropdown position="right">
                <x-slot name="trigger">
                    <img src="{{ Auth::user()->getProfilePhotoUrlAttribute() }}" alt="Profile"
                        class="w-8 h-8 rounded-full object-cover">
                </x-slot>

                <div class="p-3 border-b border-gray-200">
                    <x-atoms.badge text="Guru" variant="emerald" size="sm"
                        class="mt-2 flex items-center w-fit">
                        <i class="ri-shield-user-line mr-1"></i>
                        Guru
                    </x-atoms.badge>
                </div>

                <div class="py-2">
                    <a href="{{ route('guru.profile') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                        <i class="ri-user-line mr-3 w-4 h-4"></i>
                        Profile
                    </a>
                </div>

                <div class="border-t border-gray-200 py-2">
                    @livewire('auth.logout')
                </div>
            </x-atoms.dropdown>
        </div>
    </div>
</header>