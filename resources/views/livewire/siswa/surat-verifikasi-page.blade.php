<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Dokumen Verifikasi</h1>
        <p class="mt-2 text-gray-600">Unduh bukti verifikasi pendaftaran Anda.</p>
    </div>

    @if($canDownloadVerifikasiPDF)
        <!-- SUCCESS STATE -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-blue-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <span class="text-white font-bold text-lg flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        TERVERIFIKASI
                    </span>
                    <span class="bg-blue-500 text-blue-100 text-xs px-2 py-1 rounded">Semua Data Lengkap</span>
                </div>
            </div>
            
            <div class="p-8 md:p-12 text-center md:text-left flex flex-col md:flex-row items-center gap-8">
                <div class="flex-shrink-0 bg-blue-50 rounded-full p-6">
                    <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Dokumen Siap Diunduh</h3>
                    <p class="text-gray-600 mb-6">Seluruh persyaratan administratif telah terpenuhi. Silakan unduh dokumen ini sebagai bukti sah untuk pendaftaran ulang.</p>
                    
                    <a href="{{ route('siswa.pdf.verifikasi') }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition">
                        <svg class="w-5 h-5 mr-3 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF Verifikasi
                    </a>
                </div>
            </div>
        </div>

    @else
        <!-- PENDING STATE -->
        <div class="bg-white rounded-lg shadow-lg border-l-4 border-orange-500 overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Verifikasi Belum Selesai</h3>
                        <p class="text-gray-600 mb-4">Mohon lengkapi persyaratan berikut agar dokumen verifikasi dapat diterbitkan:</p>
                        
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-100">
                            <ul class="space-y-3">
                                @foreach($missingItems as $item)
                                <li class="flex items-center gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="font-medium">{{ $item }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                Kembali ke Dashboard <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <div class="text-center mt-8 text-xs text-gray-400">
        ID Referensi: #VER-{{ Auth::id() }}
    </div>

</div>
