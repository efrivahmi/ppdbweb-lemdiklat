<div class="space-y-6">
    <x-atoms.breadcrumb current-path="Surat Verifikasi" />

    <x-atoms.card>
        <div class="text-center py-8">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="ri-file-text-line text-blue-600 text-3xl"></i>
            </div>
            
            <x-atoms.title text="Surat Verifikasi Pendaftaran" size="xl" className="mb-2" />
            <x-atoms.description size="md" color="gray-600" className="max-w-xl mx-auto mb-8">
                Surat verifikasi adalah bukti sah bahwa Anda telah melengkapi seluruh persyaratan pendaftaran. Dokumen ini dapat diunduh setelah semua data lengkap.
            </x-atoms.description>

            @if($canDownloadVerifikasiPDF)
                <div class="flex flex-col items-center gap-4">
                    <a href="{{ route('siswa.pdf.verifikasi') }}" 
                       target="_blank"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="ri-download-line text-xl"></i>
                        <span class="font-semibold">Download Surat Verifikasi</span>
                    </a>
                    <div class="flex items-center gap-2 text-green-600">
                        <i class="ri-check-circle-line"></i>
                        <span class="text-sm font-medium">Dokumen Siap Diunduh</span>
                    </div>
                </div>
            @else
                <div class="max-w-md mx-auto bg-gray-50 border border-gray-200 rounded-xl p-6 text-left">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ri-error-warning-line text-red-500"></i>
                        Belum Dapat Diunduh
                    </h4>
                    <p class="text-sm text-gray-600 mb-4">Mohon lengkapi data berikut:</p>
                    <ul class="space-y-2">
                        @foreach($missingItems as $item)
                        <li class="flex items-center gap-2 text-sm text-gray-700">
                            <i class="ri-close-circle-line text-red-500"></i>
                            <span>{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            &larr; Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </x-atoms.card>
</div>
