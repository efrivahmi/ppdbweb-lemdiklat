<div x-data="{ 
    refreshInterval: null,
    mounted() {
        // Refresh progress setiap 30 detik
        this.refreshInterval = setInterval(() => {
            $wire.calculateProgress();
        }, 30000);
    },
    unmounted() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
}" x-init="mounted()" x-destroy="unmounted()">
    <x-atoms.breadcrumb current-path="Dashboard" />
    
    {{-- Modern 2026 Welcome Header --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-lime-500 via-lime-600 to-green-600 rounded-2xl mt-4 text-white shadow-xl">
        {{-- Animated gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 via-transparent to-white/5"></div>
        
        {{-- Decorative circles --}}
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute top-1/2 right-1/4 w-20 h-20 bg-white/5 rounded-full"></div>
        
        <div class="relative z-10 p-6 md:p-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="ri-user-3-line text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-lime-200 text-sm font-medium">Selamat Datang</p>
                            <h2 class="text-2xl md:text-3xl font-bold">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-full">
                            <i class="ri-id-card-line text-sm"></i>
                            <span class="text-sm font-medium">NISN: {{ Auth::user()->nisn }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-full">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                            </span>
                            <span class="text-sm font-medium">PPDB Online</span>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center justify-center">
                    <div class="relative">
                        <div class="w-24 h-24 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                            <i class="ri-graduation-cap-fill text-5xl text-white/80"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-lime-400 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="ri-check-line text-lime-900 text-sm font-bold"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <x-molecules.progress-card
            title="Data Siswa"
            :progress="$dataMuridProgress"
            icon="ri-user-line"
            color="lime"
            url="{{ route('siswa.formulir.data-murid') }}"
            completeText="Lihat Data"
            incompleteText="Lengkapi Data"
        />

        <x-molecules.progress-card
            title="Data Orang Tua"
            :progress="$dataOrangTuaProgress"
            icon="ri-parent-line"
            color="green"
            url="{{ route('siswa.formulir.data-orang-tua') }}"
            completeText="Lihat Data"
            incompleteText="Lengkapi Data"
        />

        <x-molecules.progress-card
            title="Berkas Siswa"
            :progress="$berkasMuridProgress"
            icon="ri-folder-line"
            color="blue"
            url="{{ route('siswa.formulir.berkas-murid') }}"
            completeText="Lihat Berkas"
            incompleteText="Upload Berkas"
        />

        <x-molecules.progress-card
            title="Pendaftaran"
            :progress="$pendaftaranProgress"
            icon="ri-file-list-line"
            color="purple"
            url="{{ route('siswa.pendaftaran') }}"
            completeText="Lihat Pendaftaran"
            incompleteText="Pilih Jurusan"
        />
    </div>

    <!-- Overall Progress -->
    <x-molecules.overall-progress-card
        :overallProgress="$overallProgress"
        :completedSections="collect([$dataMuridProgress, $dataOrangTuaProgress, $berkasMuridProgress, $pendaftaranProgress])->filter(fn($p) => $p >= 100)->count()"
        :totalSections="4"
    />

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
                    
                 
                </div>
                
                <!-- Biaya Information -->
                <!-- <div class="mt-3 pt-3 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Biaya Pendaftaran:</span>
                        <span class="font-medium text-green-600">Rp{{ number_format($pendaftaran->jalurPendaftaran->biaya, 0, ',', '.') }}</span>
                    </div>
                </div> -->
            </div>
            @endforeach
        </div>
    </x-atoms.card>
    @endif

    <!-- PDF Download Card -->
    @if(count($pendaftaranList) > 0 && ($canDownloadVerifikasiPDF))
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
            <!-- Formulir Verifikasi -->
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-sm transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="ri-file-text-line text-blue-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <x-atoms.title text="Formulir Verifikasi" size="md" className="mb-2" />
                        <x-atoms.description size="sm" color="gray-600" className="mb-3">
                            Dokumen berisi data lengkap pendaftaran Anda untuk keperluan verifikasi dan administrasi.
                        </x-atoms.description>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="ri-check-line text-green-500"></i>
                                <span class="text-gray-600">Data Pribadi & Orang Tua</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="ri-check-line text-green-500"></i>
                                <span class="text-gray-600">Pilihan Jalur & Jurusan</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="ri-check-line text-green-500"></i>
                                <span class="text-gray-600">Checklist Berkas</span>
                            </div>
                        </div>

                        @if($canDownloadVerifikasiPDF && $verifikasiPDFSettings)
                        <div class="space-y-2">
                            <a href="{{ route('siswa.pdf.verifikasi') }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                <i class="ri-download-line"></i>
                                <span>Download PDF</span>
                            </a>
                            <div class="flex items-center gap-1 text-xs text-green-600">
                                <i class="ri-check-circle-line"></i>
                                <span>Siap untuk diunduh</span>
                            </div>
                        </div>
                        @else
                        <div class="space-y-2">
                            <button disabled 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                                <i class="ri-lock-line"></i>
                                <span>Belum Tersedia</span>
                            </button>
                            <div class="text-xs text-gray-500">
                                @if(!$verifikasiPDFSettings)
                                    <div class="flex items-center gap-1 text-red-500">
                                        <i class="ri-error-warning-line"></i>
                                        <span>Pengaturan PDF belum dikonfigurasi</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1">
                                        <i class="ri-information-line"></i>
                                        <span>Lengkapi semua data dan test jalur untuk mengunduh</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

         
        </div>

        <!-- Info Section -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class="ri-information-line text-blue-600 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <x-atoms.title text="Informasi Penting" size="sm" className="text-blue-900 mb-2" />
                        <div class="text-sm text-blue-800 space-y-1">
                            <x-atoms.description size="sm" color="blue-800" className="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Formulir verifikasi dapat diunduh setelah semua data lengkap dan pendaftaran selesai</span>
                            </x-atoms.description>
                            <x-atoms.description size="sm" color="blue-800" className="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Surat penerimaan hanya tersedia bagi siswa yang diterima</span>
                            </x-atoms.description>
                            <x-atoms.description size="sm" color="blue-800" className="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Dokumen PDF menggunakan format resmi sekolah</span>
                            </x-atoms.description>
                            <x-atoms.description size="sm" color="blue-800" className="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Simpan dokumen dengan baik untuk keperluan administratif</span>
                            </x-atoms.description>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-atoms.card>
    @endif

   
    <!-- Payment Section -->
    @if(count($jalurData) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Payment Info Card -->
            <x-atoms.card className="border border-gray-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="ri-money-dollar-circle-line text-green-600 text-xl"></i>
                    </div>
                    <x-atoms.title text="Informasi Transfer" size="lg" />
                </div>

        
                <!-- Status Pembayaran -->
                @if($buktiTransfer)
                <div class="mt-4 p-3 rounded-lg {{ $buktiTransfer->status === 'diterima' ? 'bg-green-50 border border-green-200' : ($buktiTransfer->status === 'ditolak' ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200') }}">
                    <div class="flex items-center gap-2">
                        @if($buktiTransfer->status === 'success')
                            <i class="ri-check-circle-fill text-green-600"></i>
                            <span class="text-sm font-medium text-green-800">Pembayaran Diterima</span>
                        @elseif($buktiTransfer->status === 'decline')
                            <i class="ri-close-circle-fill text-red-600"></i>
                            <span class="text-sm font-medium text-red-800">Pembayaran Ditolak</span>
                        @else
                            <i class="ri-time-fill text-yellow-600"></i>
                            <span class="text-sm font-medium text-yellow-800">Menunggu Verifikasi Pembayaran</span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Informasi Transfer -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    
                    @if(count($bankAccounts) > 0)
                        <div class="space-y-4">
                            @foreach($bankAccounts as $account)
                            <div class="bg-white rounded-lg p-3 border border-blue-100">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <x-atoms.description size="sm" color="blue-700" className="font-medium">Bank:</x-atoms.description>
                                        <x-atoms.description size="sm" color="blue-900">{{ $account->bank_name }}</x-atoms.description>
                                    </div>
                                    <div>
                                        <x-atoms.description size="sm" color="blue-700" className="font-medium">No. Rekening:</x-atoms.description>
                                        <x-atoms.description size="sm" color="blue-900" className="font-mono">{{ $account->account_number }}</x-atoms.description>
                                    </div>
                                    <div>
                                        <x-atoms.description size="sm" color="blue-700" className="font-medium">Atas Nama:</x-atoms.description>
                                        <x-atoms.description size="sm" color="blue-900">{{ $account->account_holder }}</x-atoms.description>
                                    </div>
                                    
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <x-atoms.description size="sm" color="blue-700">
                                Informasi rekening belum tersedia. Hubungi admin untuk detail pembayaran.
                            </x-atoms.description>
                        </div>
                    @endif
                </div>
            </x-atoms.card>

            <x-molecules.payment-upload-card
                :canUploadPayment="$canUploadPayment"
                :buktiTransfer="$buktiTransfer"
            />
        </div>
    @endif

    <!-- Admin Contacts Card -->
    @if(count($adminContacts) > 0)
    <x-atoms.card className="mt-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="ri-customer-service-line text-blue-600 text-xl"></i>
            </div>
            <div>
                <x-atoms.title text="Kontak Admin" size="lg" />
                <x-atoms.description size="sm" color="gray-600">
                    Hubungi admin jika membutuhkan bantuan
                </x-atoms.description>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($adminContacts as $admin)
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="ri-admin-line text-blue-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <x-atoms.title text="{{ $admin->name }}" size="md" className="text-blue-900 mb-1" />
                        <x-atoms.description size="sm" color="blue-600">Administrator</x-atoms.description>
                    </div>
                </div>

                <div class="space-y-3">
                    @if($admin->email)
                    <div class="flex items-center gap-2">
                        <i class="ri-mail-line text-blue-500 text-sm"></i>
                        <a href="mailto:{{ $admin->email }}" 
                           class="text-sm text-blue-700 hover:text-blue-800 hover:underline">
                            {{ $admin->email }}
                        </a>
                    </div>
                    @endif

                    @if($admin->telp)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="ri-phone-line text-blue-500 text-sm"></i>
                            <span class="text-sm text-blue-700">{{ $admin->telp }}</span>
                        </div>
                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-', '(', ')'], '', $admin->telp) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-xs">
                            <i class="ri-whatsapp-line"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                    @endif

                    @if(!$admin->telp && !$admin->email)
                    <x-atoms.description size="sm" color="gray-500">
                        Kontak belum tersedia
                    </x-atoms.description>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </x-atoms.card>
    @endif

    <!-- Quick Actions -->
    <x-molecules.quick-actions-card />

    <!-- Registration Flow Guide -->
    @if(count($pendaftaranList) === 0)
    <x-atoms.card className="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ri-guide-line text-2xl text-blue-600"></i>
            </div>
            <x-atoms.title text="Panduan Alur Pendaftaran" size="lg" className="text-blue-900 mb-4" />
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-indigo-600 font-bold">1</span>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-2">Lengkapi Data</h4>
                    <p class="text-sm text-gray-600">Isi data diri, orang tua, dan upload berkas</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-indigo-600 font-bold">2</span>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-2">Pilih Jalur</h4>
                    <p class="text-sm text-gray-600">Daftar jalur pendaftaran dan jurusan</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-indigo-600 font-bold">3</span>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-2">Registrasi</h4>
                    <p class="text-sm text-gray-600">Upload bukti transfer registrasi</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-indigo-600 font-bold">4</span>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-2">Tunggu</h4>
                    <p class="text-sm text-gray-600">Menunggu verifikasi dan pengumuman</p>
                </div>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('siswa.formulir.data-murid') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="ri-play-line"></i>
                    <span>Mulai Pendaftaran</span>
                </a>
            </div>
        </div>
    </x-atoms.card>
    @endif
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush