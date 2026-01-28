<section class="">
    <div class="max-w-7xl mx-auto px-3 md:px-6 py-6 md:py-12">
        <div class="mb-6 md:mb-10">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-transparent bg-gradient-to-r from-lime-600 to-lime-500 bg-clip-text mb-2">
                Informasi Penting
            </h2>
            <div class="h-1 w-20 md:w-24 bg-gradient-to-r from-yellow-400 to-amber-500 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
            @foreach($informations as $info)
                <a href="{{ $info['url'] }}" 
                   class="group relative overflow-hidden rounded-xl md:rounded-2xl bg-gradient-to-br from-lime-600 to-lime-500 p-5 md:p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/camouflage.png')]"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/0 to-amber-500/0 group-hover:from-yellow-400/20 group-hover:to-amber-500/20 transition-all duration-300"></div>
                    
                    <div class="relative z-10 flex items-center gap-3 md:gap-4">
                        <div class="w-12 h-12 md:w-14 md:h-14 flex-shrink-0 rounded-full bg-white shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <x-dynamic-component 
                                :component="'heroicon-o-' . $info['icon']" 
                                class="w-6 h-6 md:w-7 md:h-7 text-lime-600"
                            />
                        </div>

                        <div class="flex-1">
                            <h3 class="text-white font-bold text-sm md:text-base lg:text-lg leading-tight group-hover:text-yellow-300 transition-colors duration-300">
                                {{ $info['title'] }}
                            </h3>
                        </div>

                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 to-amber-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                </a>
            @endforeach
        </div>
    </div>
</section>