<section class="py-20 bg-gradient-to-b from-zinc-50 via-lime-50/30 to-white relative overflow-hidden">
    {{-- Artistic Background Elements --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-lime-300/20 rounded-full blur-3xl pointer-events-none opacity-50 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none opacity-50"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16" x-data="{ shown: false }" x-intersect="shown = true">
            <div :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'" class="transition-all duration-700 ease-out">
                <x-atoms.badge
                    text="Eksplorasi Sekolah"
                    variant="lime"
                    size="sm"
                    class="mb-6 shadow-sm ring-1 ring-lime-200/50" />
                
                <h2 class="text-3xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-zinc-900 via-zinc-700 to-zinc-900 mb-6 tracking-tight">
                    Kenali Lebih Dalam <br>
                    <span class="text-lime-600 underline decoration-wavy decoration-lime-300 decoration-2 underline-offset-4">Keunggulan Kami</span>
                </h2>

                <p class="text-zinc-600 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto">
                    Menyelami identitas, visi, dan fasilitas unggulan yang menjadikan kami pilihan terbaik untuk masa depan pendidikan putra-putri Anda.
                </p>
            </div>
        </div>

        {{-- Dynamic Grid Content --}}
        <div class="{{ count($items) < 3 ? 'flex flex-wrap justify-center gap-8' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8' }}">
            @foreach($items as $index => $item)
            <div x-data="{ hover: false }" 
                 @mouseenter="hover = true" 
                 @mouseleave="hover = false"
                 class="group relative bg-white rounded-3xl p-8 transition-all duration-500 hover:-translate-y-2 border border-zinc-100 hover:border-lime-300 shadow-sm hover:shadow-2xl hover:shadow-lime-500/10 {{ count($items) < 3 ? 'w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1rem)] max-w-lg' : '' }}">
                
                {{-- Card Background Gradient Hover --}}
                <div class="absolute inset-0 bg-gradient-to-br from-lime-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>

                <div class="relative z-10">
                    {{-- Icon Container --}}
                    <div class="mb-8 relative inline-block">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-lime-100 to-emerald-100 text-lime-700 flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-lime-500/20">
                            <i class="{{ $item['icon'] }} text-3xl transition-transform duration-500 group-hover:scale-110"></i>
                        </div>
                        {{-- Decorative Dot --}}
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-lime-400 rounded-full border-2 border-white animate-bounce-slow"></div>
                    </div>

                    <h3 class="text-2xl font-bold text-zinc-900 mb-4 group-hover:text-lime-700 transition-colors">
                        {{ $item['title'] }}
                    </h3>
                    
                    <p class="text-zinc-500 leading-relaxed mb-8 min-h-[48px]">
                        {{ $item['desc'] }}
                    </p>

                    <a href="{{ $item['url'] }}" 
                       class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-zinc-400 group-hover:text-lime-600 transition-colors pb-1 border-b-2 border-transparent group-hover:border-lime-500">
                        <span>Selengkapnya</span>
                        <x-heroicon-m-arrow-right class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>
            @endforeach
            

        </div>
    </div>

    {{-- Custom Animation Styles (Inline for simplicity, or could be in CSS) --}}
    <style>
        .animate-bounce-slow { animation: bounce 3s infinite; }
        @keyframes bounce {
            0%, 100% { transform: translateY(-5%); }
            50% { transform: translateY(5%); }
        }
    </style>
</section>
