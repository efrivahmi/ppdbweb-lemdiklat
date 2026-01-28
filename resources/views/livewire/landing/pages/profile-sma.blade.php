<div class="overflow-x-hidden">
    <!-- Hero Section -->
    <section class="relative w-full overflow-hidden">
        <div class="relative w-full flex justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-800 via-blue-900 to-indigo-900"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

        <div class="relative z-10 py-20 text-center">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="mb-6">
                    <img src="{{ asset('assets/logo.png') }}"
                         alt="Logo SMA"
                         class="w-32 h-32 mx-auto">
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">
                    <span class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                        {{ $heroData['title_prefix'] ?? 'SMA' }}
                    </span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-amber-300 bg-clip-text text-transparent">
                        {{ $heroData['title_main'] ?? 'Taruna Nusantara Indonesia' }}
                    </span>
                </h1>
                <p class="text-sm md:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed mb-6">
                    {!! $heroData['subtitle'] ?? 'Pendidikan Menengah Atas <span class="text-yellow-400 font-bold">Berkarakter dan Berprestasi</span>' !!}
                </p>
                <div class="flex flex-wrap justify-center gap-4 text-sm md:text-base">
                    @if(!empty($heroData['badges']))
                        @foreach($heroData['badges'] as $badge)
                            @if($badge)
                                <x-atoms.badge
                                    :text="$badge"
                                    variant="white"
                                    size="md"
                                />
                            @endif
                        @endforeach
                    @else
                        <x-atoms.badge
                            text="Akreditasi: {{ $identityData['accreditation'] ?? 'A' }}"
                            variant="white"
                            size="md"
                        />
                        <x-atoms.badge
                            text="NPSN: {{ $identityData['npsn'] ?? '12345678' }}"
                            variant="white"
                            size="md"
                        />
                        <x-atoms.badge
                            text="Berdiri: {{ $identityData['year_founded'] ?? '2010' }}"
                            variant="white"
                            size="md"
                        />
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">

        <!-- Identitas Sekolah -->
        <section class="relative" x-data>
            <x-atoms.card className="p-6 md:p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <x-atoms.badge
                        text="Profil Sekolah"
                        variant="blue"
                        size="md"
                        class="mb-4"
                    />
                    <x-atoms.title
                        :text="$identityData['school_name'] ?? 'SMA Taruna Nusantara Indonesia'"
                        highlight="Taruna Nusantara"
                        size="2xl"
                        mdSize="3xl"
                        class="lg:text-4xl leading-tight mb-3"
                    />
                    <p class="text-gray-600 text-base md:text-lg max-w-2xl mx-auto">
                        {!! $heroData['subtitle'] ?? 'Pendidikan Menengah Atas <span class="text-blue-600 font-semibold">Berkarakter dan Berprestasi</span>' !!}
                    </p>
                </div>

                <!-- Info Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    <div class="flex items-start gap-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-building-library class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Nama Sekolah</p>
                            <p class="text-sm text-gray-600">{{ $identityData['school_name'] ?? 'SMA Taruna Nusantara Indonesia' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-l-4 border-indigo-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-identification class="w-6 h-6 text-indigo-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">NPSN</p>
                            <p class="text-sm text-gray-600">{{ $identityData['npsn'] ?? '12345678' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-trophy class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Akreditasi</p>
                            <p class="text-sm text-gray-600">{{ $identityData['accreditation'] ?? 'A (Unggul)' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-l-4 border-indigo-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-calendar class="w-6 h-6 text-indigo-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Tahun Berdiri</p>
                            <p class="text-sm text-gray-600">{{ $identityData['year_founded'] ?? '2010' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-book-open class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Kurikulum</p>
                            <p class="text-sm text-gray-600">{{ $identityData['curriculum'] ?? 'Kurikulum Merdeka' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-l-4 border-indigo-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-users class="w-6 h-6 text-indigo-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Siswa & Pendidik</p>
                            <p class="text-sm text-gray-600">{{ $identityData['students_teachers'] ?? '500+ Siswa Aktif | 50+ Tenaga Pendidik' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($identityData['description'] ?? null)
                <div class="mt-8 bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 rounded-xl p-6 text-center">
                    <p class="text-gray-700 text-base md:text-lg leading-relaxed">
                        {{ $identityData['description'] }}
                    </p>
                </div>
                @endif
            </x-atoms.card>
        </section>

        <!-- Akademik -->
        <x-atoms.card>
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <div class="bg-amber-100 p-4 rounded-lg">
                        <x-heroicon-o-academic-cap class="w-8 h-8 text-amber-600" />
                    </div>
                    <div>
                        <x-atoms.title
                            text="Akademik"
                            size="2xl"
                            mdSize="3xl"
                        />
                    </div>
                </div>

                <!-- Kurikulum -->
                <div>
                    <x-atoms.title
                        text="Kurikulum Sekolah"
                        size="xl"
                        mdSize="2xl"
                        class="mb-4"
                    />
                    <x-atoms.description class="mb-6 leading-relaxed">
                        {{ $academicData['kurikulum_description'] ?? 'SMA Taruna Nusantara Indonesia menerapkan Kurikulum Merdeka yang diperkaya dengan muatan lokal dan pendidikan karakter. Pembelajaran dirancang untuk mengembangkan kompetensi siswa secara holistik.' }}
                    </x-atoms.description>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
                            <x-atoms.title text="Program IPA (Sains)" size="lg" class="mb-4" />
                            <div class="space-y-2">
                                @foreach($academicData['program_ipa'] ?? ['Matematika Lanjut', 'Fisika', 'Kimia', 'Biologi'] as $subject)
                                    <x-atoms.info-item :text="$subject">
                                        <x-slot name="iconSlot">
                                            <x-heroicon-o-check-circle class="w-5 h-5 text-amber-600" />
                                        </x-slot>
                                    </x-atoms.info-item>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
                            <x-atoms.title text="Program IPS (Sosial)" size="lg" class="mb-4" />
                            <div class="space-y-2">
                                @foreach($academicData['program_ips'] ?? ['Geografi', 'Sejarah', 'Ekonomi', 'Sosiologi'] as $subject)
                                    <x-atoms.info-item :text="$subject">
                                        <x-slot name="iconSlot">
                                            <x-heroicon-o-check-circle class="w-5 h-5 text-amber-600" />
                                        </x-slot>
                                    </x-atoms.info-item>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    {{-- Additional Academic Programs (Dynamic) --}}
                    @if(!empty($academicData['academic_programs']))
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                            @foreach($academicData['academic_programs'] as $program)
                                @if(!empty($program['title']))
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                        <x-atoms.title :text="$program['title']" size="lg" class="mb-4" />
                                        <div class="space-y-2">
                                            @foreach($program['subjects'] ?? [] as $subject)
                                                @if($subject)
                                                    <x-atoms.info-item :text="$subject">
                                                        <x-slot name="iconSlot">
                                                            <x-heroicon-o-check-circle class="w-5 h-5 text-green-600" />
                                                        </x-slot>
                                                    </x-atoms.info-item>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Program Unggulan -->
                <div>
                    <x-atoms.title
                        text="Program Unggulan"
                        size="xl"
                        mdSize="2xl"
                        class="mb-6"
                    />
                    <div class="grid md:grid-cols-3 gap-6">
                        @php
                            $defaultPrograms = [
                                ['title' => 'Tahfidz Al-Quran', 'description' => 'Program menghafal Al-Quran dengan target minimal 5 juz selama 3 tahun.', 'icon' => 'book-open'],
                                ['title' => 'Kepemimpinan', 'description' => 'Pembinaan karakter dan jiwa kepemimpinan melalui berbagai kegiatan.', 'icon' => 'user-group'],
                                ['title' => 'Bahasa Asing', 'description' => 'Program intensif Bahasa Inggris dan Bahasa Arab untuk komunikasi global.', 'icon' => 'globe-alt'],
                            ];
                            $programs = $academicData['program_unggulan'] ?? $defaultPrograms;
                        @endphp
                        @foreach($programs as $program)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div class="bg-blue-600 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                                    @switch($program['icon'] ?? 'star')
                                        @case('book-open')
                                            <x-heroicon-o-book-open class="w-6 h-6 text-white" />
                                            @break
                                        @case('user-group')
                                            <x-heroicon-o-user-group class="w-6 h-6 text-white" />
                                            @break
                                        @case('globe-alt')
                                            <x-heroicon-o-globe-alt class="w-6 h-6 text-white" />
                                            @break
                                        @default
                                            <x-heroicon-o-star class="w-6 h-6 text-white" />
                                    @endswitch
                                </div>
                                <x-atoms.title :text="$program['title'] ?? ''" size="lg" class="mb-2" />
                                <x-atoms.description size="sm">
                                    {{ $program['description'] ?? '' }}
                                </x-atoms.description>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-atoms.card>

        <!-- Kesiswaan (Seragam) -->
        <x-atoms.card>
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 p-4 rounded-lg">
                        <x-heroicon-o-user-group class="w-8 h-8 text-green-600" />
                    </div>
                    <div>
                        <x-atoms.title
                            text="Seragam Sekolah"
                            size="2xl"
                            mdSize="3xl"
                        />
                    </div>
                </div>

                <div class="grid md:grid-cols-4 gap-4 md:gap-6">
                    @php
                        $defaultUniforms = [
                            ['title' => 'PDH Putih Abu', 'image' => null],
                            ['title' => 'PDL Biru', 'image' => null],
                            ['title' => 'Pramuka', 'image' => null],
                            ['title' => 'Olahraga', 'image' => null],
                        ];
                        $uniforms = $uniformData['items'] ?? $defaultUniforms;
                    @endphp
                    @foreach($uniforms as $uniform)
                        <div class="group relative h-64 md:h-80 rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                            @if(isset($uniform['image']) && $uniform['image'])
                                <img src="{{ asset('storage/' . $uniform['image']) }}"
                                     alt="{{ $uniform['title'] ?? 'Seragam' }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     onerror="this.onerror=null; this.src='https://placehold.co/400x600/16A34A/FFFFFF/png?text={{ urlencode($uniform['title'] ?? 'Seragam') }}&font=raleway'">
                            @else
                                <img src="https://placehold.co/400x600/16A34A/FFFFFF/png?text={{ urlencode($uniform['title'] ?? 'Seragam') }}&font=raleway"
                                     alt="{{ $uniform['title'] ?? 'Seragam' }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                            <div class="absolute inset-0 p-4 md:p-6 flex flex-col justify-end">
                                <h3 class="text-xl md:text-2xl font-bold text-white mb-2 transform group-hover:translate-y-[-4px] transition-transform duration-300">
                                    {{ $uniform['title'] ?? 'Seragam' }}
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-atoms.card>

        <!-- CTA Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-lime-600 via-lime-700 to-emerald-800 rounded-3xl">
            <div class="relative z-10 px-6 py-16 sm:px-10 lg:px-16 lg:py-20 text-center">
                <div class="mx-auto max-w-4xl">
                    <x-atoms.badge
                        :text="$ctaData['badge_text'] ?? 'Bergabunglah Bersama Kami'"
                        variant="white"
                        size="md"
                        class="mb-6 inline-block shadow-lg"
                    />

                    <x-atoms.title
                        :text="$ctaData['title'] ?? 'Bergabunglah dengan SMA Taruna Nusantara Indonesia'"
                        size="3xl"
                        mdSize="4xl"
                        align="center"
                        class="text-white mb-6 leading-tight"
                    />

                    <x-atoms.description
                        size="md"
                        mdSize="lg"
                        align="center"
                        class="text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed"
                    >
                        {{ $ctaData['description'] ?? 'Wujudkan impian menjadi siswa berprestasi dengan karakter yang kuat dan disiplin tinggi' }}
                    </x-atoms.description>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <x-atoms.button
                            variant="success"
                            theme="light"
                            size="lg"
                            rounded="lg"
                            shadow="lg"
                            heroicon="arrow-right"
                            iconPosition="right"
                            class="w-full sm:w-auto"
                            onclick="window.location.href='{{ $ctaData['primary_button_url'] ?? '/login' }}'"
                        >
                            {{ $ctaData['primary_button_text'] ?? 'Daftar Sekarang' }}
                        </x-atoms.button>

                        <x-atoms.button
                            variant="outline"
                            theme="light"
                            size="lg"
                            rounded="lg"
                            heroicon="phone"
                            class="w-full sm:w-auto"
                            onclick="window.location.href='{{ $ctaData['secondary_button_url'] ?? '/spmb' }}'"
                        >
                            {{ $ctaData['secondary_button_text'] ?? 'Info Pendaftaran' }}
                        </x-atoms.button>
                    </div>
                </div>
            </div>

            <div class="absolute inset-0 bg-gradient-to-tr from-black/20 via-transparent to-white/10 pointer-events-none"></div>
        </section>
    </div>
</div>
