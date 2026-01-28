<div>
    <livewire:components.landing.hero-spmb />
    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">
        <livewire:components.landing.jalur-pendaftaran-section />
        <livewire:components.landing.alur-pendaftaran-section />
        <livewire:components.landing.requirement />
        <livewire:components.landing.information-section />
        <livewire:components.landing.alumni-section />

        @php
        $badgeText = 'Bergabunglah Bersama Kami';
        $title = 'Mulai Perjalanan Anda di <span class="hidden sm:inline"><br></span> <span class="text-lime-400 font-semibold">LEMDIKLAT</span> Taruna Nusantara Indonesia';
        $titleHighlight = 'LEMDIKLAT';
        $description = 'Raih masa depan cemerlang dengan pendidikan berbasis karakter dan kedisiplinan, pendidik profesional, dan fasilitas terbaik di SMA Taruna Nusantara Indonesia dan SMK Taruna Nusantara Jaya.';
        $primaryButtonText = 'Daftar Sekarang';
        $primaryButtonUrl = 'login';
        $secondaryButtonText = 'Hubungi Kami';
        $whatsappNumber = '6281321019569';
        @endphp

        <section id="cta" class="relative overflow-hidden bg-gradient-to-br from-lime-600 via-lime-700 to-emerald-800 rounded-3xl">
            <div class="relative z-10 px-6 py-16 sm:px-12 lg:px-16 lg:py-20">
                <div class="mx-auto max-w-4xl text-center">
                    {{-- Badge --}}
                    <x-atoms.badge
                        :text="$badgeText"
                        variant="white"
                        size="md"
                        class="mb-6 inline-block shadow-lg" />

                    {{-- Title --}}
                    <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-6">
                        {!! $title !!}
                    </h2>

                    {{-- Description --}}
                    <x-atoms.description
                        size="md"
                        mdSize="lg"
                        align="center"
                        class="text-white/90 mb-8 max-w-2xl mx-auto leading-relaxed">
                        {{ $description }}
                    </x-atoms.description>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                        <x-atoms.button
                            variant="success"
                            theme="light"
                            size="lg"
                            rounded="lg"
                            shadow="lg"
                            heroicon="arrow-right"
                            iconPosition="right"
                            onclick="window.location.href='{{ $primaryButtonUrl }}'">
                            {{ $primaryButtonText }}
                        </x-atoms.button>

                        <x-atoms.button
                            variant="outline"
                            theme="light"
                            size="lg"
                            rounded="lg"
                            heroicon="phone"
                            class="w-full sm:w-auto"
                            onclick="window.open('https://wa.me/{{ $whatsappNumber }}?text=' + encodeURIComponent('Halo, saya ingin menanyakan informasi tentang SPMB. Mohon informasinya ya 🙏'), '_blank')">
                            {{ $secondaryButtonText }}
                        </x-atoms.button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>