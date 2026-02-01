<div class="overflow-x-hidden">
    <!-- Hero Section -->
    <section class="relative w-full overflow-hidden">
        <div class="relative w-full flex justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-green-800 via-green-900 to-emerald-900"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

        <div class="relative z-10 py-20 text-center">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="mb-6">
                    <img src="{{ asset('assets/logo.png') }}"
                         alt="Logo SMK"
                         class="w-32 h-32 mx-auto">
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">
                    <span class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                        {{ $heroData['title_prefix'] ?? 'SMK' }}
                    </span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-amber-300 bg-clip-text text-transparent">
                        {{ $heroData['title_main'] ?? 'Taruna Nusantara Jaya' }}
                    </span>
                </h1>
                <p class="text-sm md:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed mb-6">
                    {!! $heroData['subtitle'] ?? 'Sekolah Menengah Kejuruan <span class="text-yellow-400 font-bold">Siap Kerja dan Berkarakter</span>' !!}
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
                            text="NPSN: {{ $identityData['npsn'] ?? '87654321' }}"
                            variant="white"
                            size="md"
                        />
                        <x-atoms.badge
                            text="Berdiri: {{ $identityData['year_founded'] ?? '2015' }}"
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
                        variant="green"
                        size="md"
                        class="mb-4"
                    />
                    <x-atoms.title
                        :text="$identityData['school_name'] ?? 'SMK Taruna Nusantara Jaya'"
                        highlight="Taruna Nusantara"
                        size="2xl"
                        mdSize="3xl"
                        class="lg:text-4xl leading-tight mb-3"
                    />
                    <p class="text-gray-600 text-base md:text-lg max-w-2xl mx-auto">
                        {!! $heroData['subtitle'] ?? 'Sekolah Menengah Kejuruan <span class="text-green-600 font-semibold">Siap Kerja dan Berkarakter</span>' !!}
                    </p>
                </div>

                <!-- Info Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    <div class="flex items-start gap-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-building-library class="w-6 h-6 text-green-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Nama Sekolah</p>
                            <p class="text-sm text-gray-600">{{ $identityData['school_name'] ?? 'SMK Taruna Nusantara Jaya' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-identification class="w-6 h-6 text-emerald-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">NPSN</p>
                            <p class="text-sm text-gray-600">{{ $identityData['npsn'] ?? '87654321' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-trophy class="w-6 h-6 text-green-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Akreditasi</p>
                            <p class="text-sm text-gray-600">{{ $identityData['accreditation'] ?? 'A (Unggul)' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-calendar class="w-6 h-6 text-emerald-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Tahun Berdiri</p>
                            <p class="text-sm text-gray-600">{{ $identityData['year_founded'] ?? '2012' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-book-open class="w-6 h-6 text-green-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Kurikulum</p>
                            <p class="text-sm text-gray-600">{{ $identityData['curriculum'] ?? 'Kurikulum Merdeka SMK' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 rounded-r-xl p-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-heroicon-o-briefcase class="w-6 h-6 text-emerald-600" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Mitra Industri</p>
                            <p class="text-sm text-gray-600">{{ $identityData['students_teachers'] ?? '50+ Mitra Industri' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($identityData['description'] ?? null)
                <div class="mt-8 bg-gradient-to-r from-green-50 via-emerald-50 to-green-50 rounded-xl p-6 text-center">
                    <p class="text-gray-700 text-base md:text-lg leading-relaxed">
                        {{ $identityData['description'] }}
                    </p>
                </div>
                @endif
            </x-atoms.card>
        </section>

        <!-- Program Keahlian -->
        <x-atoms.card>
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <div class="bg-amber-100 p-5 rounded-xl shadow-md">
                        <x-heroicon-o-wrench-screwdriver class="w-10 h-10 md:w-12 md:h-12 text-amber-600" />
                    </div>
                    <div>
                        <x-atoms.title
                            text="Kompetensi Keahlian"
                            size="2xl"
                            mdSize="3xl"
                        />
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @php
                        $defaultKompetensi = [
                            [
                                'name' => 'Teknik Komputer Jaringan & Telekomunikasi',
                                'code' => 'TKJT',
                                'color' => 'blue',
                                'description' => 'Mempelajari rancang bangun infrastruktur jaringan, administrasi server, keamanan siber, dan teknologi komunikasi data terkini.',
                                'subjects' => ['Instalasi Fiber Optic & Wireless', 'Administrasi Server & Cloud', 'Network Security (Keamanan Jaringan)', 'Internet of Things (IoT)'],
                                'career' => 'Network Engineer, IT Support, Cyber Security Analyst'
                            ],
                            [
                                'name' => 'Teknik Kendaraan Ringan Otomotif',
                                'code' => 'TKRO',
                                'color' => 'red',
                                'description' => 'Kompetensi keahlian yang berfokus pada perbaikan, perawatan, dan diagnosa kerusakan kendaraan ringan roda empat.',
                                'subjects' => ['Pemeliharaan Mesin Kendaraan', 'Sistem Sasis & Pemindah Tenaga', 'Kelistrikan Otomotif & AC', 'Engine Management System (EFI)'],
                                'career' => 'Mekanik Senior, Service Advisor, Wirausaha Bengkel'
                            ],
                            [
                                'name' => 'Manajemen Perkantoran & Layanan Bisnis',
                                'code' => 'MPLB',
                                'color' => 'purple',
                                'description' => 'Membekali siswa dengan kemampuan manajemen informasi, layanan pelanggan prima, dan pengelolaan administrasi berbasis digital.',
                                'subjects' => ['Teknologi Perkantoran Digital', 'Layanan Pelanggan (Service Excellence)', 'Manajemen Kearsipan Elektronik', 'Public Relations & Komunikasi'],
                                'career' => 'Sekretaris, Customer Service, Staff Administrasi'
                            ],
                        ];
                        $kompetensiList = $academicData['kompetensi'] ?? $defaultKompetensi;
                    @endphp
                    @foreach($kompetensiList as $komp)
                        @php
                            $color = $komp['color'] ?? 'blue';
                            $colorClasses = match($color) {
                                'red' => ['bg' => 'from-red-50 to-red-100', 'border' => 'border-red-300', 'header' => 'bg-red-600', 'icon' => 'text-red-600', 'career' => 'bg-red-50 border-red-200'],
                                'purple' => ['bg' => 'from-purple-50 to-purple-100', 'border' => 'border-purple-300', 'header' => 'bg-purple-600', 'icon' => 'text-purple-600', 'career' => 'bg-purple-50 border-purple-200'],
                                default => ['bg' => 'from-blue-50 to-blue-100', 'border' => 'border-blue-300', 'header' => 'bg-blue-600', 'icon' => 'text-blue-600', 'career' => 'bg-blue-50 border-blue-200'],
                            };
                        @endphp
                        <div class="bg-gradient-to-br {{ $colorClasses['bg'] }} rounded-xl border-2 {{ $colorClasses['border'] }} overflow-hidden hover:shadow-2xl transition-all">
                            <div class="{{ $colorClasses['header'] }} text-white p-6">
                                @switch($color)
                                    @case('red')
                                        <x-heroicon-o-wrench class="w-12 h-12 mb-3" />
                                        @break
                                    @case('purple')
                                        <x-heroicon-o-briefcase class="w-12 h-12 mb-3" />
                                        @break
                                    @default
                                        <x-heroicon-o-computer-desktop class="w-12 h-12 mb-3" />
                                @endswitch
                                <x-atoms.title :text="$komp['name'] ?? ''" size="xl" mdSize="2xl" class="text-white" />
                                <x-atoms.badge :text="$komp['code'] ?? ''" variant="white" size="sm" class="mt-2" />
                            </div>
                            <div class="p-6">
                                <x-atoms.description class="mb-4">
                                    {{ $komp['description'] ?? '' }}
                                </x-atoms.description>
                                <x-atoms.title text="Kompetensi yang Dipelajari:" size="md" class="mb-3" />
                                <div class="space-y-2 mb-4">
                                    @foreach($komp['subjects'] ?? [] as $subject)
                                        <x-atoms.info-item :text="$subject">
                                            <x-slot name="iconSlot">
                                                <x-heroicon-o-check-circle class="w-5 h-5 {{ $colorClasses['icon'] }}" />
                                            </x-slot>
                                        </x-atoms.info-item>
                                    @endforeach
                                </div>
                                <div class="{{ $colorClasses['career'] }} border rounded-lg p-3">
                                    <x-atoms.description size="xs">
                                        <strong>Prospek Karir:</strong> {{ $komp['career'] ?? '' }}
                                    </x-atoms.description>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-atoms.card>

        <!-- Kesiswaan & Kegiatan -->
        <x-atoms.card>
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <div class="bg-teal-100 p-5 rounded-xl shadow-md">
                        <x-heroicon-o-user-group class="w-10 h-10 md:w-12 md:h-12 text-teal-600" />
                    </div>
                    <div>
                        <x-atoms.title
                            text="Kesiswaan & Kegiatan"
                            size="2xl"
                            mdSize="3xl"
                        />
                    </div>
                </div>

                <!-- Praktik Kerja Industri -->
                <div>
                    <x-atoms.title
                        text="Praktik Kerja Industri (PKL)"
                        size="xl"
                        mdSize="2xl"
                        class="mb-4"
                    />
                    <div class="bg-orange-50 border-2 border-orange-200 rounded-xl p-6 md:p-8">
                        <x-atoms.description class="mb-6 text-base leading-relaxed">
                            {{ $activityData['pkl_description'] ?? 'Program PKL selama 3 bulan di perusahaan mitra untuk memberikan pengalaman kerja nyata kepada siswa. Siswa akan bekerja langsung di industri dan mendapatkan pembimbingan dari praktisi profesional.' }}
                        </x-atoms.description>
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="bg-white rounded-xl p-6 border-2 border-orange-200 hover:shadow-lg transition-shadow">
                                <x-atoms.title text="Durasi" size="lg" class="mb-3" />
                                <x-atoms.description size="md" class="font-semibold text-orange-600">{{ $activityData['pkl_duration'] ?? '3 bulan' }}</x-atoms.description>
                            </div>
                            <div class="bg-white rounded-xl p-6 border-2 border-orange-200 hover:shadow-lg transition-shadow">
                                <x-atoms.title text="Waktu" size="lg" class="mb-3" />
                                <x-atoms.description size="md" class="font-semibold text-orange-600">{{ $activityData['pkl_timing'] ?? 'Kelas XII' }}</x-atoms.description>
                            </div>
                            <div class="bg-white rounded-xl p-6 border-2 border-orange-200 hover:shadow-lg transition-shadow">
                                <x-atoms.title text="Perusahaan" size="lg" class="mb-3" />
                                <x-atoms.description size="md" class="font-semibold text-orange-600">{{ $activityData['pkl_partners'] ?? '50+ Mitra' }}</x-atoms.description>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-atoms.card>

        <!-- Seragam Sekolah -->
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
                            ['title' => 'PDL Hijau', 'image' => null],
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
                        :text="$ctaData['title'] ?? 'Raih Masa Depan Cerah Bersama SMK Taruna Nusantara Jaya'"
                        size="3xl"
                        mdSize="4xl"
                        align="center"
                        color="white"
                        class="mb-6 leading-tight"
                    />

                    <x-atoms.description
                        size="md"
                        mdSize="lg"
                        align="center"
                        color="white"
                        class="mb-10 max-w-2xl mx-auto leading-relaxed"
                    >
                        {{ $ctaData['description'] ?? 'Bergabunglah dengan SMK yang siap mengantarkanmu ke dunia kerja atau wirausaha sukses' }}
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
