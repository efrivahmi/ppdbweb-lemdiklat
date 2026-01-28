@props([
    'achievement' => [],
    'buttonText' => 'Lihat Detail',
    'index' => 0,
    'className' => '',
])

@php
$modalId = 'achievement-modal-' . ($achievement['id'] ?? $index);
@endphp

<div>
    <article class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group {{ $className }}">
        <div class="relative h-48 overflow-hidden">
            <img
                src="{{ $achievement['image'] ?? 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}"
                alt="{{ $achievement['title'] ?? 'Achievement' }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                loading="lazy"
                onerror="this.src='https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'"
            />
            
            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="p-2 bg-white/90 backdrop-blur-sm rounded-full text-yellow-500">
                    <x-heroicon-o-trophy class="w-5 h-5" />
                </div>
            </div>
        </div>

        <div class="p-6">
            <x-atoms.title
                :text="$achievement['title'] ?? 'Untitled'"
                size="md"
                class="mb-3 group-hover:text-lime-600 transition-colors line-clamp-2"
            />

            <x-atoms.description class="mb-4 line-clamp-3 text-gray-600 leading-relaxed">
                {{ Str::limit($achievement['description'] ?? 'No description available.', 150) }}
            </x-atoms.description>

            <div class="flex items-center justify-between mb-4 text-sm text-gray-500">
                <div class="flex items-center">
                    <x-heroicon-o-star class="w-4 h-4 text-yellow-500 mr-1" />
                    <span>Prestasi Terbaik</span>
                </div>
                
                @if(isset($achievement['created_at']))
                    <div class="flex items-center">
                        <x-heroicon-o-calendar class="w-4 h-4 mr-1" />
                        <time datetime="{{ $achievement['created_at'] }}">
                            {{ $achievement['created_at'] }}
                        </time>
                    </div>
                @endif
            </div>

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

    <x-atoms.modal name="{{ $modalId }}" maxWidth="3xl">
        <div class="relative z-80">
            <img
                src="{{ $achievement['image'] ?? 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}"
                alt="{{ $achievement['title'] ?? 'Achievement' }}"
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
                <div class="p-2 bg-yellow-100 rounded-full">
                    <x-heroicon-o-trophy class="w-6 h-6 text-yellow-600" />
                </div>
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
        </div>

        <div class="p-6 md:p-8 max-h-[60vh] overflow-y-auto">
            <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-star class="w-4 h-4 text-yellow-500" />
                    <span class="font-medium">Prestasi Terbaik</span>
                </div>
                
                @if(isset($achievement['created_at']))
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-calendar class="w-4 h-4 text-lime-600" />
                        <span class="font-medium">{{ $achievement['created_at'] }}</span>
                    </div>
                @endif

                @if(isset($achievement['category']))
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-tag class="w-4 h-4 text-lime-600" />
                        <span class="font-medium">{{ $achievement['category'] }}</span>
                    </div>
                @endif
            </div>

            <x-atoms.title
                :text="$achievement['title'] ?? 'Untitled'"
                size="2xl"
                mdSize="3xl"
                class="mb-6 text-gray-900 leading-tight"
            />

            <div class="prose prose-lg max-w-none mb-8">
                <x-atoms.description class="text-gray-700 leading-relaxed text-justify">
                    {{ $achievement['description'] ?? 'No description available.' }}
                </x-atoms.description>
            </div>

            @if(isset($achievement['details']))
                <div class="mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <h4 class="text-sm font-semibold text-yellow-800 mb-2">Detail Prestasi:</h4>
                    <div class="text-sm text-yellow-700">
                        {{ $achievement['details'] }}
                    </div>
                </div>
            @endif
        </div>
    </x-atoms.modal>
</div>