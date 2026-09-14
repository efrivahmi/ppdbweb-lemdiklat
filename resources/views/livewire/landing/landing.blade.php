<div>
    <livewire:components.landing.hero-section />

    <div class="relative z-10 bg-zinc-50 shadow-[0_-20px_50px_rgba(0,0,0,0.5)]">
        {{-- Video Sambutan Section - Cinematic Edition --}}
        @if($localVideo)
        <section class="relative w-full h-screen min-h-[600px] overflow-hidden flex items-center justify-center bg-black"
                 x-data="{ hasInteracted: false }" 
                 x-init="$watch('hasInteracted', value => { if(value) { $refs.heroVideo.muted = false; $refs.heroVideo.currentTime = 0; $refs.heroVideo.play(); } })">
                 
            {{-- Cinematic Background Video --}}
            <video 
                x-ref="heroVideo"
                class="absolute inset-0 w-full h-full object-cover"
                autoplay 
                muted 
                loop 
                playsinline>
                <source src="{{ asset('storage/' . $localVideo['path']) }}" type="video/mp4">
            </video>

            {{-- Gradient Overlays for Readability --}}
            <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-black/20 to-black/90 pointer-events-none transition-opacity duration-1000" :class="hasInteracted ? 'opacity-80' : 'opacity-100'"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/20 to-transparent pointer-events-none transition-opacity duration-1000 w-2/3" :class="hasInteracted ? 'opacity-40' : 'opacity-100'"></div>
            
            {{-- Interactive Play Button Overlay (Centered) --}}
            <div class="absolute inset-0 z-20 flex flex-col items-center justify-center transition-all duration-700"
                 :class="hasInteracted ? 'opacity-0 scale-125 pointer-events-none' : 'opacity-100 scale-100'"
                 @click="hasInteracted = true">
                
                <button class="group/btn flex flex-col items-center gap-6 focus:outline-none cursor-pointer transform hover:scale-105 transition-all duration-500">
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-white/10 backdrop-blur-md rounded-full border-2 border-white/20 flex items-center justify-center shadow-[0_0_40px_rgba(0,0,0,0.5)] group-hover/btn:shadow-[0_0_60px_rgba(255,255,255,0.3)] group-hover/btn:bg-white/20 group-hover/btn:border-white/40 transition-all">
                        <svg class="w-10 h-10 md:w-14 md:h-14 text-white ml-2 drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-3 bg-black/50 backdrop-blur-md px-6 py-2.5 rounded-full border border-white/10 shadow-xl group-hover/btn:bg-black/60 transition-colors">
                        <svg class="w-5 h-5 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                        <span class="text-white font-bold tracking-widest uppercase text-sm md:text-base">Tonton dengan Suara</span>
                    </div>
                </button>
            </div>

            {{-- Text Content (Bottom Left) --}}
            <div class="absolute bottom-0 left-0 w-full p-6 pb-12 md:p-16 lg:p-24 z-10 pointer-events-none">
                <div class="max-w-4xl transition-all duration-1000 transform pointer-events-auto" :class="hasInteracted ? 'opacity-40 hover:opacity-100 translate-y-4 hover:translate-y-0' : 'opacity-100 translate-y-0'">
                    {{-- Badge --}}
                    <div class="inline-block px-4 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/20 mb-5">
                        <span class="text-xs md:text-sm font-bold text-lime-400 uppercase tracking-widest">
                            Seputar Sekolah
                        </span>
                    </div>
                    
                    {{-- Title --}}
                    <h2 class="text-4xl md:text-5xl lg:text-7xl font-black text-white tracking-tight leading-[1.1] mb-6 drop-shadow-[0_4px_10px_rgba(0,0,0,0.8)]">
                        {{ $localVideo['title'] }}
                    </h2>
                    
                    {{-- Description --}}
                    @if($localVideo['description'])
                    <div class="relative pl-6">
                        <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-lime-400 to-emerald-500 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.8)]"></div>
                        <p class="text-lg md:text-xl text-gray-200 leading-relaxed font-medium drop-shadow-lg max-w-2xl">
                            {{ $localVideo['description'] }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        <livewire:components.landing.stat-section />
    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">
        <livewire:components.landing.news-section />
    </div>
        
    {{-- New Explore School Section --}}
    <livewire:components.landing.explore-school-section />

    {{-- SPMB Promo Section --}}
    <x-landing.spmb-section />

    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">
        <livewire:components.landing.encourage-section />
        <livewire:components.landing.achivement-section />
    </div>

    {{-- Location Section --}}
    <x-landing.location-section />
        
    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">
        <!-- gallery dan ke jalur pendaftaran -->
        <livewire:components.landing.link-photo-section />
        <livewire:components.landing.link-youtube />
        <livewire:components.landing.gallery-section />
    </div>

    {{-- FAQ Section --}}
    <livewire:components.landing.faq-section />

    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">
        @props([
        'badgeText' => 'Pendidikan Calon Penerus Bangsa',
        'title' => 'Siap Memulai Pendidikan Berkualitas?',
        'titleHighlight' => 'Berkualitas',
        'description' => 'Jadilah bagian dari keluarga besar kami dan wujudkan masa depan gemilang bersama pendidik profesional dan fasilitas terbaik.',
        'primaryButtonText' => 'Jelajahi Profil Sekolah',
        'primaryButtonUrl' => 'profile',
        'secondaryButtonText' => 'Daftar Sekarang!',
        'secondaryButtonUrl' => 'spmb#cta',
        ])

        <section class="relative overflow-hidden bg-gradient-to-br from-lime-600 via-lime-700 to-emerald-800 rounded-3xl">
            {{-- Content --}}
            <div class="relative z-10 px-6 py-16 sm:px-10 lg:px-16 lg:py-20 text-center">
                <div class="mx-auto max-w-4xl">
                    {{-- Badge --}}
                    <x-atoms.badge
                        :text="$badgeText"
                        variant="white"
                        size="md"
                        class="mb-6 inline-block shadow-lg" />

                    {{-- Title --}}
                    <x-atoms.title
                        :text="$title"
                        :highlight="$titleHighlight"
                        size="3xl"
                        mdSize="4xl"
                        align="center"
                        color="white"
                        class="mb-6 leading-tight" />

                    {{-- Description --}}
                    <x-atoms.description
                        size="md"
                        mdSize="lg"
                        align="center"
                        color="white/90"
                        class="mb-10 max-w-2xl mx-auto leading-relaxed">
                        {{ $description }}
                    </x-atoms.description>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        {{-- Primary Button --}}
                        <x-atoms.button
                            variant="success"
                            theme="light"
                            size="lg"
                            rounded="lg"
                            shadow="lg"
                            iconPosition="right"
                            class="w-full sm:w-auto"
                            onclick="window.location.href='{{ $primaryButtonUrl }}'">
                            {{ $primaryButtonText }}
                        </x-atoms.button>

                        {{-- Secondary Button --}}
                        <x-atoms.button
                            variant="outline"
                            theme="light"
                            size="lg"
                            rounded="lg"
                            heroicon="arrow-right"
                            class="w-full sm:w-auto"
                            onclick="window.location.href='{{ $secondaryButtonUrl }}'">
                            {{ $secondaryButtonText }}
                        </x-atoms.button>
                    </div>
                </div>
            </div>

            {{-- Background overlay for depth --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-black/20 via-transparent to-white/10 pointer-events-none"></div>
        </section>

    </div>
    </div>

</div>