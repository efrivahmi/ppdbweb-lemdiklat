<section class="">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 md:mb-12">
            <x-atoms.title 
                text="Jalur Pendaftaran 2026/2027"
                highlight="2026/2027"
                size="xl"
                mdSize="3xl"
                align="center"
                className="mb-2 md:mb-3"
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 max-w-6xl mx-auto">
            @forelse ($jalurs as $jalur)
                <div class="group relative h-64 md:h-80 rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                    @if ($jalur->img)
                        <img src="{{ Storage::url($jalur->img) }}"
                             alt="{{ $jalur->nama }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-lime-500 to-lime-700"></div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                    <div class="absolute inset-0 p-4 md:p-6 flex flex-col justify-end">
                        <h3 class="text-xl md:text-2xl font-bold text-white mb-2 md:mb-3 transform group-hover:translate-y-[-4px] transition-transform duration-300">
                            {{ $jalur->nama }}
                        </h3>
                        
                        <p class="text-white/90 text-xs md:text-sm leading-relaxed line-clamp-2 md:line-clamp-3">
                            {{ $jalur->deskripsi ?: 'Jalur pendaftaran tersedia untuk calon siswa baru.' }}
                        </p>
                    </div>

                    
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 md:w-20 h-16 md:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-heroicon-o-academic-cap class="w-8 md:w-10 h-8 md:h-10 text-gray-400" />
                    </div>
                    <p class="text-gray-500 text-base md:text-lg">Belum ada jalur pendaftaran tersedia</p>
                </div>
            @endforelse
        </div>
    </div>
</section>