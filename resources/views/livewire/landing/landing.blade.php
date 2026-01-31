<div>
    <livewire:components.landing.hero-section />
    <livewire:components.landing.stat-section />
    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">
        <livewire:components.landing.news-section />
        
        {{-- New Explore School Section --}}
        <livewire:components.landing.explore-school-section />

        <livewire:components.landing.encourage-section />
        <livewire:components.landing.achivement-section />
        
        {{-- Location Section --}}
        <livewire:components.landing.location-section />

        <!-- gallery dan ke jalur pendaftaran -->
        <livewire:components.landing.link-photo-section />
        <livewire:components.landing.link-youtube />
        <livewire:components.landing.gallery-section />
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
                        class="text-white mb-6 leading-tight" />

                    {{-- Description --}}
                    <x-atoms.description
                        size="md"
                        mdSize="lg"
                        align="center"
                        class="text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
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