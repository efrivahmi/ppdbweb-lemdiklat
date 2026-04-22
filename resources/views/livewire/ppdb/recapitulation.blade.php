<div class="min-h-screen p-6 bg-transparent">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Header Section -->
    <div class="flex flex-col items-start justify-between gap-4 mb-8 md:flex-row md:items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 to-slate-500" id="tour-header">
                Admission Recapitulation
            </h1>
            <p class="mt-1 text-sm font-medium text-slate-500">Monitor real-time enrollment statistics and movements.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3" id="tour-export-buttons">
            <!-- Filter Dropdown -->
            <div class="relative">
                <select wire:model.live="filterPeriod" class="appearance-none pl-4 pr-10 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                    <option value="all">Semua Waktu</option>
                    <option value="this_semester">Semester Ini (6 Bulan Terakhir)</option>
                    <option value="last_semester">Semester Lalu</option>
                    <option value="this_month">Bulan Ini</option>
                    <option value="last_month">Bulan Lalu</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                    <i class="ri-calendar-2-line"></i>
                </div>
            </div>

            <button onclick="startTour()" class="flex items-center justify-center w-10 h-10 transition-all duration-300 bg-white border border-gray-200 rounded-full shadow-sm text-slate-500 hover:bg-slate-50 hover:text-indigo-600 hover:shadow-md hover:-translate-y-0.5" title="Page Tour">
                <i class="text-xl ri-guide-line"></i>
            </button>

            <a href="{{ route('ppdb.export.excel', ['period' => $filterPeriod]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white transition-all duration-300 shadow-lg rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                <i class="text-lg ri-file-excel-2-line"></i>
                Export Excel
            </a>
            <a href="{{ route('ppdb.export.pdf', ['period' => $filterPeriod]) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white transition-all duration-300 shadow-lg rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 hover:shadow-rose-500/30 hover:-translate-y-0.5">
                <i class="text-lg ri-file-pdf-2-line"></i>
                Print PDF
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 mb-8 sm:grid-cols-2 lg:grid-cols-5" id="tour-stats">
        <!-- Card 1 -->
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-group-line text-slate-800"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-slate-500">Total Applicants</p>
            <p class="mt-3 text-4xl font-extrabold text-slate-800">{{ $stats['total'] }}</p>
            <div class="flex items-center mt-3 text-xs font-medium text-emerald-600 bg-emerald-50 w-fit px-2.5 py-1 rounded-full">
                <i class="mr-1 ri-arrow-up-line"></i> {{ $stats['conversion'] }}% Conversion
            </div>
        </div>

        <!-- Card 2 -->
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-user-unfollow-line text-slate-500"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-slate-500">Account Only</p>
            <p class="mt-3 text-4xl font-extrabold text-slate-600">{{ $stats['account_only'] }}</p>
            <p class="mt-3 text-xs font-medium text-slate-400">Belum isi form</p>
        </div>

        <!-- Card 3 -->
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-amber-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-time-line text-amber-500"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-amber-600">Pending</p>
            <p class="mt-3 text-4xl font-extrabold text-amber-600">{{ $stats['pending'] }}</p>
            <p class="mt-3 text-xs font-medium text-amber-500/70">Menunggu verifikasi</p>
        </div>

        <!-- Card 4 -->
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-emerald-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-checkbox-circle-line text-emerald-500"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-emerald-600">Diterima</p>
            <p class="mt-3 text-4xl font-extrabold text-emerald-600">{{ $stats['accepted'] }}</p>
            <p class="mt-3 text-xs font-medium text-emerald-500/70">Telah diverifikasi</p>
        </div>

        <!-- Card 5 -->
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-rose-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-close-circle-line text-rose-500"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-rose-600">Ditolak</p>
            <p class="mt-3 text-4xl font-extrabold text-rose-600">{{ $stats['rejected'] }}</p>
            <p class="mt-3 text-xs font-medium text-rose-500/70">Syarat tidak memenuhi</p>
        </div>
    </div>

    <!-- Data Jalur Pendaftaran Section -->
    <div class="p-6 mb-8 bg-white border border-gray-100 shadow-sm rounded-2xl">
        <div class="flex items-center gap-3 mb-6">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-100 text-amber-600">
                <i class="text-xl ri-route-line"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">Data Jalur Pendaftaran</h2>
                <p class="text-sm text-slate-500">Statistik pendaftaran untuk setiap jalur yang tersedia</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @foreach($jalurRecap as $jalur)
            <div class="p-5 border border-gray-100 rounded-xl bg-slate-50/50">
                <h3 class="mb-2 text-lg font-bold text-slate-800">{{ $jalur->nama }}</h3>
                <p class="mb-5 text-sm text-slate-500">{{ $jalur->deskripsi ?? 'Pendaftaran siswa baru' }}</p>
                
                <div class="grid grid-cols-4 gap-3">
                    <div class="flex flex-col items-center justify-center py-3 bg-white rounded-lg shadow-sm">
                        <span class="text-xl font-bold text-slate-800">{{ $jalur->total_applicants }}</span>
                        <span class="text-xs text-slate-500">Total</span>
                    </div>
                    <div class="flex flex-col items-center justify-center py-3 bg-amber-50 rounded-lg shadow-sm">
                        <span class="text-xl font-bold text-amber-600">{{ $jalur->pending_count }}</span>
                        <span class="text-xs text-amber-600">Pending</span>
                    </div>
                    <div class="flex flex-col items-center justify-center py-3 bg-emerald-50 rounded-lg shadow-sm">
                        <span class="text-xl font-bold text-emerald-600">{{ $jalur->accepted_count }}</span>
                        <span class="text-xs text-emerald-600">Diterima</span>
                    </div>
                    <div class="flex flex-col items-center justify-center py-3 bg-rose-50 rounded-lg shadow-sm">
                        <span class="text-xl font-bold text-rose-600">{{ $jalur->rejected_count }}</span>
                        <span class="text-xs text-rose-600">Ditolak</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl" id="tour-table">
        <div class="px-6 py-5 border-b border-gray-100/50 bg-white/50">
            <h3 class="text-lg font-bold text-slate-800"><i class="mr-2 text-indigo-500 ri-bar-chart-horizontal-fill"></i>Applicant Distribution per Major</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-bold tracking-wider uppercase border-b text-slate-500 bg-slate-50/50 border-gray-100">
                        <th class="px-6 py-4">Major</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4 text-amber-600">Pending</th>
                        <th class="px-6 py-4 text-emerald-600">Diterima</th>
                        <th class="px-6 py-4 text-rose-600">Ditolak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($majorRecap as $item)
                    <tr class="transition-colors duration-200 hover:bg-slate-50/80 group">
                        <td class="px-6 py-4 font-bold text-slate-700 group-hover:text-indigo-600">{{ $item->nama_jurusan ?? $item->nama }}</td>
                        <td class="px-6 py-4 text-sm font-extrabold text-slate-800">{{ $item->total_applicants }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-amber-600">
                            <span class="px-2 py-1 bg-amber-50 rounded-md">{{ $item->pending_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-extrabold text-emerald-600">
                            <span class="px-2 py-1 bg-emerald-50 rounded-md">{{ $item->accepted_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-rose-600">
                            <span class="px-2 py-1 bg-rose-50 rounded-md">{{ $item->rejected_count }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="mb-3 text-4xl ri-inbox-line"></i>
                                <p class="text-sm font-medium">No applicant data available yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart & Account Only Section -->
    <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-2">
        <!-- Monthly Trend Chart -->
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl" id="tour-chart">
            <h3 class="mb-4 text-lg font-bold text-slate-800"><i class="mr-2 text-indigo-500 ri-bar-chart-2-fill"></i>Monthly Registration Trend</h3>
            <div class="relative h-72">
                <canvas id="monthlyTrendChart"></canvas>
            </div>
        </div>

        <!-- Account Only Users -->
        <div class="p-0 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl" id="tour-account-only">
            <div class="px-6 py-5 border-b border-gray-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800"><i class="mr-2 text-indigo-500 ri-user-unfollow-line"></i>Account Only Students ({{ $accountOnlyUsers->count() }})</h3>
                <p class="mt-1 text-sm text-slate-500">Siswa yang sudah mendaftar akun tapi belum mengisi form pendaftaran.</p>
            </div>
            <div class="overflow-y-auto max-h-72">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 bg-white shadow-sm">
                        <tr class="text-xs font-bold tracking-wider uppercase border-b text-slate-500 border-gray-100">
                            <th class="px-6 py-3">Nama Lengkap</th>
                            <th class="px-6 py-3">Kontak</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($accountOnlyUsers as $user)
                        <tr class="transition-colors duration-200 hover:bg-slate-50/80">
                            <td class="px-6 py-3">
                                <p class="font-bold text-slate-700">{{ $user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $user->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-3">
                                <p class="text-sm font-medium text-slate-600"><i class="mr-1 ri-mail-line"></i>{{ $user->email }}</p>
                                @if($user->telp)
                                <p class="text-xs text-slate-500"><i class="mr-1 ri-phone-line"></i>{{ $user->telp }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right">
                                @if($user->telp)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $user->telp)) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 text-white transition-colors bg-emerald-500 rounded-lg hover:bg-emerald-600" title="Hubungi via WhatsApp">
                                    <i class="ri-whatsapp-line"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">
                                <p class="text-sm font-medium">Tidak ada siswa yang belum mengisi form.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Registered Users List -->
    <div class="mt-8 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl" id="tour-registered-users">
        <div class="px-6 py-5 border-b border-gray-100 bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-800"><i class="mr-2 text-indigo-500 ri-group-2-line"></i>Registered Students ({{ $registeredUsers->count() }})</h3>
            <p class="mt-1 text-sm text-slate-500">Siswa yang telah mengisi form pendaftaran beserta statusnya.</p>
        </div>
        <div class="overflow-y-auto max-h-96">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-10 bg-white shadow-sm">
                    <tr class="text-xs font-bold tracking-wider uppercase border-b text-slate-500 border-gray-100">
                        <th class="px-6 py-3">Nama Lengkap</th>
                        <th class="px-6 py-3">Kontak</th>
                        <th class="px-6 py-3">Jalur & Jurusan</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($registeredUsers as $reg)
                    <tr class="transition-colors duration-200 hover:bg-slate-50/80">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-700">{{ $reg->user->name ?? '-' }}</p>
                            <p class="text-xs text-slate-400">Terdaftar: {{ $reg->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-600"><i class="mr-1 ri-mail-line"></i>{{ $reg->user->email ?? '-' }}</p>
                            @if($reg->user && $reg->user->telp)
                            <p class="text-xs text-slate-500"><i class="mr-1 ri-phone-line"></i>{{ $reg->user->telp }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-700">{{ $reg->jalurPendaftaran->nama ?? '-' }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ $reg->jurusan->nama ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($reg->status === 'pending')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-600">Pending</span>
                            @elseif($reg->status === 'diterima')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-600">Diterima</span>
                            @elseif($reg->status === 'ditolak')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-600">Ditolak</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold bg-gray-100 rounded-full text-slate-600">{{ ucfirst($reg->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.siswa.detail', $reg->user_id) }}" class="inline-flex items-center justify-center w-8 h-8 text-white transition-colors bg-indigo-500 rounded-lg hover:bg-indigo-600" title="Lihat Detail Siswa">
                                <i class="ri-eye-line"></i>
                            </a>
                            @if($reg->user && $reg->user->telp)
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $reg->user->telp)) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 text-white transition-colors bg-emerald-500 rounded-lg hover:bg-emerald-600" title="Hubungi via WhatsApp">
                                <i class="ri-whatsapp-line"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                            <p class="text-sm font-medium">Tidak ada data siswa terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Script Initialization -->
    @script
    <script>
        let chartInstance = null;
        
        function initChart(chartData) {
            const ctx = document.getElementById('monthlyTrendChart');
            if (!ctx) return;

            if (chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Pendaftar (Isi Form)',
                            data: chartData.pendaftar,
                            backgroundColor: '#10b981', // emerald-500
                            borderRadius: 4,
                        },
                        {
                            label: 'Account Only',
                            data: chartData.akun_only,
                            backgroundColor: '#f59e0b', // amber-500
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { usePointStyle: true, boxWidth: 8 }
                        }
                    }
                }
            });
        }

        // Initialize chart on first load
        initChart(@json($chartData));

        // Re-initialize chart when Livewire updates the component
        Livewire.hook('morph.updated', () => {
            initChart(@json($chartData));
        });
    </script>
    @endscript
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
<script>
    function startTour() {
        const driverObj = window.driver.js.driver({
            showProgress: true,
            animate: true,
            nextBtnText: 'Next',
            prevBtnText: 'Previous',
            doneBtnText: 'Done',
            steps: [
                {
                    element: '#tour-header',
                    popover: {
                        title: 'Welcome to Recapitulation',
                        description: 'This page provides an automatic summary of total applicants without the need for manual calculation.',
                        side: 'bottom', align: 'start'
                    }
                },
                {
                    element: '#tour-stats',
                    popover: {
                        title: 'Main Metrics',
                        description: 'The numbers here represent the overall status. "Account Only" means they have not filled out the form yet. You can also see the application conversion percentage.',
                        side: 'bottom', align: 'center'
                    }
                },
                {
                    element: '#tour-table',
                    popover: {
                        title: 'Major Distribution',
                        description: 'View the detailed breakdown of students per major. This is useful for monitoring class quotas.',
                        side: 'top', align: 'center'
                    }
                },
                {
                    element: '#tour-export-buttons',
                    popover: {
                        title: 'Print Reports',
                        description: 'Use these buttons to download the recapitulation in Excel or PDF format to report to the leadership.',
                        side: 'left', align: 'center'
                    }
                }
            ]
        });
        
        driverObj.drive();
    }
</script>
@endpush
