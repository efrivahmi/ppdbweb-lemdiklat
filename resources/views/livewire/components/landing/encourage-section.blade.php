<section class="lg:mx-auto lg:max-w-7xl lg:px-0 relative overflow-hidden rounded-xl lg:rounded-3xl mt-6 lg:mt-13">
    <!-- Background Gradients -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-900 via-lime-700 to-lime-500"></div>
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/camouflage.png')]"></div>
    
    <div class="max-w-7xl mx-auto px-3 md:px-6 py-6 md:py-12 relative z-10">
        <!-- Header -->
        <div class="text-center mb-6 md:mb-12">
            <h2 class="text-xl md:text-3xl lg:text-5xl font-extrabold tracking-tight mb-2 md:mb-4 leading-tight">
                <span class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                    Mengapa Memilih
                </span>
                <br>
                <span class="bg-gradient-to-r from-yellow-400 to-amber-300 bg-clip-text text-transparent">
                    Lemdiklat Taruna Nusantara?
                </span>
            </h2>
            <p class="text-xs md:text-base lg:text-lg text-gray-300 max-w-3xl mx-auto leading-relaxed mt-3 md:mt-4">
                Bergabunglah dengan lembaga pendidikan dan pelatihan yang telah <span class="text-yellow-400 font-bold">mencetak ribuan pemimpin</span> berkualitas untuk Indonesia.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
            @foreach($advantages as $index => $advantage)
                <div class="bg-white/5 backdrop-blur-sm rounded-lg md:rounded-2xl p-4 md:p-6 shadow-md hover:bg-white/10 transition-all duration-300 hover:-translate-y-1">
                    <!-- Icon Box -->
                    <div class="w-12 h-12 md:w-16 md:h-16 flex-shrink-0 rounded-lg md:rounded-xl bg-gradient-to-br from-yellow-400 to-amber-500 flex items-center justify-center shadow-lg mb-3 md:mb-4">
                        <x-dynamic-component 
                            :component="'heroicon-o-' . $advantage['icon']" 
                            class="w-6 h-6 md:w-8 md:h-8 text-slate-900"
                        />
                    </div>

                    <!-- Content -->
                    <div>
                        <h3 class="text-white font-bold text-sm md:text-lg lg:text-xl mb-2 leading-tight">
                            {{ $advantage['title'] }}
                        </h3>
                        <p class="text-gray-300 text-xs md:text-sm lg:text-base leading-relaxed">
                            {{ $advantage['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>