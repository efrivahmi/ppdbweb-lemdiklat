<div>
    <!-- Hero Section -->
    <section class="relative w-full overflow-hidden">
        <div class="relative w-full flex justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-800 via-indigo-900 to-purple-900"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

        <div class="relative z-10 py-20 text-center">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="mb-6">
                    <img src="{{ asset('assets/logo.png') }}"
                         alt="Logo Lemdiklat"
                         class="w-32 h-32 mx-auto rounded-full shadow-2xl border-4 border-white">
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">
                    <span class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                        Lemdiklat
                    </span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-amber-300 bg-clip-text text-transparent">
                        Taruna Nusantara Indonesia
                    </span>
                </h1>
                <p class="text-sm md:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Yayasan Pendidikan <span class="text-yellow-400 font-bold">Berkarakter dan Berdisiplin</span>
                </p>
            </div>
        </div>
    </section>

    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">

        <!-- Identitas Yayasan -->
        <section class="relative" x-data>
            <x-atoms.card className="p-4 md:p-6">
                <div class="grid lg:grid-cols-2 gap-6 md:gap-12">
                    <!-- Foto Ketua Yayasan - Order 2 on mobile, 1 on desktop -->
                    <div class="relative order-2 lg:order-1" x-data>
                        <div class="relative">
                            <div class="relative rounded-xl md:rounded-2xl overflow-hidden shadow-lg md:shadow-2xl">
                                <div class="rounded-xl md:rounded-2xl overflow-hidden bg-gradient-to-br from-green-50 to-lime-50 h-64 md:h-96 lg:h-150 flex items-center justify-center">
                                    <!-- Border kuning-hijau TNI -->
                                    <div class="relative">
                                        <div class="absolute -inset-3 bg-gradient-to-br from-yellow-400 via-lime-400 to-green-500 rounded-full blur-md"></div>
                                        <div class="relative w-48 h-48 md:w-64 md:h-64 bg-gradient-to-br from-yellow-400 to-lime-500 rounded-full flex items-center justify-center shadow-2xl">
                                            <x-heroicon-o-user class="w-24 h-24 md:w-32 md:h-32 text-slate-900" />
                                        </div>
                                    </div>
                                </div>

                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent p-4 md:p-6">
                                    <div class="text-white">
                                        <x-atoms.title
                                            text="Drs. H. Bambang Suharto, M.M."
                                            size="md"
                                            mdSize="lg"
                                            class="text-white mb-1 md:mb-2"
                                        />
                                        <x-atoms.description
                                            size="xs"
                                            class="text-lime-200 flex items-center gap-2">
                                            <x-heroicon-o-star class="w-4 h-4 md:w-5 md:h-5" />
                                            Ketua Yayasan
                                        </x-atoms.description>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quote/Info Tambahan -->
                        <div class="bg-gradient-to-r from-green-50 to-lime-50 border-l-4 border-lime-600 rounded-r-lg md:rounded-r-xl p-4 md:p-6 mt-4 md:mt-6">
                            <div class="flex items-start gap-2 md:gap-3">
                                <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 md:w-6 md:h-6 text-lime-600 flex-shrink-0 mt-1" />
                                <div>
                                    <p class="text-gray-800 italic text-sm md:text-base lg:text-lg mb-2 leading-relaxed">
                                        "Pendidikan berkarakter adalah kunci membangun generasi pemimpin masa depan Indonesia"
                                    </p>
                                    <p class="text-lime-700 font-medium text-xs md:text-sm">
                                        — Ketua Yayasan Lemdiklat Taruna Nusantara Indonesia
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Identitas Yayasan - Order 1 on mobile, 2 on desktop -->
                    <div class="relative space-y-4 md:space-y-6 order-1 lg:order-2" x-data>
                        <!-- Header -->
                        <div class="space-y-2 md:space-y-3">
                            <x-atoms.badge
                                text="Identitas Yayasan"
                                variant="lime"
                                size="sm"
                            />

                            <x-atoms.title
                                text="Lemdiklat Taruna Nusantara Indonesia"
                                highlight="Taruna Nusantara"
                                size="xl"
                                mdSize="2xl"
                                class="lg:text-5xl leading-tight"
                            />
                        </div>

                        <!-- Subtitle -->
                        <div class="italic text-gray-700 text-sm md:text-base lg:text-lg font-medium">
                            Yayasan Pendidikan Berkarakter dan Berdisiplin
                        </div>

                        <!-- Info Items dengan border kuning-hijau -->
                        <div class="space-y-3 md:space-y-4 text-gray-600">
                            <div class="flex items-start gap-3 bg-gradient-to-r from-yellow-50 to-lime-50 border-l-4 border-yellow-500 rounded-r-lg p-3 md:p-4">
                                <x-heroicon-o-building-library class="w-5 h-5 md:w-6 md:h-6 text-yellow-600 flex-shrink-0 mt-0.5" />
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base">Nama Lembaga</p>
                                    <p class="text-xs md:text-sm text-gray-600">Lembaga Pendidikan dan Pelatihan Taruna Nusantara Indonesia</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gradient-to-r from-lime-50 to-green-50 border-l-4 border-lime-500 rounded-r-lg p-3 md:p-4">
                                <x-heroicon-o-academic-cap class="w-5 h-5 md:w-6 md:h-6 text-lime-600 flex-shrink-0 mt-0.5" />
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base">Status</p>
                                    <p class="text-xs md:text-sm text-gray-600">Yayasan Pendidikan</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gradient-to-r from-yellow-50 to-lime-50 border-l-4 border-yellow-500 rounded-r-lg p-3 md:p-4">
                                <x-heroicon-o-calendar class="w-5 h-5 md:w-6 md:h-6 text-yellow-600 flex-shrink-0 mt-0.5" />
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base">Tahun Berdiri</p>
                                    <p class="text-xs md:text-sm text-gray-600">2010</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gradient-to-r from-lime-50 to-green-50 border-l-4 border-lime-500 rounded-r-lg p-3 md:p-4">
                                <x-heroicon-o-map-pin class="w-5 h-5 md:w-6 md:h-6 text-lime-600 flex-shrink-0 mt-0.5" />
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base">Alamat</p>
                                    <p class="text-xs md:text-sm text-gray-600">Jl. Pendidikan No. 123, Kecamatan Sukamaju, Kabupaten Bandung, Jawa Barat 40123</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gradient-to-r from-yellow-50 to-lime-50 border-l-4 border-yellow-500 rounded-r-lg p-3 md:p-4">
                                <x-heroicon-o-phone class="w-5 h-5 md:w-6 md:h-6 text-yellow-600 flex-shrink-0 mt-0.5" />
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base">Telepon</p>
                                    <p class="text-xs md:text-sm text-gray-600">(022) 1234-5678</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gradient-to-r from-lime-50 to-green-50 border-l-4 border-lime-500 rounded-r-lg p-3 md:p-4">
                                <x-heroicon-o-envelope class="w-5 h-5 md:w-6 md:h-6 text-lime-600 flex-shrink-0 mt-0.5" />
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base">Email</p>
                                    <p class="text-xs md:text-sm text-gray-600">info@tarunanusantara.sch.id</p>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Tambahan -->
                        <div class="text-gray-700 font-medium text-sm md:text-base lg:text-lg">
                            Memimpin yayasan sejak tahun 2010 dengan dedikasi penuh untuk memajukan pendidikan Indonesia melalui pembentukan karakter dan kedisiplinan.
                        </div>
                    </div>
                </div>
            </x-atoms.card>
        </section>

        <!-- Institusi yang Dinaungi -->
        <section class="lg:mx-auto lg:max-w-7xl lg:px-0 relative overflow-hidden rounded-2xl lg:rounded-3xl">
            <div class="absolute inset-0 bg-gradient-to-br from-green-900 via-green-700 to-lime-600"></div>
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/camouflage.png')]"></div>

            <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-12 relative z-10">
                <div class="text-center mb-8 md:mb-12">
                    <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold tracking-tight mb-3 md:mb-4">
                        <span class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                            Institusi yang
                        </span>
                        <br>
                        <span class="bg-gradient-to-r from-yellow-400 to-lime-300 bg-clip-text text-transparent">
                            Dinaungi
                        </span>
                    </h2>
                    <p class="text-sm md:text-base lg:text-lg text-gray-300 max-w-2xl mx-auto">
                        Lembaga pendidikan di bawah naungan yayasan
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 md:gap-8">
                    <!-- SMA Card -->
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg hover:bg-white/10 transition-all duration-300 hover:-translate-y-1 border-2 border-yellow-400/30">
                        <div class="bg-gradient-to-br from-yellow-600 via-yellow-700 to-amber-800 p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <x-heroicon-o-academic-cap class="w-8 h-8 text-slate-900" />
                                </div>
                                <div>
                                    <h3 class="text-xl md:text-2xl font-bold text-white">SMA Taruna Nusantara Indonesia</h3>
                                    <div class="inline-block bg-yellow-400/30 border border-yellow-400/50 rounded-full px-3 py-1 mt-1">
                                        <span class="text-yellow-100 text-xs font-semibold">Pendidikan Menengah Atas</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-l-4 border-yellow-400">
                            <p class="text-gray-300 text-sm md:text-base mb-4 leading-relaxed">
                                Program pendidikan SMA dengan kurikulum nasional yang diperkaya dengan pendidikan karakter, kedisiplinan, dan kepemimpinan berbasis semi-militer.
                            </p>
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center gap-2 text-white text-sm">
                                    <div class="w-2 h-2 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full"></div>
                                    Program IPA & IPS
                                </div>
                                <div class="flex items-center gap-2 text-white text-sm">
                                    <div class="w-2 h-2 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full"></div>
                                    Program Tahfidz Al-Qur'an
                                </div>
                                <div class="flex items-center gap-2 text-white text-sm">
                                    <div class="w-2 h-2 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full"></div>
                                    Program Kepemimpinan
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- SMK Card -->
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg hover:bg-white/10 transition-all duration-300 hover:-translate-y-1 border-2 border-lime-400/30">
                        <div class="bg-gradient-to-br from-lime-600 via-green-700 to-green-800 p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-lime-300 to-lime-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <x-heroicon-o-wrench-screwdriver class="w-8 h-8 text-slate-900" />
                                </div>
                                <div>
                                    <h3 class="text-xl md:text-2xl font-bold text-white">SMK Taruna Nusantara Jaya</h3>
                                    <div class="inline-block bg-lime-400/30 border border-lime-400/50 rounded-full px-3 py-1 mt-1">
                                        <span class="text-lime-100 text-xs font-semibold">Pendidikan Menengah Kejuruan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-l-4 border-lime-400">
                            <p class="text-gray-300 text-sm md:text-base mb-4 leading-relaxed">
                                Program pendidikan SMK dengan berbagai kompetensi keahlian yang mempersiapkan siswa siap kerja dengan tetap menjunjung tinggi nilai-nilai karakter dan kedisiplinan.
                            </p>
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center gap-2 text-white text-sm">
                                    <div class="w-2 h-2 bg-gradient-to-r from-lime-400 to-lime-500 rounded-full"></div>
                                    Teknik Komputer & Jaringan
                                </div>
                                <div class="flex items-center gap-2 text-white text-sm">
                                    <div class="w-2 h-2 bg-gradient-to-r from-lime-400 to-lime-500 rounded-full"></div>
                                    Akuntansi & Keuangan
                                </div>
                                <div class="flex items-center gap-2 text-white text-sm">
                                    <div class="w-2 h-2 bg-gradient-to-r from-lime-400 to-lime-500 rounded-full"></div>
                                    Administrasi Perkantoran
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Nilai-nilai Yayasan -->
        <section class="relative overflow-hidden bg-gradient-to-br from-lime-600 via-lime-700 to-emerald-800 rounded-3xl">
            <div class="relative z-10 px-6 py-16 sm:px-12 lg:px-16 lg:py-20">
                <div class="mx-auto max-w-7xl">
                    <div class="text-center mb-8 md:mb-12">
                        <x-atoms.badge
                            text="Nilai-Nilai Kami"
                            variant="white"
                            size="md"
                            class="mb-6 inline-block shadow-lg" />

                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                            Nilai-Nilai <span class="text-yellow-400 font-semibold">Yayasan</span>
                        </h2>

                        <x-atoms.description
                            size="md"
                            mdSize="lg"
                            align="center"
                            class="text-white/90 mb-8 max-w-2xl mx-auto leading-relaxed">
                            Fondasi karakter yang membentuk generasi pemimpin masa depan Indonesia
                        </x-atoms.description>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center hover:bg-white/10 transition-all duration-300 hover:-translate-y-1 border border-white/10">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <x-heroicon-o-shield-check class="w-8 h-8 md:w-10 md:h-10 text-slate-900" />
                            </div>
                            <h3 class="text-lg md:text-xl font-bold text-white mb-2">Integritas</h3>
                            <p class="text-white/80 text-xs md:text-sm">Menjunjung tinggi kejujuran dan etika</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center hover:bg-white/10 transition-all duration-300 hover:-translate-y-1 border border-white/10">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <x-heroicon-o-star class="w-8 h-8 md:w-10 md:h-10 text-slate-900" />
                            </div>
                            <h3 class="text-lg md:text-xl font-bold text-white mb-2">Keunggulan</h3>
                            <p class="text-white/80 text-xs md:text-sm">Berusaha mencapai prestasi terbaik</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center hover:bg-white/10 transition-all duration-300 hover:-translate-y-1 border border-white/10">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <x-heroicon-o-users class="w-8 h-8 md:w-10 md:h-10 text-slate-900" />
                            </div>
                            <h3 class="text-lg md:text-xl font-bold text-white mb-2">Kerjasama</h3>
                            <p class="text-white/80 text-xs md:text-sm">Membangun kolaborasi yang solid</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center hover:bg-white/10 transition-all duration-300 hover:-translate-y-1 border border-white/10">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <x-heroicon-o-heart class="w-8 h-8 md:w-10 md:h-10 text-slate-900" />
                            </div>
                            <h3 class="text-lg md:text-xl font-bold text-white mb-2">Kepedulian</h3>
                            <p class="text-white/80 text-xs md:text-sm">Peduli terhadap sesama dan lingkungan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background overlay for depth -->
            <div class="absolute inset-0 bg-gradient-to-tr from-black/20 via-transparent to-white/10 pointer-events-none"></div>
        </section>

        <!-- CTA Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-lime-600 via-lime-700 to-emerald-800 rounded-3xl">
            <div class="relative z-10 px-6 py-16 sm:px-10 lg:px-16 lg:py-20 text-center">
                <div class="mx-auto max-w-4xl">
                    <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                        <span class="text-white text-sm font-medium">Bergabunglah Bersama Kami</span>
                    </div>

                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                        Wujudkan Pendidikan <span class="text-yellow-400">Berkualitas</span> untuk Generasi Masa Depan
                    </h2>

                    <p class="text-base md:text-lg text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Bergabunglah dengan keluarga besar Lemdiklat Taruna Nusantara Indonesia dan raih masa depan cemerlang dengan pendidikan berbasis karakter dan kedisiplinan.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="/login" class="inline-flex items-center gap-3 px-8 py-4 rounded-xl font-bold text-base text-slate-900 bg-gradient-to-r from-yellow-400 via-yellow-500 to-amber-500 shadow-lg hover:scale-105 transition-transform duration-300">
                            Daftar Sekarang
                            <x-heroicon-o-arrow-right class="w-5 h-5" />
                        </a>

                        <a href="/spmb" class="inline-flex items-center gap-3 px-8 py-4 rounded-xl font-bold text-base text-white border-2 border-white/30 bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all duration-300">
                            <x-heroicon-o-phone class="w-5 h-5" />
                            Info Pendaftaran
                        </a>
                    </div>
                </div>
            </div>

            <div class="absolute inset-0 bg-gradient-to-tr from-black/20 via-transparent to-white/10 pointer-events-none"></div>
        </section>
    </div>
</div>
