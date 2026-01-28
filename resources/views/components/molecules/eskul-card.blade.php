@props([
    'ekskul' => [],
    'buttonText' => 'Lihat Detail',
    'index' => 0,
    'className' => '',
])

@php
$modalId = 'ekskul-modal-' . ($ekskul['id'] ?? $index);
@endphp

<div>
    <article class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group {{ $className }}">
        <div class="relative h-48 overflow-hidden">
            <img
                src="{{ asset('storage/'.$ekskul['img']) ?? 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1200&q=80' }}"
                alt="{{ $ekskul['title'] ?? 'Ekstrakurikuler' }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                loading="lazy"
                onerror="this.src='https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1200&q=80'"
            />

            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="p-2 bg-white/90 backdrop-blur-sm rounded-full text-lime-500">
                    <x-heroicon-o-academic-cap class="w-5 h-5" />
                </div>
            </div>
        </div>

        <div class="p-6">
            <x-atoms.title
                :text="$ekskul['title'] ?? 'Untitled'"
                size="md"
                class="mb-3 group-hover:text-lime-600 transition-colors line-clamp-2"
            />

            <x-atoms.description class="mb-4 line-clamp-3 text-gray-600 leading-relaxed">
                {{ Str::limit($ekskul['desc'] ?? 'Tidak ada deskripsi.', 120) }}
            </x-atoms.description>

            <x-atoms.button 
                variant="ghost"
                theme="dark"
                heroicon="eye"
                class="w-full group-hover:bg-lime-600 group-hover:text-white transition-colors"
                @click="$dispatch('open-modal', { name: '{{ $modalId }}' })"
            >
                {{ $buttonText }}
            </x-atoms.button>
        </div>
    </article>

    <!-- Modal Detail -->
    <x-atoms.modal name="{{ $modalId }}" maxWidth="2xl">
        <div class="relative z-80">
            <img
                src="{{ asset('storage/'.$ekskul['img']) ?? 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1200&q=80' }}"
                alt="{{ $ekskul['title'] ?? 'Ekstrakurikuler' }}"
                class="w-full h-64 md:h-80 object-cover"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            />

            <div class="w-full h-64 md:h-80 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center" style="display: none;">
                <div class="text-center">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-500">Gambar tidak tersedia</p>
                </div>
            </div>

            <div class="absolute top-4 left-4">
                <div class="p-2 bg-lime-100 rounded-full">
                    <x-heroicon-o-academic-cap class="w-6 h-6 text-lime-600" />
                </div>
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
        </div>

        <div class="p-6 md:p-8 max-h-[60vh] overflow-y-auto">
            <x-atoms.title
                :text="$ekskul['title'] ?? 'Untitled'"
                size="2xl"
                mdSize="3xl"
                class="mb-6 text-gray-900 leading-tight"
            />

            <div class="prose prose-lg max-w-none">
                <x-atoms.description class="text-gray-700 leading-relaxed text-justify">
                    {{ $ekskul['desc'] ?? 'Tidak ada deskripsi.' }}
                </x-atoms.description>
            </div>
        </div>
    </x-atoms.modal>
</div>
