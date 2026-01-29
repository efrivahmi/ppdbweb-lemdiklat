<div x-data="{ 
    refreshInterval: null,
    mounted() {
        this.refreshInterval = setInterval(() => {
            $wire.$refresh();
        }, 60000);
    },
    unmounted() {
        if (this.refreshInterval) clearInterval(this.refreshInterval);
    }
}" x-init="mounted()" x-destroy="unmounted()" class="space-y-6">
    
    {{-- Welcome Header - Nature Green Gradient --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 right-20 w-20 h-20 bg-white/10 rounded-full translate-y-1/2"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">Selamat Datang, Admin!</h1>
                <p class="text-emerald-100 mt-1">Admin Dashboard - Sistem Penerimaan Peserta Didik Baru</p>
                <p class="text-emerald-200 text-sm mt-1">{{ now()->format('d F Y, H:i') }} WIB</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="ri-award-fill text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Overview - Nature Theme Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Siswa - Teal --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ number_format($totalStats['total_siswa']) }}</p>
                    <p class="text-teal-100 text-sm mt-1">Total Siswa</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="ri-user-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Total Pendaftaran - Emerald --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ number_format($totalStats['total_pendaftaran']) }}</p>
                    <p class="text-emerald-100 text-sm mt-1">Total Pendaftaran</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="ri-file-list-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Jalur Pendaftaran - Amber/Gold --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ number_format($totalStats['total_jalur']) }}</p>
                    <p class="text-amber-100 text-sm mt-1">Jalur Pendaftaran</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="ri-route-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Test Aktif - Lime --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-lime-500 to-lime-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ number_format($totalStats['total_tests']) }}</p>
                    <p class="text-lime-100 text-sm mt-1">Test Aktif</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="ri-file-text-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Urgent Actions - Warm Amber Alert Style --}}
    @php $totalPending = $pendaftaranStats['pending'] + $buktiTransferStats['pending'] + $testReviewStats['pending_review']; @endphp
    @if($totalPending > 0)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-yellow-50 border-b border-amber-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                    <i class="ri-alarm-warning-line text-amber-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-amber-800">Perhatian! Ada Yang Perlu Ditangani</h3>
                    <p class="text-amber-600 text-sm">{{ $totalPending }} item menunggu tindakan Anda</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 space-y-2">
            @if($pendaftaranStats['pending'] > 0)
            <a href="{{ route('admin.siswa') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-teal-50 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                        <i class="ri-user-add-line text-teal-600"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">{{ $pendaftaranStats['pending'] }}</span>
                        <p class="text-sm text-gray-600">Pendaftaran Baru</p>
                    </div>
                </div>
                <i class="ri-arrow-right-s-line text-gray-400 group-hover:text-teal-600 text-xl"></i>
            </a>
            @endif

            @if($buktiTransferStats['pending'] > 0)
            <a href="{{ route('admin.pembayaran.bukti-transfer') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                        <i class="ri-money-dollar-circle-line text-emerald-600"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">{{ $buktiTransferStats['pending'] }}</span>
                        <p class="text-sm text-gray-600">Verifikasi Pembayaran</p>
                    </div>
                </div>
                <i class="ri-arrow-right-s-line text-gray-400 group-hover:text-emerald-600 text-xl"></i>
            </a>
            @endif

            @if($testReviewStats['pending_review'] > 0)
            <a href="{{ route('admin.review-answers') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-lime-50 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-lime-100 rounded-full flex items-center justify-center">
                        <i class="ri-file-text-line text-lime-600"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">{{ $testReviewStats['pending_review'] }}</span>
                        <p class="text-sm text-gray-600">Review Test Essay</p>
                    </div>
                </div>
                <i class="ri-arrow-right-s-line text-gray-400 group-hover:text-lime-600 text-xl"></i>
            </a>
            @endif
        </div>
    </div>
    @endif

    {{-- ============================================== --}}
    {{-- PROGRESS SECTIONS --}}
    {{-- ============================================== --}}

    {{-- Progress Kelengkapan Data Siswa --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="ri-file-list-3-line text-teal-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Progress Kelengkapan Data Siswa</h2>
                    <p class="text-sm text-gray-500">Persentase siswa yang telah melengkapi setiap tahap pendaftaran</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalStats['total_siswa']) }}</p>
                <p class="text-sm text-gray-500">Total Siswa</p>
            </div>
        </div>

        {{-- Progress Cards - Nature Theme --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $progressItems = [
                    ['label' => 'Data Murid', 'key' => 'data_murid', 'count_key' => 'data_murid_count', 'icon' => 'ri-user-line', 'color' => 'teal', 'action' => 'Lengkap mengisi data diri'],
                    ['label' => 'Data Orang Tua', 'key' => 'data_orang_tua', 'count_key' => 'data_orang_tua_count', 'icon' => 'ri-parent-line', 'color' => 'amber', 'action' => 'Lengkap mengisi data keluarga'],
                    ['label' => 'Berkas Murid', 'key' => 'berkas_murid', 'count_key' => 'berkas_murid_count', 'icon' => 'ri-folder-line', 'color' => 'stone', 'action' => 'Upload semua dokumen'],
                    ['label' => 'Pendaftaran', 'key' => 'pendaftaran', 'count_key' => 'pendaftaran_count', 'icon' => 'ri-file-text-line', 'color' => 'lime', 'action' => 'Pilih jalur dan jurusan'],
                ];
            @endphp

            @foreach($progressItems as $item)
                @php
                    $percentage = $completionStats[$item['key']] ?? 0;
                    $count = $completionStats[$item['count_key']] ?? 0;
                    $total = $completionStats['total_siswa'] ?? $totalStats['total_siswa'];
                    $isGood = $percentage >= 50;
                    
                    // Nature theme colors
                    $colors = [
                        'teal' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-600', 'icon_bg' => 'bg-teal-100', 'progress' => 'bg-teal-500'],
                        'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'icon_bg' => 'bg-amber-100', 'progress' => 'bg-amber-500'],
                        'stone' => ['bg' => 'bg-stone-50', 'text' => 'text-stone-600', 'icon_bg' => 'bg-stone-100', 'progress' => 'bg-stone-500'],
                        'lime' => ['bg' => 'bg-lime-50', 'text' => 'text-lime-600', 'icon_bg' => 'bg-lime-100', 'progress' => 'bg-lime-500'],
                    ];
                    $colorSet = $colors[$item['color']];
                    
                    $bgColor = $isGood ? $colorSet['bg'] : 'bg-white';
                    $textColor = $isGood ? $colorSet['text'] : 'text-gray-900';
                    $badgeColor = $isGood ? 'bg-emerald-500' : 'bg-amber-500';
                    $badgeText = $isGood ? 'Cukup' : 'Perlu Perhatian';
                    $progressColor = $isGood ? $colorSet['progress'] : 'bg-amber-400';
                @endphp
                <div class="rounded-xl border border-gray-200 p-4 {{ $bgColor }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-8 h-8 {{ $colorSet['icon_bg'] }} {{ $colorSet['text'] }} rounded-lg flex items-center justify-center">
                            <i class="{{ $item['icon'] }} text-lg"></i>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-medium text-white rounded-full {{ $badgeColor }}">{{ $badgeText }}</span>
                    </div>
                    <p class="text-3xl font-bold {{ $textColor }}">{{ number_format($percentage, 1) }}%</p>
                    <p class="text-sm font-medium {{ $textColor }} mt-1">{{ $item['label'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $count }} dari {{ $total }} siswa lengkap</p>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-3">
                        <div class="{{ $progressColor }} h-1.5 rounded-full transition-all duration-500" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                        <i class="ri-checkbox-circle-line text-emerald-500"></i>
                        {{ $item['action'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Progress Keseluruhan --}}
    @php
        $overallProgress = ($completionStats['data_murid'] + $completionStats['data_orang_tua'] + $completionStats['berkas_murid'] + $completionStats['pendaftaran']) / 4;
        $overallStatus = $overallProgress >= 75 ? 'Sangat Baik' : ($overallProgress >= 50 ? 'Cukup Baik' : ($overallProgress >= 25 ? 'Perlu Ditingkatkan' : 'Kurang'));
        $overallBadgeColor = $overallProgress >= 75 ? 'bg-emerald-500' : ($overallProgress >= 50 ? 'bg-teal-500' : ($overallProgress >= 25 ? 'bg-amber-500' : 'bg-red-500'));
    @endphp
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Progress Keseluruhan</h3>
                <p class="text-sm text-gray-500">Rata-rata kelengkapan dari semua tahap pendaftaran</p>
            </div>
            <div class="text-right flex items-center gap-3">
                <p class="text-3xl font-bold text-gray-900">{{ number_format($overallProgress, 1) }}%</p>
                <span class="px-3 py-1 text-sm font-medium text-white rounded-full {{ $overallBadgeColor }}">{{ $overallStatus }}</span>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 via-emerald-500 to-lime-500 h-4 rounded-full transition-all duration-1000 flex items-center justify-end pr-2" style="width: {{ min($overallProgress, 100) }}%">
                <span class="text-xs font-medium text-white">{{ number_format($overallProgress, 1) }}%</span>
            </div>
        </div>
    </div>

    {{-- Status Pendaftaran, Bukti Transfer, Grafik Pendaftaran --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Status Pendaftaran --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="ri-file-list-3-line text-teal-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Status Pendaftaran</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-time-line text-amber-500"></i>
                        <span class="text-sm text-gray-700">Menunggu Verifikasi</span>
                    </div>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-sm font-bold rounded-lg">{{ $pendaftaranStats['pending'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-check-line text-emerald-500"></i>
                        <span class="text-sm text-gray-700">Diterima</span>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg">{{ $pendaftaranStats['diterima'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-close-line text-red-500"></i>
                        <span class="text-sm text-gray-700">Ditolak</span>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 text-sm font-bold rounded-lg">{{ $pendaftaranStats['ditolak'] }}</span>
                </div>
            </div>

            <a href="{{ route('admin.siswa') }}" class="flex items-center gap-1 text-sm text-teal-600 hover:text-teal-700 mt-4">
                Kelola Pendaftaran <i class="ri-arrow-right-line"></i>
            </a>
        </div>

        {{-- Bukti Transfer --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-emerald-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Bukti Transfer</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-time-line text-amber-500"></i>
                        <span class="text-sm text-gray-700">Perlu Verifikasi</span>
                    </div>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-sm font-bold rounded-lg">{{ $buktiTransferStats['pending'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-check-line text-emerald-500"></i>
                        <span class="text-sm text-gray-700">Diverifikasi</span>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg">{{ $buktiTransferStats['diterima'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-close-line text-red-500"></i>
                        <span class="text-sm text-gray-700">Ditolak</span>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 text-sm font-bold rounded-lg">{{ $buktiTransferStats['ditolak'] }}</span>
                </div>
            </div>

            <a href="{{ route('admin.pembayaran.bukti-transfer') }}" class="flex items-center gap-1 text-sm text-emerald-600 hover:text-emerald-700 mt-4">
                Verifikasi Pembayaran <i class="ri-arrow-right-line"></i>
            </a>
        </div>

        {{-- Grafik Pendaftaran --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-lime-100 rounded-lg flex items-center justify-center">
                        <i class="ri-bar-chart-2-line text-lime-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Grafik Pendaftaran</h3>
                        <p class="text-xs text-gray-500">Jumlah pendaftaran per bulan (7 bulan terakhir)</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-2">
                @foreach($monthlyRegistrations as $month)
                    @php
                        $maxCount = collect($monthlyRegistrations)->max('count') ?: 1;
                        $widthPercentage = ($month['count'] / $maxCount) * 100;
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 w-16 flex-shrink-0">{{ $month['month'] }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-2">
                            <div class="bg-teal-500 h-2 rounded-full transition-all" style="width: {{ $widthPercentage }}%"></div>
                        </div>
                        <span class="text-xs font-medium text-gray-700 w-6 text-right">{{ $month['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Data Jalur Pendaftaran --}}
    @if(count($jalurPendaftaranData) > 0)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="ri-route-line text-amber-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Data Jalur Pendaftaran</h2>
                <p class="text-sm text-gray-500">Statistik pendaftaran untuk setiap jalur yang tersedia</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($jalurPendaftaranData as $data)
                <div class="border border-gray-200 rounded-xl p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $data['jalur']->nama }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $data['jalur']->deskripsi ?? 'Pendaftaran berbasis tes akademik, psikotes dan kuesioner orangtua.' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-2">
                        <div class="bg-stone-50 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-stone-700">{{ $data['total_pendaftar'] }}</p>
                            <p class="text-xs text-stone-500">Total</p>
                        </div>
                        <div class="bg-amber-50 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-amber-600">{{ $data['pending'] }}</p>
                            <p class="text-xs text-amber-600">Pending</p>
                        </div>
                        <div class="bg-emerald-50 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-emerald-600">{{ $data['diterima'] }}</p>
                            <p class="text-xs text-emerald-600">Diterima</p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-red-600">{{ $data['ditolak'] }}</p>
                            <p class="text-xs text-red-600">Ditolak</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach([
            ['label' => 'Registrasi', 'route' => 'admin.siswa', 'icon' => 'ri-user-add-line'],
            ['label' => 'Pembayaran', 'route' => 'admin.pembayaran.bukti-transfer', 'icon' => 'ri-bank-card-line'],
            ['label' => 'Hasil Test', 'route' => 'admin.review-answers', 'icon' => 'ri-file-list-3-line'],
            ['label' => 'Jadwal Tes', 'route' => 'admin.pendaftaran.tes-jalur', 'icon' => 'ri-calendar-event-line'],
            ['label' => 'Pengaturan', 'route' => 'admin.admin', 'icon' => 'ri-settings-4-line'],
            ['label' => 'Laporan', 'route' => 'admin.dashboard', 'icon' => 'ri-file-chart-line'],
        ] as $Link)
        <a href="{{ route($Link['route']) }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-200 rounded-xl hover:border-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all text-gray-600 gap-2">
            <i class="{{ $Link['icon'] }} text-2xl"></i>
            <span class="text-xs font-medium">{{ $Link['label'] }}</span>
        </a>
        @endforeach
    </div>

</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush