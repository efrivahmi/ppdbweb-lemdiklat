<section class="py-12 md:py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 md:gap-6 max-w-7xl mx-auto">
            @forelse ($linkPhotos as $linkPhoto)
                <a 
                    href="{{ $linkPhoto->url }}" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group relative h-64 md:h-80 rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer"
                >
                    @if ($linkPhoto->image)
                        <img 
                            src="{{ Storage::url($linkPhoto->image) }}"
                            alt="{{ $linkPhoto->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        >
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-lime-500 to-lime-700 flex items-center justify-center">
                            <x-heroicon-o-photo class="w-20 h-20 text-white/50" />
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute inset-0 p-4 md:p-6 flex flex-col justify-end">
                        <h3 class="text-xl md:text-2xl font-bold text-white mb-2 md:mb-3 transform group-hover:translate-y-[-4px] transition-transform duration-300">
                            {{ $linkPhoto->title }}
                        </h3>
                    </div>

                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 md:w-20 h-16 md:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-heroicon-o-photo class="w-8 md:w-10 h-8 md:h-10 text-gray-400" />
                    </div>
                    <p class="text-gray-500 text-base md:text-lg">Belum ada link photo tersedia</p>
                </div>
            @endforelse
        </div>
    </div>
</section>