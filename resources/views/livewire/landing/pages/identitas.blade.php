<div class="h-full bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-br from-purple-500 via-purple-700 to-indigo-900 h-92 shadow-sm">
        <div class="flex items-center justify-center flex-col h-full space-y-2">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-identification class="w-12 h-12 text-white" />
            </div>
            <x-atoms.title text="Identitas Sekolah" size="3xl" color="white" />
            <x-atoms.description color="white" class="text-center px-4">
                Informasi lengkap dan resmi Lemdiklat Taruna Nusantara Indonesia
            </x-atoms.description>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto p-6 md:p-8">
        <article class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8 md:p-12">
                <!-- Logo dan Nama -->
                <section class="mb-10 text-center">
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('assets/logo.png') }}"
                             alt="Logo Lemdiklat Taruna Nusantara Indonesia"
                             class="w-32 h-32 rounded-full shadow-lg">
                    </div>
                    <x-atoms.title text="Lemdiklat Taruna Nusantara Indonesia" size="3xl" class="text-gray-900 mb-2" />
                    <x-atoms.description class="text-gray-600 text-lg">
                        SMA Taruna Nusantara Indonesia | SMK Taruna Nusantara Jaya
                    </x-atoms.description>
                </section>

                <!-- Data Sekolah -->
                <section class="mb-10">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-purple-600 mr-4"></div>
                        <x-atoms.title text="Data Sekolah" size="2xl" class="text-gray-900" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Sekolah -->
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <x-atoms.description class="text-gray-500 text-sm mb-1">Nama Lembaga</x-atoms.description>
                            <x-atoms.title text="Lemdiklat Taruna Nusantara Indonesia" size="base" class="text-gray-900" />
                        </div>

                        <!-- NPSN -->
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <x-atoms.description class="text-gray-500 text-sm mb-1">NPSN</x-atoms.description>
                            <x-atoms.title text="12345678" size="base" class="text-gray-900" />
                        </div>

                        <!-- Status -->
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <x-atoms.description class="text-gray-500 text-sm mb-1">Status Sekolah</x-atoms.description>
                            <x-atoms.title text="Swasta" size="base" class="text-gray-900" />
                        </div>

                        <!-- Akreditasi -->
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <x-atoms.description class="text-gray-500 text-sm mb-1">Akreditasi</x-atoms.description>
                            <x-atoms.title text="A (Unggul)" size="base" class="text-gray-900" />
                        </div>

                        <!-- Bentuk Pendidikan -->
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <x-atoms.description class="text-gray-500 text-sm mb-1">Bentuk Pendidikan</x-atoms.description>
                            <x-atoms.title text="SMA & SMK" size="base" class="text-gray-900" />
                        </div>

                        <!-- Tahun Berdiri -->
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <x-atoms.description class="text-gray-500 text-sm mb-1">Tahun Berdiri</x-atoms.description>
                            <x-atoms.title text="2010" size="base" class="text-gray-900" />
                        </div>
                    </div>
                </section>

                <!-- Kontak & Alamat -->
                <section class="mb-10">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-purple-600 mr-4"></div>
                        <x-atoms.title text="Kontak & Alamat" size="2xl" class="text-gray-900" />
                    </div>

                    <div class="space-y-4">
                        <!-- Alamat -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4 mt-1">
                                <x-heroicon-o-map-pin class="w-6 h-6 text-purple-600" />
                            </div>
                            <div class="flex-1">
                                <x-atoms.title text="Alamat" size="sm" class="text-gray-700 mb-1" />
                                <x-atoms.description class="text-gray-600">
                                    Jl. Pendidikan No. 123, Kecamatan Sukamaju, Kabupaten Bandung, Jawa Barat 40123
                                </x-atoms.description>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4 mt-1">
                                <x-heroicon-o-phone class="w-6 h-6 text-purple-600" />
                            </div>
                            <div class="flex-1">
                                <x-atoms.title text="Telepon" size="sm" class="text-gray-700 mb-1" />
                                <x-atoms.description class="text-gray-600">
                                    (022) 1234-5678
                                </x-atoms.description>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4 mt-1">
                                <x-heroicon-o-envelope class="w-6 h-6 text-purple-600" />
                            </div>
                            <div class="flex-1">
                                <x-atoms.title text="Email" size="sm" class="text-gray-700 mb-1" />
                                <x-atoms.description class="text-gray-600">
                                    info@tarunanusantara.sch.id
                                </x-atoms.description>
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4 mt-1">
                                <x-heroicon-o-globe-alt class="w-6 h-6 text-purple-600" />
                            </div>
                            <div class="flex-1">
                                <x-atoms.title text="Website" size="sm" class="text-gray-700 mb-1" />
                                <x-atoms.description class="text-gray-600">
                                    www.tarunanusantara.sch.id
                                </x-atoms.description>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Program Pendidikan -->
                <section class="mb-10">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-purple-600 mr-4"></div>
                        <x-atoms.title text="Program Pendidikan" size="2xl" class="text-gray-900" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- SMA -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center mb-4">
                                <x-heroicon-o-academic-cap class="w-8 h-8 text-purple-600 mr-3" />
                                <x-atoms.title text="SMA Taruna Nusantara Indonesia" size="lg" class="text-gray-900" />
                            </div>
                            <x-atoms.description class="text-gray-700 mb-3">
                                Program pendidikan tingkat menengah atas dengan kurikulum nasional dan pendidikan karakter berbasis kedisiplinan.
                            </x-atoms.description>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-2 h-2 bg-purple-600 rounded-full mr-2"></div>
                                    Program IPA & IPS
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-2 h-2 bg-purple-600 rounded-full mr-2"></div>
                                    Program Tahfidz
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-2 h-2 bg-purple-600 rounded-full mr-2"></div>
                                    Program Kepemimpinan
                                </div>
                            </div>
                        </div>

                        <!-- SMK -->
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200">
                            <div class="flex items-center mb-4">
                                <x-heroicon-o-wrench-screwdriver class="w-8 h-8 text-indigo-600 mr-3" />
                                <x-atoms.title text="SMK Taruna Nusantara Jaya" size="lg" class="text-gray-900" />
                            </div>
                            <x-atoms.description class="text-gray-700 mb-3">
                                Program pendidikan kejuruan dengan berbagai kompetensi keahlian yang siap memasuki dunia kerja dan industri.
                            </x-atoms.description>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></div>
                                    Teknik Komputer & Jaringan
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></div>
                                    Akuntansi & Keuangan
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></div>
                                    Administrasi Perkantoran
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Kepala Sekolah -->
                <section>
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-purple-600 mr-4"></div>
                        <x-atoms.title text="Kepala Sekolah" size="2xl" class="text-gray-900" />
                    </div>

                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-8 border border-purple-200">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 bg-purple-200 rounded-full flex items-center justify-center">
                                    <x-heroicon-o-user class="w-16 h-16 text-purple-600" />
                                </div>
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <x-atoms.title text="Dr. H. Ahmad Suryadi, M.Pd" size="xl" class="text-gray-900 mb-2" />
                                <x-atoms.description class="text-purple-700 font-semibold mb-4">
                                    Kepala Sekolah
                                </x-atoms.description>
                                <x-atoms.description class="text-gray-700 leading-relaxed">
                                    Memimpin Lemdiklat Taruna Nusantara Indonesia sejak tahun 2018, dengan dedikasi penuh untuk meningkatkan kualitas pendidikan dan membentuk karakter siswa yang unggul dan berintegritas.
                                </x-atoms.description>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </article>
    </div>
</div>
