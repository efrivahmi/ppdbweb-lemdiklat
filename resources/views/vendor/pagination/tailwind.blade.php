@if ($paginator->hasPages())
    <nav aria-label="Page navigation" class="mt-6">
        <ul class="flex items-center justify-center gap-2">
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

            {{-- Link Halaman --}}
            <div class="flex items-center gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span class="flex items-center justify-center px-3 py-2 text-sm text-gray-500">
                                {{ $element }}
                            </span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-lime-600 border border-lime-600 rounded-lg shadow-sm">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" type="button"
                                        class="flex items-center justify-center w-10 h-10 text-sm font-medium text-lime-600 bg-white border border-lime-300 rounded-lg hover:bg-lime-50 hover:border-lime-500 transition-all duration-200">
                                        {{ $page }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

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
