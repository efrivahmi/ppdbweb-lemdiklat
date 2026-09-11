<div>
    <livewire:components.landing.hero-section />

    @if($heroVideo)
    <section class="w-full h-[60vh] bg-black relative">
        <iframe 
            class="w-full h-full object-cover" 
            src="{{ str_contains($heroVideo->embed_url, '?') ? $heroVideo->embed_url . '&autoplay=1&mute=1' : $heroVideo->embed_url . '?autoplay=1&mute=1' }}" 
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            allowfullscreen>
        </iframe>
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

    {{-- Video Intro Popup --}}
    @if($introVideo)
        <div 
            x-data="{ show: false }" 
            x-init="
                if (!sessionStorage.getItem('intro_video_seen')) {
                    setTimeout(() => show = true, 500);
                }
            "
            x-show="show"
            style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true"
        >
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="show" @click.away="show = false; sessionStorage.setItem('intro_video_seen', 'true')" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    {{ $introVideo->title }}
                                </h3>
                                <div class="mt-2 w-full aspect-video">
                                    <iframe class="w-full h-full rounded" src="{{ $introVideo->embed_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="show = false; sessionStorage.setItem('intro_video_seen', 'true')" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-lime-600 text-base font-medium text-white hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Masuk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>