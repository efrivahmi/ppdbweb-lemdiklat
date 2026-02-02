@if ($paginator->hasPages())
    <nav aria-label="Page navigation" class="mt-6">
        <ul class="flex items-center justify-between w-full">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-4 py-2 min-w-[100px] text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                        <x-heroicon-o-chevron-left class="w-4 h-4 mr-2" />
                        <span>Previous</span>
                    </span>
                </li>
            @else
                <li>
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" type="button"
                        class="flex items-center justify-center px-4 py-2 min-w-[100px] text-sm font-medium text-white bg-lime-500 border border-lime-500 rounded-lg hover:bg-lime-600 hover:shadow-md transition-all duration-200 active:scale-95">
                        <x-heroicon-o-chevron-left class="w-4 h-4 mr-2" />
                        <span>Previous</span>
                    </button>
                </li>
            @endif

            {{-- Tombol Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" type="button"
                        class="flex items-center justify-center px-4 py-2 min-w-[100px] text-sm font-medium text-white bg-lime-500 border border-lime-500 rounded-lg hover:bg-lime-600 hover:shadow-md transition-all duration-200 active:scale-95">
                        <span>Next</span>
                        <x-heroicon-o-chevron-right class="w-4 h-4 ml-2" />
                    </button>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center px-4 py-2 min-w-[100px] text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                        <span>Next</span>
                        <x-heroicon-o-chevron-right class="w-4 h-4 ml-2" />
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
