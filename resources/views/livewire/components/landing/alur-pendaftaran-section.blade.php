<section class="lg:mx-auto lg:max-w-7xl px-4 lg:px-0 relative overflow-hidden rounded-2xl lg:rounded-3xl mt-8 lg:mt-13">
    <div class="absolute inset-0 bg-gradient-to-br from-green-900 via-lime-700 to-lime-500"></div>
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/camouflage.png')]"></div>
    
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-12 relative z-10">
        <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center gap-4 md:gap-6 mb-8 md:mb-12">
            <img src="{{ asset('assets/logo.png') }}" 
                 alt="Logo" 
                 class="w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 object-contain">
            
            <div class="text-center lg:text-left">
                <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold tracking-tight mb-2 md:mb-4">
                    <span class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                        Alur Pendaftaran
                    </span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-amber-300 bg-clip-text text-transparent">
                        Lemdiklat Taruna Nusantara Indonesia
                    </span>
                </h2>
                <p class="text-sm md:text-base lg:text-lg text-gray-300 max-w-2xl">
                    Ikuti setiap langkah dengan <span class="text-yellow-400 font-bold">disiplin dan ketelitian</span>.
                    Perjalanan menuju cita-cita dimulai dari langkah pertama yang tepat.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($steps as $index => $step)
                <div class="flex flex-col items-center text-center relative bg-white/5 backdrop-blur-sm rounded-xl md:rounded-2xl px-4 md:px-6 py-4 md:py-6 shadow-md hover:bg-white/10 transition-all duration-300">
                    <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 text-slate-900 font-extrabold text-lg md:text-xl shadow-lg mb-3 md:mb-4">
                        {{ $index + 1 }}
                    </div>
                    
                    <h3 class="text-base md:text-lg lg:text-xl font-bold text-yellow-400 mb-2">
                        {{ $step['title'] }}
                    </h3>
                    
                    <p class="text-gray-300 text-xs md:text-sm leading-relaxed">
                        {{ $step['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8 md:mt-12 lg:mt-16">
            <a href="spmb#cta"
               class="inline-flex items-center gap-2 md:gap-3 px-6 md:px-8 py-3 md:py-4 rounded-lg md:rounded-xl font-bold text-sm md:text-base text-slate-900
                      bg-gradient-to-r from-yellow-400 via-yellow-500 to-amber-500
                      shadow-lg hover:scale-105 transition-transform duration-300">
                Mulai Pendaftaran
                <x-heroicon-o-arrow-right class="w-4 h-4 md:w-5 md:h-5" />
            </a>
        </div>
    </div>
</section>