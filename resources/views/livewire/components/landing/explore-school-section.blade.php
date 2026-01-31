<section class="py-16 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16">
            <x-atoms.badge
                text="Jelajahi Kami"
                variant="lime"
                size="sm"
                class="mb-4" />
            
            <x-atoms.title
                text="Kenali Lebih Dekat"
                highlight="Sekolah Kami"
                size="3xl"
                mdSize="4xl"
                align="center"
                class="text-zinc-900 mb-4" />

            <x-atoms.description
                size="md"
                align="center"
                class="text-zinc-600">
                Temukan berbagai informasi menarik mengenai profil, jenjang pendidikan, hingga fasilitas unggulan yang kami tawarkan.
            </x-atoms.description>
        </div>

        {{-- Grid Content --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($items as $item)
            <div class="group relative bg-white p-6 rounded-2xl border border-zinc-100 shadow-sm hover:shadow-xl hover:border-lime-200 transition-all duration-300">
                
                <div class="flex items-start justify-between mb-6">
                    <div class="p-3 rounded-xl bg-{{ $item['color'] }}-50 text-{{ $item['color'] }}-600 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $item['icon'] }} text-2xl"></i>
                    </div>
                    
                    <a href="{{ $item['url'] }}" class="text-zinc-400 hover:text-{{ $item['color'] }}-600 transition-colors">
                        <x-heroicon-m-arrow-right class="w-5 h-5 -rotate-45 group-hover:rotate-0 transition-transform duration-300" />
                    </a>
                </div>

                <h3 class="text-xl font-bold text-zinc-900 mb-3 group-hover:text-{{ $item['color'] }}-700 transition-colors">
                    {{ $item['title'] }}
                </h3>
                
                <p class="text-sm text-zinc-600 leading-relaxed mb-6">
                    {{ $item['desc'] }}
                </p>

                <a href="{{ $item['url'] }}" 
                   class="inline-flex items-center text-sm font-semibold text-{{ $item['color'] }}-600 hover:text-{{ $item['color'] }}-700 transition-colors">
                    Selengkapnya
                    <x-heroicon-m-chevron-right class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" />
                </a>

                {{-- Hover Gradient Overlay --}}
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-{{ $item['color'] }}-500 to-{{ $item['color'] }}-300 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-b-2xl"></div>
            </div>
            @endforeach
            
            {{-- Call to Action Card --}}
            <div class="group relative bg-zinc-900 p-8 rounded-2xl shadow-lg flex flex-col justify-center items-center text-center overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold text-white mb-2">Masih Penasaran?</h3>
                    <p class="text-sm text-zinc-400 mb-6">Tanyakan langsung kepada admin kami via WhatsApp.</p>
                    
                    <x-atoms.button
                        variant="primary"
                        theme="dark"
                        size="md"
                        rounded="lg"
                        iconPosition="right"
                        class="w-full justify-center"
                        onclick="window.open('https://wa.me/628123456789', '_blank')">
                        Hubungi Admin
                        <x-heroicon-o-chat-bubble-left-right class="w-4 h-4 ml-2" />
                    </x-atoms.button>
                </div>
                
                {{-- Decorative circles --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-lime-500/20 rounded-full blur-2xl group-hover:bg-lime-500/30 transition-all"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition-all"></div>
            </div>
        </div>
    </div>
</section>
