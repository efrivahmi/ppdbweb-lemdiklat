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
                    <div class="group bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                        {{-- Image --}}
                        <div class="relative h-64 md:h-80 overflow-hidden">
                            @if ($alumni->image)
                                <img src="{{ asset('storage/' . $alumni->image) }}"
                                     alt="{{ $alumni->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-lime-500 to-lime-700 flex items-center justify-center">
                                    <x-heroicon-o-user class="w-24 h-24 text-white/50" />
                                </div>
                            @endif

                            {{-- Badge --}}
                            <div class="absolute top-3 left-3 md:top-4 md:left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-lime-500/90 text-white backdrop-blur-sm shadow-md">
                                    <x-heroicon-o-academic-cap class="w-3 h-3 mr-1" />
                                    {{ $alumni->jurusan->nama ?? 'Jurusan' }}
                                </span>
                            </div>

                            {{-- Year badge --}}
                            <div class="absolute top-3 right-3 md:top-4 md:right-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-white/90 text-gray-700 backdrop-blur-sm shadow-md">
                                    {{ $alumni->tahun_lulus }}
                                </span>
                            </div>
                        </div>

                        {{-- Content below image --}}
                        <div class="p-5 md:p-6">
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 leading-tight">
                                {{ $alumni->name }}
                            </h3>
                            
                            @if($alumni->desc)
                                <div class="relative">
                                    <svg class="absolute -top-1 -left-1 w-5 h-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 pl-5 italic">
                                        "{{ $alumni->desc }}"
                                    </p>
                                </div>
                            @endif
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