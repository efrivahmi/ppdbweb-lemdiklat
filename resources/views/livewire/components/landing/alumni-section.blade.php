<section class="">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 md:mb-12">
            <x-atoms.title 
                text="Alumni Terpilih"
                highlight="Terpilih"
                size="xl"
                mdSize="3xl"
                align="center"
                className="mb-2 md:mb-3"
            />
            
            <div class="w-20 md:w-24 h-1 bg-lime-600 mx-auto mb-3 md:mb-4"></div>
            
            <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
                Bangga dengan pencapaian alumni kami yang telah sukses di berbagai bidang
            </p>
        </div>

        @if($alumnis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 max-w-6xl mx-auto">
                @foreach ($alumnis as $alumni)
                    <div class="group relative h-80 md:h-96 rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        @if ($alumni->image)
                            <img src="{{ asset('storage/' . $alumni->image) }}"
                                 alt="{{ $alumni->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-lime-500 to-lime-700 flex items-center justify-center">
                                <x-heroicon-o-user class="w-24 h-24 text-white/50" />
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>

                        <div class="absolute inset-0 p-4 md:p-6 flex flex-col justify-end">
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-lime-500/90 text-white backdrop-blur-sm">
                                    <x-heroicon-o-academic-cap class="w-3 h-3 mr-1" />
                                    {{ $alumni->jurusan->nama ?? 'Jurusan' }}
                                </span>
                            </div>

                            <h3 class="text-xl md:text-2xl font-bold text-white mb-2 transform group-hover:translate-y-[-4px] transition-transform duration-300">
                                {{ $alumni->name }}
                            </h3>
                            
                            <p class="text-white/90 text-xs md:text-sm leading-relaxed line-clamp-3 mb-3">
                                {{ $alumni->desc }}
                            </p>

                            <div class="flex items-center text-lime-400 text-xs md:text-sm font-medium">
                                <x-heroicon-o-calendar class="w-4 h-4 mr-2" />
                                <span>Lulus {{ $alumni->tahun_lulus }}</span>
                            </div>
                        </div>

                        <div class="absolute top-3 right-3 md:top-4 md:right-4 w-10 h-10 md:w-12 md:h-12 bg-amber-500/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg">
                            <x-heroicon-o-star class="w-5 h-5 md:w-6 md:h-6 text-white" />
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8 md:mt-12">
                <a href="{{ route('alumni') }}" 
                   class="inline-flex items-center gap-2 md:gap-3 px-6 md:px-8 py-3 md:py-4 bg-lime-600 hover:bg-lime-700 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <span>Lihat Semua Alumni</span>
                    <x-heroicon-o-arrow-right class="w-4 h-4 md:w-5 md:h-5" />
                </a>
            </div>
        @else
            <div class="text-center py-12 md:py-16">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-user-group class="w-10 h-10 md:w-12 md:h-12 text-gray-400" />
                </div>
                <x-atoms.title 
                    text="Belum Ada Alumni Terpilih" 
                    size="md"
                    mdSize="lg"
                    align="center"
                    class="text-gray-600 mb-2" 
                />
                <p class="text-sm md:text-base text-gray-500">
                    Alumni terpilih akan segera ditampilkan di sini
                </p>
            </div>
        @endif
    </div>
</section>