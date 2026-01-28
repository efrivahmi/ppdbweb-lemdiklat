<header x-data="{ mobileMenuOpen: false, scrolled: false }" 
        x-init="window.addEventListener('scroll', () => {
            scrolled = window.pageYOffset > 20;
        });
        document.addEventListener('mousedown', (e) => {
            if (mobileMenuOpen && !e.target.closest('header')) {
                mobileMenuOpen = false;
            }
        });" 
        :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg' : 'bg-white/80 backdrop-blur-sm'"
        class="sticky top-0 z-50 transition-all duration-500 ease-out border-b border-gray-100/50">
    
    <div class="w-full flex items-center justify-between px-3 py-2 md:px-4 md:py-3 lg:px-6 lg:py-4 transition-all duration-300">
        <!-- Logo & Text -->
        <div class="flex items-center space-x-2 md:space-x-3 flex-1 min-w-0">
            <img src="{{ asset('assets/logo.png') }}" 
                 alt="Logo" 
                 class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover flex-shrink-0">
            
            <div class="flex flex-col min-w-0 flex-1">
                <x-atoms.title 
                    text="Lemdiklat Taruna Nusantara Indonesia" 
                    size="sm" 
                    class="text-gray-900 text-xs sm:text-sm md:text-base lg:text-xl leading-tight truncate" />
                
                <x-atoms.description 
                    class="text-gray-600 text-[10px] sm:text-xs leading-tight truncate">
                    SMA Taruna Nusantara Indonesia | SMK Taruna Nusantara Jaya
                </x-atoms.description>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-1 flex-shrink-0">
            @foreach ($navLinks as $link)
                <x-molecules.nav-link-item 
                    :name="$link['name']" 
                    :url="$link['url'] ?? null" 
                    :icon="$link['icon']" 
                    :isDropdown="$link['isDropdown']"
                    :isButton="$link['isButton'] ?? false"
                    :children="$link['children'] ?? []" 
                    activeClass="bg-lime-100 text-lime-700 font-semibold"
                    inactiveClass="text-zinc-700 hover:bg-zinc-50" 
                    dropdownClass="min-w-56 bg-white/95 backdrop-blur-sm"
                    :currentUrl="$currentUrl" 
                    :isHover="true" />
            @endforeach
        </nav>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg hover:bg-zinc-100 focus:outline-none transition-colors duration-200 flex-shrink-0 ml-2">
            <template x-if="!mobileMenuOpen">
                <x-heroicon-o-bars-3 class="w-5 h-5 text-gray-900" />
            </template>
            <template x-if="mobileMenuOpen">
                <x-heroicon-o-x-mark class="w-5 h-5 text-gray-900" />
            </template>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition
         class="md:hidden bg-white/95 backdrop-blur-sm border-t border-zinc-100 shadow-lg overflow-hidden">
        <nav class="px-4 py-4 md:px-6 md:py-5 space-y-1">
            @foreach ($navLinks as $link)
                <x-molecules.nav-link-item 
                    :name="$link['name']" 
                    :url="$link['url'] ?? null" 
                    :icon="$link['icon']" 
                    :isDropdown="$link['isDropdown']"
                    :isButton="$link['isButton'] ?? false"
                    :children="collect($link['children'] ?? [])
                        ->map(function ($child) {
                            $child['onClick'] = 'mobileMenuOpen = false';
                            return $child;
                        })
                        ->toArray()" 
                    class="w-full" 
                    activeClass="bg-lime-100 text-lime-700 font-semibold"
                    inactiveClass="text-zinc-700 hover:bg-zinc-50"
                    dropdownClass="bg-gray-50/80 backdrop-blur-sm border-gray-100" 
                    :isMobile="true"
                    :currentUrl="$currentUrl" />
            @endforeach
        </nav>
    </div>
</header>