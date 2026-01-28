<div x-data="{ 
    refreshInterval: null,
    mounted() {
        // Refresh data setiap 60 detik
        this.refreshInterval = setInterval(() => {
            $wire.$refresh();
        }, 60000);
    },
    unmounted() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
}" x-init="mounted()" x-destroy="unmounted()">
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
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}</p>
        </div>
        <div class="flex items-center gap-3">
             <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-white border border-gray-200 text-gray-600">
                {{ now()->format('d F Y') }}
             </span>
        </div>
    </div>

    {{-- Stats Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total Siswa', 'value' => $totalStats['total_siswa'], 'icon' => 'ri-user-line', 'color' => 'blue'],
            ['label' => 'Total Pendaftaran', 'value' => $totalStats['total_pendaftaran'], 'icon' => 'ri-file-list-line', 'color' => 'emerald'],
            ['label' => 'Jalur Pendaftaran', 'value' => $totalStats['total_jalur'], 'icon' => 'ri-route-line', 'color' => 'purple'],
            ['label' => 'Test Aktif', 'value' => $totalStats['total_tests'], 'icon' => 'ri-file-text-line', 'color' => 'orange'],
        ] as $stat)
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stat['value']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-{{ $stat['color'] }}-50 flex items-center justify-center text-{{ $stat['color'] }}-600">
                    <i class="{{ $stat['icon'] }} text-xl"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Urgent Actions (Only if items pending) --}}
    @php $totalPending = $pendaftaranStats['pending'] + $buktiTransferStats['pending'] + $testReviewStats['pending_review']; @endphp
    @if($totalPending > 0)
    <div class="rounded-xl border border-red-200 bg-red-50 p-6">
        <div class="flex items-center gap-3 mb-4">
            <i class="ri-alert-line text-red-600 text-xl"></i>
            <h3 class="text-lg font-semibold text-red-900">Perlu Tindakan ({{ $totalPending }})</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach([
                ['count' => $pendaftaranStats['pending'], 'label' => 'Pendaftaran Baru', 'route' => 'admin.siswa', 'icon' => 'ri-user-add-line', 'color' => 'blue'],
                ['count' => $buktiTransferStats['pending'], 'label' => 'Verifikasi Pembayaran', 'route' => 'admin.pembayaran.bukti-transfer', 'icon' => 'ri-money-dollar-circle-line', 'color' => 'green'],
                ['count' => $testReviewStats['pending_review'], 'label' => 'Review Test Essay', 'route' => 'admin.review-answers', 'icon' => 'ri-file-text-line', 'color' => 'purple'],
            ] as $action)
                @if($action['count'] > 0)
                <a href="{{ route($action['route']) }}" class="flex items-center justify-between p-4 bg-white rounded-lg border border-red-100 hover:border-red-300 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-{{ $action['color'] }}-50 flex items-center justify-center text-{{ $action['color'] }}-600">
                            <i class="{{ $action['icon'] }}"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ $action['label'] }}</span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">{{ $action['count'] }}</span>
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- Live Activity & Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <livewire:components.recent-registrations />
        
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Progress Pendaftaran</h3>
                <span class="text-xs text-gray-500">Kelengkapan Data Siswa</span>
            </div>
            
            <div class="space-y-6">
                @foreach([
                   ['label' => 'Biodata', 'key' => 'data_murid', 'color' => 'indigo'], 
                   ['label' => 'Data Orang Tua', 'key' => 'data_orang_tua', 'color' => 'emerald'], 
                   ['label' => 'Berkas Dokumen', 'key' => 'berkas_murid', 'color' => 'blue'], 
                   ['label' => 'Finalisasi', 'key' => 'pendaftaran', 'color' => 'purple'], 
                ] as $prog)
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-medium text-gray-700">{{ $prog['label'] }}</span>
                        <span class="text-gray-900 font-bold">{{ $completionStats[$prog['key']] }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-{{ $prog['color'] }}-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $completionStats[$prog['key']] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recruitment Channels --}}
    @if(count($jalurPendaftaranData) > 0)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Jalur Pendaftaran</h3>
            <a href="{{ route('admin.pendaftaran.jalur') }}" class="text-sm font-medium text-lime-600 hover:text-lime-700">Kelola Jalur &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase font-medium text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Nama Jalur</th>
                        <th class="px-6 py-3">Biaya</th>
                        <th class="px-6 py-3 text-center">Total Pendaftar</th>
                        <th class="px-6 py-3 text-center">Diterima</th>
                        <th class="px-6 py-3 text-right">Pendapatan (Est)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($jalurPendaftaranData as $data)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $data['jalur']->nama }}</td>
                        <td class="px-6 py-4">Rp{{ number_format($data['jalur']->biaya, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $data['total_pendaftar'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $data['diterima'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-medium text-gray-900">Rp{{ number_format($data['biaya_total'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
        <a href="{{ route($Link['route']) }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-200 rounded-xl hover:border-lime-500 hover:text-lime-600 hover:bg-lime-50 transition-all text-gray-600 gap-2">
            <i class="{{ $Link['icon'] }} text-2xl"></i>
            <span class="text-xs font-medium">{{ $Link['label'] }}</span>
        </a>
        @endforeach
    </div>

</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush