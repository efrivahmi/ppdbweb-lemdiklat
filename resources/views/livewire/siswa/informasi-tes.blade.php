<div>
    <x-atoms.breadcrumb current-path="Informasi Tes" />

    @if(count($jalurData) > 0)
        @foreach($jalurData as $data)
            <x-atoms.card className="mt-4" padding="p-0">
                {{-- Header Card dengan Gradient --}}
                <div class="bg-gradient-to-r from-emerald-500 to-lime-600 text-white p-6 rounded-t-3xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-atoms.title 
                                :text="$data['jalur']->nama" 
                                size="lg" 
                                class="text-white mb-2"
                            />
                            <div class="space-y-1">
                                @foreach($data['program_studi'] as $program)
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-lime-300 rounded-full"></div>
                                        <x-atoms.description class="text-lime-100">
                                            {{ $program }}
                                        </x-atoms.description>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right">
                            {{-- Status gabungan --}}
                            @if(in_array('diterima', $data['status']))
                                <x-atoms.badge 
                                    text="Diterima" 
                                    variant="emerald" 
                                    size="sm"
                                    class="mb-2"
                                />
                            @elseif(in_array('ditolak', $data['status']))
                                <x-atoms.badge 
                                    text="Ditolak" 
                                    variant="danger" 
                                    size="sm"
                                    class="mb-2"
                                />
                            @else
                                <x-atoms.badge 
                                    text="Pending" 
                                    variant="gold" 
                                    size="sm"
                                    class="mb-2"
                                />
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Content Area --}}
                <div class="p-6">
                    @if(count($data['tes_informasi']) > 0)
                        <div class="mb-6">
                            <x-atoms.title 
                                text="Informasi Tes untuk Jalur {{ $data['jalur']->nama }}" 
                                size="md"
                                class="mb-3 flex items-center"
                            >
                                <i class="ri-file-text-line mr-2 text-lime-600"></i>
                                Informasi Tes untuk Jalur {{ $data['jalur']->nama }}
                            </x-atoms.title>
                            <x-atoms.description class="mb-4">
                                {{ $data['jalur']->deskripsi }}
                            </x-atoms.description>
                        </div>

                        {{-- Grid Informasi Tes --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            @foreach($data['tes_informasi'] as $index => $tes)
                                <x-atoms.card 
                                    className="border border-gray-200 hover:shadow-md transition-shadow duration-200" 
                                    padding="p-4"
                                    border="false"
                                >
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-lime-100 rounded-full flex items-center justify-center">
                                                <span class="text-lime-600 font-semibold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <x-atoms.title 
                                                :text="$tes->nama_tes" 
                                                size="sm" 
                                                class="mb-2"
                                            />
                                            <x-atoms.description size="sm" class="leading-relaxed">
                                                {{ $tes->deskripsi }}
                                            </x-atoms.description>
                                        </div>
                                    </div>
                                </x-atoms.card>
                            @endforeach
                        </div>

                        {{-- Info Box --}}
                        <x-atoms.card className="bg-lime-50 border border-lime-200" padding="p-4">
                            <div class="flex items-start flex-col lg:flex-row space-x-3">
                                <i class="ri-information-line text-lime-600 text-xl mt-0.5 flex-shrink-0"></i>
                                <div>
                                    <x-atoms.title 
                                        text="Catatan Penting" 
                                        size="sm" 
                                        class="text-lime-900 mb-2"
                                    />
                                    <div class="text-sm text-lime-800 space-y-1">
                                        <x-atoms.description size="sm" color="lime-800" class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>Pastikan Anda mempersiapkan diri dengan baik untuk setiap jenis tes</span>
                                        </x-atoms.description>
                                        <x-atoms.description size="sm" color="lime-800" class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>Pastikan untuk mengisi jawaban dengan benar</span>
                                        </x-atoms.description>
                                        <x-atoms.description size="sm" color="lime-800" class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>Tinjau sosial media SMA Taruna Nusantara Indonesia dan SMK Taruna Nusantara Jaya untuk mengetahui informasi lebih lanjut tentang pelaksanaan tes</span>
                                        </x-atoms.description>
                                        <x-atoms.description size="sm" color="lime-800" class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>Hindari kecurangan saat mengerjakan test</span>
                                        </x-atoms.description>
                                        <x-atoms.description size="sm" color="lime-800" class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>Selamat mengerjakan test</span>
                                        </x-atoms.description>
                                    </div>
                                </div>
                            
                            @if ($gelombangActive)
                @if (!$gelombangActive->isUjianAktif())
                    <div class="p-4 mt-2">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">
                            📅 Jadwal Ujian
                        </h2>

                        <div class="space-y-2">
                            <p class="text-gray-600">
                                Ujian dimulai:
                                <span class="font-medium text-lime-600">
                                    {{ $gelombangActive->ujian_mulai->format('d M Y H:i') }}
                                </span>
                            </p>
                            <p class="text-gray-600">
                                Berakhir:
                                <span class="font-medium text-lime-600">
                                    {{ $gelombangActive->ujian_selesai->format('d M Y H:i') }}
                                </span>
                            </p>
                        </div>
                    </div>

                @else
                    <p class="text-green-600 font-semibold">✅ Sudah bisa dimulai</p>
                @endif
            @else
                <p class="text-red-500 font-medium">⚠️ Belum ada gelombang aktif saat ini</p>
            @endif
            </div>
                        </x-atoms.card>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="ri-file-search-line text-2xl text-gray-400"></i>
                            </div>
                            <x-atoms.title 
                                text="Belum Ada Informasi Tes" 
                                size="lg" 
                                align="center"
                                class="text-gray-600 mb-2"
                            />
                            <x-atoms.description align="center" color="gray-500">
                                Informasi tes untuk jalur {{ $data['jalur']->nama }} belum tersedia.
                            </x-atoms.description>
                        </div>
                    @endif
                </div>
            </x-atoms.card>
        @endforeach
    @else
        <x-atoms.card className="mt-4">
            <div class="items-center flex flex-col py-12">
                <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="ri-file-list-3-line text-3xl text-gray-400"></i>
                </div>
                <x-atoms.title 
                    text="Belum Ada Pendaftaran" 
                    size="xl" 
                    align="center"
                    class="text-gray-700 mb-2"
                />
                <x-atoms.description align="center" color="gray-500" class="mb-6 max-w-md mx-auto">
                    Anda belum mendaftar pada jalur pendaftaran manapun. Silakan lengkapi pendaftaran Anda terlebih dahulu.
                </x-atoms.description>
                <x-atoms.button
                    variant="success"
                    heroicon="plus"
                    onclick="window.location.href='{{ route('siswa.pendaftaran') }}'"
                >
                    Daftar Sekarang
                </x-atoms.button>
            </div>
        </x-atoms.card>
    @endif
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush