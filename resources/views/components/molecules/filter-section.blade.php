@props([
    'searchPlaceholder' => 'Cari...',
    'initialSearch' => '',
    'showActiveFilters' => true,
    'showKeyboardTip' => false,
    'className' => '',
])

<div 
    x-data="{
        searchTerm: @js($initialSearch),
        
        get hasActiveFilters() {
            return this.searchTerm.length > 0;
        },
        
        handleSearchChange(value) {
            this.searchTerm = value;
            this.emitFilterChange();
            $wire.dispatch('search-changed', { search: value });
        },
        
        clearSearch() {
            this.searchTerm = '';
            this.emitFilterChange();
            $wire.dispatch('search-cleared');
        },
        
        resetFilters() {
            this.searchTerm = '';
            this.emitFilterChange();
            $wire.dispatch('filters-reset');
        },
        
        emitFilterChange() {
            $wire.dispatch('filter-changed', {
                search: this.searchTerm
            });
        }
    }"
    class="{{ $className }}"
>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-600" />
                <x-atoms.title text="Pencarian" size="lg"/>
                <template x-if="hasActiveFilters">
                    <x-atoms.badge 
                        text="1 aktif"
                        variant="emerald" 
                        size="sm"
                    />
                </template>
            </div>
        </div>

        <div class="relative">
            <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" />
            <x-atoms.input
                type="text"
                :placeholder="$searchPlaceholder"
                x-model="searchTerm"
                x-on:input="handleSearchChange($event.target.value)"
                class="pl-10 pr-10 bg-white"
            />
            <button
                x-show="searchTerm"
                x-on:click="clearSearch()"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 p-1 hover:bg-gray-100 rounded-full transition-colors duration-150"
                aria-label="Clear search"
            >
                <x-heroicon-o-x-mark class="w-4 h-4 text-gray-400 hover:text-gray-600" />
            </button>
        </div>
        @if($showKeyboardTip)
            <div class="pt-2 border-t border-gray-100">
                <p class="text-xs text-gray-400 text-center">
                    Tips: Gunakan 
                    <kbd class="px-1 py-0.5 text-xs bg-gray-100 rounded">⌘K</kbd>
                    untuk pencarian cepat
                </p>
            </div>
        @endif
    </div>
</div>