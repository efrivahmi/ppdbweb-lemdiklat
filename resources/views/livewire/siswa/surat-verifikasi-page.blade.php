<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-10 text-center space-y-4">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Dokumen Verifikasi</h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Unduh tanda bukti resmi bahwa seluruh persyaratan administratif pendaftaran Anda telah lengkap dan tervalidasi.
        </p>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative">
        <!-- Decoration Gradient -->
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

        <div class="p-8 md:p-12">
            @if($canDownloadVerifikasiPDF)
                <!-- Success State -->
                <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <!-- Visual Icon -->
                    <div class="flex-shrink-0 w-32 h-32 bg-blue-50 rounded-2xl flex items-center justify-center border border-blue-100 shadow-inner rotate-3 transition-transform hover:rotate-0">
                        <i class="ri-file-verified-fill text-6xl text-blue-600 drop-shadow-sm"></i>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 text-center md:text-left space-y-6">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 text-green-700 text-sm font-medium border border-green-200 mb-4">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                Status: Terverifikasi
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Dokumen Siap Diunduh</h2>
                            <p class="text-gray-600">Simpan dokumen ini sebagai bukti sah pendaftaran ulang.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                            <a href="{{ route('siswa.pdf.verifikasi') }}" 
                               target="_blank"
                               class="group inline-flex items-center justify-center gap-2.5 px-6 py-3.5 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-200 focus:ring-4 focus:ring-gray-100">
                                <span>Download PDF</span>
                                <i class="ri-download-line group-hover:translate-y-0.5 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Pending State -->
                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Left: Status -->
                    <div class="flex-1 space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center border border-orange-100 flex-shrink-0">
                                <i class="ri-history-line text-2xl text-orange-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-1">Verifikasi Belum Selesai</h3>
                                <p class="text-gray-500 leading-relaxed">
                                    Mohon lengkapi beberapa persyaratan berikut sebelum dokumen dapat diunduh.
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200/60">
                            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Persyaratan Tertunda</h4>
                            <ul class="space-y-3">
                                @foreach($missingItems as $item)
                                <li class="flex items-center gap-3 text-gray-700 bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
                                    <i class="ri-close-circle-fill text-red-500 text-lg"></i>
                                    <span class="font-medium">{{ $item }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Right: Action -->
                    <div class="md:w-72 bg-gray-900 rounded-xl p-8 text-center flex flex-col justify-center items-center text-gray-300">
                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mb-4 backdrop-blur-sm">
                             <i class="ri-arrow-right-up-line text-2xl text-white"></i>
                        </div>
                        <h4 class="text-white font-semibold mb-2">Lengkapi Data</h4>
                        <p class="text-sm mb-6">Kembali ke dashboard untuk melengkapi data pendaftaran.</p>
                        <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 text-white font-medium hover:text-blue-300 transition-colors">
                            Ke Dashboard <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Footer Info -->
        <div class="bg-gray-50 border-t border-gray-200 px-8 py-4 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500 gap-2">
            <span class="flex items-center gap-1.5"><i class="ri-shield-check-line"></i> Dokumen Resmi Lemdiklat</span>
            <span>ID Referensi: #VER-{{ Auth::id() }}-{{ date('Y') }}</span>
        </div>
    </div>
</div>
