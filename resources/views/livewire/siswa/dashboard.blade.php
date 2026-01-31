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
    <div id="tour-progress-cards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div id="tour-data-siswa">
            <x-molecules.progress-card
                title="Data Siswa"
                :progress="$dataMuridProgress"
                icon="ri-user-line"
                color="lime"
                url="{{ route('siswa.formulir.data-murid') }}"
                completeText="Lihat Data"
                incompleteText="Lengkapi Data"
            />
        </div>

        <div id="tour-data-ortu">
            <x-molecules.progress-card
                title="Data Orang Tua"
                :progress="$dataOrangTuaProgress"
                icon="ri-parent-line"
                color="green"
                url="{{ route('siswa.formulir.data-orang-tua') }}"
                completeText="Lihat Data"
                incompleteText="Lengkapi Data"
            />
        </div>

        <div id="tour-berkas">
            <x-molecules.progress-card
                title="Berkas Siswa"
                :progress="$berkasMuridProgress"
                icon="ri-folder-line"
                color="blue"
                url="{{ route('siswa.formulir.berkas-murid') }}"
                completeText="Lihat Berkas"
                incompleteText="Upload Berkas"
            />
        </div>

        <div id="tour-pendaftaran">
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

    <!-- Status & Dokumen (New Navigation) -->
    @if(count($pendaftaranList) > 0)
    <x-atoms.card className="mt-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                <i class="ri-folder-open-line text-indigo-600 text-xl"></i>
            </div>
            <div>
                <x-atoms.title text="Status & Dokumen" size="lg" />
                <x-atoms.description size="sm" color="gray-600">
                    Akses surat verifikasi dan cek hasil seleksi penerimaan
                </x-atoms.description>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- 1. Surat Verifikasi -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="ri-file-text-line text-6xl text-blue-500"></i>
                </div>
                
                <div class="relative z-10">
                   <h3 class="text-lg font-bold text-gray-900 mb-2">Surat Verifikasi</h3>
                   <p class="text-sm text-gray-500 mb-6 h-12">Unduh bukti verifikasi pendaftaran setelah data lengkap.</p>
                   
                   <div class="flex items-center justify-between">
                       @if($canDownloadVerifikasiPDF)
                           <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                               <i class="ri-check-line mr-1"></i> Siap Diunduh
                           </span>
                       @else
                           <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                               <i class="ri-loader-4-line mr-1"></i> Belum Lengkap
                           </span>
                       @endif

                       <a href="{{ route('siswa.surat-verifikasi') }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 hover:underline">
                           Buka Halaman <i class="ri-arrow-right-line ml-1"></i>
                       </a>
                   </div>
                </div>
            </div>

            <!-- 2. Hasil Seleksi -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-6 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="ri-award-line text-6xl text-orange-500"></i>
                </div>
                
                <div class="relative z-10">
                   <h3 class="text-lg font-bold text-gray-900 mb-2">Hasil Seleksi</h3>
                   <p class="text-sm text-gray-500 mb-6 h-12">Cek pengumuman kelulusan dan unduh surat keputusan resmi.</p>
                   
                   <div class="flex items-center justify-between">
                        @if($hasAcceptedRegistration)
                           <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 animate-pulse">
                               <i class="ri-star-fill mr-1"></i> Pengumuman Ada
                           </span>
                        @else
                           <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                               <i class="ri-time-line mr-1"></i> Cek Status
                           </span>
                        @endif

                       <a href="{{ route('siswa.hasil-seleksi') }}" class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700 hover:underline">
                           Buka Amplop <i class="ri-mail-open-line ml-1"></i>
                       </a>
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
{{-- Driver.js CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css"/>
<style>
    /* Custom Driver.js styling */
    .driver-popover {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        max-width: 400px;
    }
    .driver-popover-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
    }
    .driver-popover-description {
        color: #4b5563;
        line-height: 1.6;
    }
    .driver-popover-progress-text {
        color: #6b7280;
        font-size: 0.75rem;
    }
    .driver-popover-navigation-btns button {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .driver-popover-next-btn {
        background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%);
        color: white;
    }
    .driver-popover-next-btn:hover {
        background: linear-gradient(135deg, #65a30d 0%, #4d7c0f 100%);
    }
    .driver-popover-prev-btn {
        background: #f3f4f6;
        color: #374151;
    }
    .driver-popover-prev-btn:hover {
        background: #e5e7eb;
    }
    .driver-popover-close-btn {
        color: #6b7280;
    }
</style>
@endpush

@push('scripts')
{{-- Driver.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>

@if(!$hasSeenTour)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for page to fully render
    setTimeout(function() {
        const driver = window.driver.js.driver;
        
        const driverObj = driver({
            showProgress: true,
            showButtons: ['next', 'previous', 'close'],
            steps: [
                {
                    popover: {
                        title: '🎉 Selamat Datang di SPMB!',
                        description: 'Hai! Selamat datang di Sistem Penerimaan Murid Baru Lemdiklat TNI. Mari kita pelajari cara menggunakan sistem ini. Klik "Selanjutnya" untuk memulai tour.',
                        side: 'center',
                        align: 'center'
                    }
                },
                {
                    element: '#tour-progress-cards',
                    popover: {
                        title: '📊 Progress Pendaftaran',
                        description: 'Di sini kamu bisa melihat progress pengisian data pendaftaran. Setiap kartu menunjukkan persentase kelengkapan data.',
                        side: 'bottom',
                        align: 'center'
                    }
                },
                {
                    element: '#tour-data-siswa',
                    popover: {
                        title: '1️⃣ Data Siswa',
                        description: '<strong>LANGKAH PERTAMA:</strong> Isi data pribadi kamu seperti nama lengkap, tempat tanggal lahir, alamat, dan nomor WhatsApp. Klik kartu ini untuk mulai mengisi.',
                        side: 'bottom',
                        align: 'start'
                    }
                },
                {
                    element: '#tour-data-ortu',
                    popover: {
                        title: '2️⃣ Data Orang Tua',
                        description: '<strong>LANGKAH KEDUA:</strong> Isi data orang tua/wali kamu. Data ini penting untuk keperluan administrasi sekolah.',
                        side: 'bottom',
                        align: 'start'
                    }
                },
                {
                    element: '#tour-berkas',
                    popover: {
                        title: '3️⃣ Upload Berkas',
                        description: '<strong>LANGKAH KETIGA:</strong> Upload dokumen yang diperlukan seperti KK, Akta Kelahiran, foto, dan ijazah. Pastikan file berformat gambar atau PDF.',
                        side: 'bottom',
                        align: 'start'
                    }
                },
                {
                    element: '#tour-pendaftaran',
                    popover: {
                        title: '4️⃣ Pilih Jalur & Jurusan',
                        description: '<strong>LANGKAH KEEMPAT:</strong> Pilih jalur pendaftaran, jenis sekolah (SMA/SMK), dan jurusan yang kamu inginkan.',
                        side: 'bottom',
                        align: 'end'
                    }
                },
                {
                    popover: {
                        title: '💰 Upload Bukti Pembayaran',
                        description: 'Setelah semua data terisi, upload bukti pembayaran pendaftaran di bagian bawah halaman ini. Admin akan memverifikasi pembayaran kamu.',
                        side: 'center',
                        align: 'center'
                    }
                },
                {
                    popover: {
                        title: '📝 Ikuti Ujian Seleksi',
                        description: 'Setelah pembayaran diverifikasi, kamu bisa mengikuti ujian seleksi sesuai jadwal. Klik menu "Ujian Seleksi" di sidebar untuk mulai mengerjakan.',
                        side: 'center',
                        align: 'center'
                    }
                },
                {
                    popover: {
                        title: '📄 Download Surat Verifikasi',
                        description: 'Setelah semua ujian selesai, kamu bisa download Surat Verifikasi sebagai bukti pendaftaran yang sah.',
                        side: 'center',
                        align: 'center'
                    }
                },
                {
                    popover: {
                        title: '🎓 Tunggu Pengumuman',
                        description: 'Hasil seleksi akan diumumkan sesuai jadwal. Jika diterima, kamu bisa download Surat Penerimaan dari dashboard ini. Semoga sukses! 🙏',
                        side: 'center',
                        align: 'center'
                    }
                }
            ],
            nextBtnText: 'Selanjutnya →',
            prevBtnText: '← Sebelumnya',
            doneBtnText: 'Selesai ✓',
            progressText: 'Langkah @{{current}} dari @{{total}}',
            onDestroyStarted: function() {
                // Mark tour as complete when closed
                @this.call('markTourComplete');
                driverObj.destroy();
            }
        });

        driverObj.drive();
    }, 500);
});
</script>
@endif
@endpush