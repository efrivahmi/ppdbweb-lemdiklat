<section class="py-12 md:py-16 bg-gray-50">
    <div class="container max-w-7xl mx-auto">
        <div class="text-center mb-8 md:mb-12">
            <x-atoms.title
                text="Galeri Sekolah"
                highlight="Galeri"
                size="xl"
                mdSize="3xl"
                align="center"
                className="mb-2 md:mb-3"
            />
            <x-atoms.description 
                size="sm" 
                mdSize="md" 
                align="center"
                color="gray-600"
            >
                Dokumentasi kegiatan dan fasilitas sekolah kami
            </x-atoms.description>
        </div>

        @if($galleries->count() > 0)
            <div 
                x-data="{ 
                    currentSlide: 0,
                    showLightbox: false,
                    autoplayInterval: null,
                    isPaused: false,
                    galleries: @js($galleries->map(fn($item) => [
                        'id' => $item->id,
                        'title' => $item->title,
                        'image' => $item->image ? asset('storage/' . $item->image) : null
                    ])),
                    
                    init() {
                        this.startAutoplay();
                    },
                    
                    startAutoplay() {
                        this.autoplayInterval = setInterval(() => {
                            if (!this.isPaused && !this.showLightbox) {
                                this.nextSlide();
                            }
                        }, 2500);
                    },
                    
                    stopAutoplay() {
                        if (this.autoplayInterval) {
                            clearInterval(this.autoplayInterval);
                        }
                    },
                    
                    pauseAutoplay() {
                        this.isPaused = true;
                    },
                    
                    resumeAutoplay() {
                        this.isPaused = false;
                    },
                    
                    nextSlide() {
                        this.currentSlide = (this.currentSlide + 1) % this.galleries.length;
                    },
                    
                    prevSlide() {
                        this.currentSlide = (this.currentSlide - 1 + this.galleries.length) % this.galleries.length;
                    },
                    
                    goToSlide(index) {
                        this.currentSlide = index;
                    },
                    
                    openLightbox(index) {
                        this.currentSlide = index;
                        this.showLightbox = true;
                        document.body.style.overflow = 'hidden';
                    },
                    
                    closeLightbox() {
                        this.showLightbox = false;
                        document.body.style.overflow = '';
                    }
                }"
                @mouseenter="pauseAutoplay()"
                @mouseleave="resumeAutoplay()"
                @keydown.escape.window="closeLightbox()"
                @keydown.arrow-right.window="!showLightbox && nextSlide()"
                @keydown.arrow-left.window="!showLightbox && prevSlide()"
                class="max-w-6xl mx-auto"
            >
                <div class="relative px-0"">
                    <div class="relative overflow-hidden rounded-xl md:rounded-2xl">
                        <div class="relative h-80 md:h-96 lg:h-[500px]">
                            @foreach($galleries as $index => $gallery)
                                <div 
                                    x-show="currentSlide === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0 transform translate-x-full"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    x-transition:leave="transition ease-in duration-500"
                                    x-transition:leave-start="opacity-100 transform translate-x-0"
                                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                                    class="absolute inset-0 w-full h-full"
                                    style="display: none;"
                                >
                                    <div 
                                        @click="openLightbox({{ $index }})"
                                        class="group relative w-full h-full cursor-pointer"
                                    >
                                        @if($gallery->image)
                                            <img 
                                                src="{{ asset('storage/' . $gallery->image) }}" 
                                                alt="{{ $gallery->title }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                                <x-heroicon-o-photo class="w-20 h-20 text-white/50" />
                                            </div>
                                        @endif

                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                        <div class="absolute inset-0 p-4 md:p-6 flex flex-col justify-end opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-white mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                {{ $gallery->title }}
                                            </h3>
                                            <div class="flex items-center gap-2 text-white/90 text-xs md:text-sm">
                                                <x-heroicon-o-magnifying-glass-plus class="w-4 h-4 md:w-5 md:h-5" />
                                                <span>Klik untuk memperbesar</span>
                                            </div>
                                        </div>

                                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm p-2 md:p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <x-heroicon-o-magnifying-glass-plus class="w-5 h-5 md:w-6 md:h-6 text-gray-700" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button 
                        @click="prevSlide();"
                        class="absolute left-0 md:left-0 top-1/2 transform -translate-y-1/ hover:bg-lime-500 text-lime-600 hover:text-white p-2 md:p-3 rounded-full shadow-lg transition-all duration-300 z-10 group"
                        aria-label="Previous slide"
                    >
                        <x-heroicon-o-chevron-left class="w-5 h-5 md:w-6 md:h-6" />
                    </button>

                    <button 
                        @click="nextSlide();"
                        class="absolute right-0 md:right-0 top-1/2 transform -translate-y-1/2 hover:bg-lime-500 text-lime-600 hover:text-white p-2 md:p-3 rounded-full shadow-lg transition-all duration-300 z-10 group"
                        aria-label="Next slide"
                    >
                        <x-heroicon-o-chevron-right class="w-5 h-5 md:w-6 md:h-6" />
                    </button>

                    <div class="flex justify-center gap-2 mt-6 md:mt-8">
                        @foreach($galleries as $index => $gallery)
                            <button 
                                @click="goToSlide({{ $index }})"
                                class="transition-all duration-300"
                                :class="currentSlide === {{ $index }} ? 'w-8 h-2 bg-lime-500 rounded-full' : 'w-2 h-2 bg-gray-300 hover:bg-lime-300 rounded-full'"
                                aria-label="Go to slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                </div>

                <div 
                    x-show="showLightbox"
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4"
                    @click="closeLightbox()"
                    @keydown.arrow-right.window="showLightbox && nextSlide()"
                    @keydown.arrow-left.window="showLightbox && prevSlide()"
                >
                    <button 
                        @click.stop="closeLightbox()"
                        class="absolute top-4 right-4 z-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-2 rounded-full transition-all duration-200"
                        aria-label="Close"
                    >
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>

                    <button 
                        @click.stop="prevSlide()"
                        class="absolute left-4 z-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-200"
                        aria-label="Previous"
                    >
                        <x-heroicon-o-chevron-left class="w-6 h-6" />
                    </button>

                    <button 
                        @click.stop="nextSlide()"
                        class="absolute right-4 z-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-200"
                        aria-label="Next"
                    >
                        <x-heroicon-o-chevron-right class="w-6 h-6" />
                    </button>

                    <div 
                        @click.stop
                        class="relative max-w-6xl max-h-[90vh] w-full"
                    >
                        <template x-for="(gallery, index) in galleries" :key="gallery.id">
                            <div 
                                x-show="currentSlide === index"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                class="flex flex-col items-center"
                            >
                                <img 
                                    :src="gallery.image" 
                                    :alt="gallery.title"
                                    class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl"
                                >
                                <div class="mt-4 text-center">
                                    <h3 
                                        x-text="gallery.title"
                                        class="text-xl md:text-2xl font-bold text-white"
                                    ></h3>
                                    <p class="text-white/70 text-sm mt-1">
                                        <span x-text="currentSlide + 1"></span> / <span x-text="galleries.length"></span>
                                    </p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-4 text-white/60 text-xs">
                        <div class="flex items-center gap-1">
                            <kbd class="px-2 py-1 bg-white/10 rounded">ESC</kbd>
                            <span>Tutup</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <kbd class="px-2 py-1 bg-white/10 rounded">←</kbd>
                            <kbd class="px-2 py-1 bg-white/10 rounded">→</kbd>
                            <span>Navigasi</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 md:w-20 h-16 md:h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-photo class="w-8 md:w-10 h-8 md:h-10 text-gray-400" />
                </div>
                <x-atoms.title text="Galeri Kosong" size="md" class="text-gray-700 mb-2" align="center"/>
                <x-atoms.description class="text-gray-500" align="center">
                    Belum ada foto dalam galeri
                </x-atoms.description>
            </div>
        @endif
    </div>

    @push('styles')
    <style>
        /* Hide elements with x-cloak until Alpine.js loads */
        [x-cloak] {
            display: none !important;
        }

        /* Smooth transitions for slide changes */
        [x-show] {
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }

        /* Custom scrollbar for lightbox (optional) */
        .lightbox-container::-webkit-scrollbar {
            width: 8px;
        }

        .lightbox-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .lightbox-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        .lightbox-container::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
    @endpush
</section>