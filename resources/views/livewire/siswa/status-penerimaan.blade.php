<div>
    <x-atoms.breadcrumb current-path="Status Penerimaan" />
  
     <!-- Registration Status Card -->
    @if(count($pendaftaranList) > 0)
    <x-atoms.card className="mt-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                <i class="ri-file-list-3-line text-indigo-600 text-xl"></i>
            </div>
            <div>
                <x-atoms.title text="Sekolah dan Jurusan" size="lg" />
                <x-atoms.description size="sm" color="gray-600">
                    Sekolah dan Jurusan yang di pilih.
                </x-atoms.description>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $registrationStats['total'] }}</div>
                <div class="text-sm text-gray-600">Total Pendaftaran</div>
            </div>
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">{{ $registrationStats['pending'] }}</div>
                <div class="text-sm text-yellow-700">Menunggu Verifikasi</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $registrationStats['diterima'] }}</div>
                <div class="text-sm text-green-700">Diterima</div>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-lg">
                <div class="text-2xl font-bold text-red-600">{{ $registrationStats['ditolak'] }}</div>
                <div class="text-sm text-red-700">Ditolak</div>
            </div>
        </div>

        <!-- Registration Details -->
        <div class="space-y-4">
            @foreach($pendaftaranList as $pendaftaran)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ri-school-line text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <x-atoms.title text="{{ $pendaftaran->jalurPendaftaran->nama }}" size="md" className="mb-1" />
                                <x-atoms.description size="sm" color="gray-600" className="mb-2">
                                    {{ $pendaftaran->tipeSekolah->nama }} - {{ $pendaftaran->jurusan->nama }}
                                </x-atoms.description>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <i class="ri-calendar-line"></i>
                                    <span>Didaftar: {{ $pendaftaran->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:items-end gap-2">
                        <x-atoms.badge 
                            :text="$this->getStatusText($pendaftaran->status)"
                            :variant="$this->getStatusColor($pendaftaran->status)" 
                            size="sm"
                        />
                        
                        @if($pendaftaran->status === 'pending')
                        <div class="flex items-center gap-1 text-xs text-yellow-600">
                            <i class="ri-time-line"></i>
                            <span>Sedang diproses admin</span>
                        </div>
                        @elseif($pendaftaran->status === 'diterima')
                        <div class="flex items-center gap-1 text-xs text-green-600">
                            <i class="ri-check-circle-line"></i>
                            <span>Selamat! Anda diterima</span>
                        </div>
                        @elseif($pendaftaran->status === 'ditolak')
                        <div class="flex items-center gap-1 text-xs text-red-600">
                            <i class="ri-close-circle-line"></i>
                            <span>Mohon maaf, belum beruntung</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                
            </div>
            @endforeach
        </div>
    </x-atoms.card>
    @endif

    <!-- PDF Download Card -->
    @if(count($pendaftaranList) > 0 && ($canDownloadPenerimaanPDF))
    {{-- PDF Download Card --}}
    <x-atoms.card className="mt-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="ri-file-pdf-line text-red-600 text-xl"></i>
            </div>
            <div>
                <x-atoms.title text="Download Dokumen PDF" size="lg" />
                <x-atoms.description size="sm" color="gray-600">
                    Download formulir verifikasi dan surat penerimaan
                </x-atoms.description>
            </div>
        </div>

        <!-- PDF Download Options -->
        <div class="grid grid-cols-1 gap-6">

            <!-- Surat Penerimaan -->
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-sm transition-shadow {{ $hasAcceptedRegistration ? 'border-green-200 bg-green-50' : '' }}">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 {{ $hasAcceptedRegistration ? 'bg-green-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="ri-award-line {{ $hasAcceptedRegistration ? 'text-green-600' : 'text-gray-400' }} text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <x-atoms.title text="Surat Penerimaan" size="md" className="mb-2 {{ $hasAcceptedRegistration ? 'text-green-900' : '' }}" />
                        <x-atoms.description size="sm" color="{{ $hasAcceptedRegistration ? 'green-700' : 'gray-600' }}" className="mb-3">
                            {{ $hasAcceptedRegistration ? 'Selamat! Surat resmi penerimaan Anda sudah tersedia.' : 'Surat resmi penerimaan akan tersedia setelah Anda diterima.' }}
                        </x-atoms.description>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="ri-{{ $hasAcceptedRegistration ? 'check' : 'time' }}-line {{ $hasAcceptedRegistration ? 'text-green-500' : 'text-gray-400' }}"></i>
                                <span class="{{ $hasAcceptedRegistration ? 'text-green-700' : 'text-gray-500' }}">Status Penerimaan</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="ri-{{ $hasAcceptedRegistration ? 'check' : 'time' }}-line {{ $hasAcceptedRegistration ? 'text-green-500' : 'text-gray-400' }}"></i>
                                <span class="{{ $hasAcceptedRegistration ? 'text-green-700' : 'text-gray-500' }}">Informasi Daftar Ulang</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="ri-{{ $hasAcceptedRegistration ? 'check' : 'time' }}-line {{ $hasAcceptedRegistration ? 'text-green-500' : 'text-gray-400' }}"></i>
                                <span class="{{ $hasAcceptedRegistration ? 'text-green-700' : 'text-gray-500' }}">Jadwal & Persyaratan</span>
                            </div>
                        </div>

                        @if($canDownloadPenerimaanPDF && $penerimaanPDFSettings)
                        <div class="space-y-2">
                            <a href="{{ route('siswa.pdf.penerimaan') }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                <i class="ri-download-line"></i>
                                <span>Download Surat</span>
                            </a>
                            <div class="flex items-center gap-1 text-xs text-green-600">
                                <i class="ri-check-circle-line"></i>
                                <span>Selamat! Anda diterima</span>
                            </div>
                        </div>
                        @else
                        <div class="space-y-2">
                            <button disabled 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                                <i class="ri-lock-line"></i>
                                <span>{{ $hasAcceptedRegistration ? 'Belum Tersedia' : 'Menunggu Penerimaan' }}</span>
                            </button>
                            <div class="text-xs text-gray-500">
                                @if($hasAcceptedRegistration && !$penerimaanPDFSettings)
                                    <div class="flex items-center gap-1 text-red-500">
                                        <i class="ri-error-warning-line"></i>
                                        <span>Pengaturan PDF belum dikonfigurasi</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1">
                                        <i class="ri-information-line"></i>
                                        <span>Akan tersedia setelah penerimaan</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-atoms.card>
    @endif
    
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush