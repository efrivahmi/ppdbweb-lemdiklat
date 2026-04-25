<div class="min-h-screen p-4 md:p-8 relative">
    <!-- Fixed Background Blobs (Global Backdrop) -->
    <div class="fixed top-[-10%] left-[-10%] w-[50%] h-[50%] bg-indigo-300/20 rounded-full blur-[120px] animate-pulse z-0 pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-emerald-300/20 rounded-full blur-[120px] animate-pulse z-0 pointer-events-none" style="animation-delay: 2s;"></div>
    <div class="fixed top-[30%] left-[20%] w-[30%] h-[30%] bg-rose-200/10 rounded-full blur-[100px] animate-pulse z-0 pointer-events-none" style="animation-delay: 4s;"></div>

    <div class="relative z-10">
        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Header Section -->
        <div class="flex flex-col items-start justify-between gap-6 mb-10 md:flex-row md:items-center">
            <div>
                <h1 class="text-4xl font-black tracking-tight text-slate-900 mb-2" id="tour-header">
                    Admission <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500">Recapitulation</span>
                </h1>
                <p class="text-slate-500 font-medium flex items-center gap-2">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-ping"></span>
                    Real-time enrollment statistics and trends.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4" id="tour-export-buttons">
                <!-- Filter Dropdown (Glass Style) -->
                <div class="relative group">
                    <select wire:model.live="filterPeriod" class="appearance-none pl-5 pr-12 py-3 text-sm font-bold text-slate-700 bg-white/60 backdrop-blur-md border border-white shadow-xl rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="all">Semua Waktu</option>
                        <option value="this_semester">Semester Ini</option>
                        <option value="last_semester">Semester Lalu</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="last_month">Bulan Lalu</option>
                        <option value="custom">Custom Range</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-indigo-500">
                        <i class="ri-calendar-event-line text-lg"></i>
                    </div>
                </div>

                @if($filterPeriod === 'custom')
                <div class="flex items-center gap-2 animate-in fade-in slide-in-from-right-4 duration-300">
                    <input type="date" wire:model.live="startDate" class="pl-4 pr-4 py-3 text-sm font-bold text-slate-700 bg-white/60 backdrop-blur-md border border-white shadow-xl rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                    <span class="text-slate-400 font-black">to</span>
                    <input type="date" wire:model.live="endDate" class="pl-4 pr-4 py-3 text-sm font-bold text-slate-700 bg-white/60 backdrop-blur-md border border-white shadow-xl rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
                @endif

                <button onclick="startTour()" class="w-12 h-12 flex items-center justify-center bg-white/60 backdrop-blur-md border border-white rounded-2xl shadow-xl text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 transform hover:scale-110 active:scale-95" title="Page Tour">
                    <i class="text-xl ri-magic-line"></i>
                </button>

                <div class="flex gap-2">
                    <a href="{{ route('ppdb.export.excel', ['period' => $filterPeriod, 'startDate' => $startDate, 'endDate' => $endDate]) }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-500 rounded-2xl shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 hover:shadow-emerald-500/40 transition-all transform hover:-translate-y-1">
                        <i class="text-lg ri-file-excel-2-fill"></i>
                        Excel
                    </a>
                    <a href="{{ route('ppdb.export.pdf', ['period' => $filterPeriod, 'startDate' => $startDate, 'endDate' => $endDate]) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-rose-500 rounded-2xl shadow-lg shadow-rose-500/20 hover:bg-rose-600 hover:shadow-rose-500/40 transition-all transform hover:-translate-y-1">
                        <i class="text-lg ri-file-pdf-2-fill"></i>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid (Premium Glass Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12" id="tour-stats">
            <!-- Card: Total Applicants -->
            <div class="group relative p-8 bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 hover:shadow-indigo-500/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-indigo-500/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                        <i class="text-2xl ri-team-fill"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Total Pendaftar</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-slate-900">{{ $stats['total'] }}</span>
                        <span class="text-emerald-500 font-bold text-sm bg-emerald-50 px-2 py-0.5 rounded-lg">+12%</span>
                    </div>
                </div>
            </div>

            <!-- Card: Pending -->
            <div class="group relative p-8 bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 hover:shadow-amber-500/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-amber-500/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform">
                        <i class="text-2xl ri-time-fill"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Menunggu Review</h3>
                    <span class="text-5xl font-black text-slate-900">{{ $stats['pending'] }}</span>
                </div>
            </div>

            <!-- Card: Accepted -->
            <div class="group relative p-8 bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 hover:shadow-emerald-500/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-emerald-500/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform">
                        <i class="text-2xl ri-checkbox-circle-fill"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Diterima</h3>
                    <span class="text-5xl font-black text-slate-900">{{ $stats['accepted'] }}</span>
                </div>
            </div>

            <!-- Card: Rejected -->
            <div class="group relative p-8 bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 hover:shadow-rose-500/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-rose-500/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-rose-500 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-rose-200 group-hover:scale-110 transition-transform">
                        <i class="text-2xl ri-close-circle-fill"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Ditolak</h3>
                    <span class="text-5xl font-black text-slate-900">{{ $stats['rejected'] }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-12">
            <!-- Chart Section (Glass Look) -->
            <div class="xl:col-span-2 p-8 bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-200/50" id="tour-chart">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-black text-slate-800">Registration Trend</h3>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest">
                        <span class="w-3 h-3 bg-indigo-500 rounded-full"></span>
                        Last 6 Months
                    </div>
                </div>
                <div class="relative h-80">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>

            <!-- Major Recap Section -->
            <div class="p-8 bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 overflow-hidden" id="tour-table">
                <h3 class="text-xl font-black text-slate-800 mb-8">Major Distribution</h3>
                <div class="space-y-6">
                    @foreach($majorRecap as $item)
                    <div class="group">
                        <div class="flex justify-between items-end mb-2">
                            <span class="font-bold text-slate-700">{{ $item->nama_jurusan ?? $item->nama }}</span>
                            <span class="text-sm font-black text-indigo-600">{{ $item->total_applicants }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                            @php
                                $percentage = $stats['total'] > 0 ? ($item->total_applicants / $stats['total']) * 100 : 0;
                            @endphp
                            <div class="bg-gradient-to-r from-indigo-500 to-cyan-400 h-full rounded-full transition-all duration-1000 group-hover:scale-x-105 origin-left" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="flex gap-4 mt-2">
                            <span class="text-[10px] font-bold text-amber-500 uppercase">{{ $item->pending_count }} Pending</span>
                            <span class="text-[10px] font-bold text-emerald-500 uppercase">{{ $item->accepted_count }} Accepted</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Jalur Pendaftaran Grid -->
        <div class="mb-12">
            <h3 class="text-2xl font-black text-slate-800 mb-8 ml-2">Jalur Pendaftaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jalurRecap as $jalur)
                <div class="p-8 bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-xl hover:shadow-2xl transition-all group">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="text-xl ri-rocket-line"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800">{{ $jalur->nama }}</h4>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">{{ $jalur->total_applicants }} Pendaftar</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-center p-3 bg-amber-50/50 rounded-2xl border border-amber-100">
                            <span class="block text-lg font-black text-amber-600">{{ $jalur->pending_count }}</span>
                            <span class="text-[10px] font-bold text-amber-500 uppercase">Wait</span>
                        </div>
                        <div class="text-center p-3 bg-emerald-50/50 rounded-2xl border border-emerald-100">
                            <span class="block text-lg font-black text-emerald-600">{{ $jalur->accepted_count }}</span>
                            <span class="text-[10px] font-bold text-emerald-500 uppercase">Win</span>
                        </div>
                        <div class="text-center p-3 bg-rose-50/50 rounded-2xl border border-rose-100">
                            <span class="block text-lg font-black text-rose-600">{{ $jalur->rejected_count }}</span>
                            <span class="text-[10px] font-bold text-rose-500 uppercase">Fail</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Main Applicants Table (Premium Glass Look) -->
        <div class="bg-white/40 backdrop-blur-2xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 overflow-hidden" id="tour-registered-users">
            <div class="p-8 border-b border-white/60 bg-white/20 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Daftar Calon Siswa</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-1">Real-time Registration List</p>
                </div>
                <div class="bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100 text-indigo-600 text-sm font-bold">
                    {{ $registeredUsers->total() }} Total Applicants
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 border-b border-white/60 bg-white/10">
                            <th class="px-8 py-5">Nama Peserta</th>
                            <th class="px-8 py-5">Kontak</th>
                            <th class="px-8 py-5">Detail Pendaftaran</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/40">
                        @forelse($registeredUsers as $reg)
                        <tr class="group transition-colors hover:bg-white/30">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center font-black text-slate-400 group-hover:from-indigo-500 group-hover:to-cyan-400 group-hover:text-white transition-all shadow-sm">
                                        {{ substr($reg->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $reg->user->name ?? '-' }}</p>
                                        <p class="text-xs font-bold text-slate-400">{{ $reg->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-bold text-slate-600">{{ $reg->user->email ?? '-' }}</p>
                                <p class="text-xs font-medium text-slate-400 italic">{{ $reg->user->telp ?? '-' }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="block text-sm font-black text-slate-800">{{ $reg->jurusan->nama ?? '-' }}</span>
                                <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-wider">{{ $reg->jalurPendaftaran->nama ?? '-' }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-600 ring-amber-500/20',
                                        'diterima' => 'bg-emerald-100 text-emerald-600 ring-emerald-500/20',
                                        'ditolak' => 'bg-rose-100 text-rose-600 ring-rose-500/20',
                                    ];
                                    $class = $statusClasses[$reg->status] ?? 'bg-slate-100 text-slate-600 ring-slate-500/20';
                                @endphp
                                <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full ring-1 {{ $class }}">
                                    {{ $reg->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.siswa.detail', $reg->user_id) }}" class="w-10 h-10 flex items-center justify-center bg-white text-slate-600 rounded-xl border border-slate-100 shadow-sm hover:bg-indigo-600 hover:text-white hover:scale-110 transition-all active:scale-95">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    @if($reg->user && $reg->user->telp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $reg->user->telp)) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-white text-emerald-500 rounded-xl border border-slate-100 shadow-sm hover:bg-emerald-500 hover:text-white hover:scale-110 transition-all active:scale-95">
                                        <i class="ri-whatsapp-line"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="text-4xl text-slate-200 ri-inbox-archive-line"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold tracking-widest uppercase text-xs">Belum ada data pendaftar</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($registeredUsers->hasPages())
            <div class="px-8 py-6 border-t border-white/60 bg-white/20">
                {{ $registeredUsers->links() }}
            </div>
            @endif
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

            const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.6)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Jumlah Pendaftar',
                            data: chartData.pendaftar,
                            backgroundColor: gradient,
                            borderColor: '#4f46e5',
                            borderWidth: 4,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: { font: { weight: 'bold' }, color: '#94a3b8' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: 'bold' }, color: '#94a3b8' }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            cornerRadius: 12,
                            displayColors: false
                        }
                    }
                }
            });
        }

        initChart(@json($chartData));

        Livewire.hook('morph.updated', () => {
            initChart(@json($chartData));
        });
    </script>
    @endscript

    <!-- Casual Loading Indicator (Forced Center Pill) -->
    <div wire:loading wire:target="filterPeriod, startDate, endDate" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[9999] animate-in fade-in zoom-in-95 duration-300">
        <div class="px-6 py-3 bg-white/90 backdrop-blur-3xl border border-white/50 shadow-2xl rounded-full flex items-center gap-3 border-indigo-100/50">
            <div class="w-5 h-5 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm font-black text-slate-800 whitespace-nowrap">Syncing Data...</span>
        </div>
    </div>

    <!-- Minimalist Blur Effect -->
    <style>
        [wire\:loading] ~ .relative.z-10 {
            filter: blur(2px);
            opacity: 0.9;
            transition: all 0.3s ease;
            pointer-events: none;
        }
    </style>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
<script>
    function startTour() {
        const driverObj = window.driver.js.driver({
            showProgress: true,
            animate: true,
            steps: [
                { element: '#tour-header', popover: { title: 'Dashboard Premium', description: 'Monitor data pendaftaran real-time dengan tampilan modern.' }},
                { element: '#tour-stats', popover: { title: 'Statistik Utama', description: 'Status pendaftaran (Diterima, Pending, Ditolak) dapat dilihat di sini.' }},
                { element: '#tour-chart', popover: { title: 'Tren Pendaftaran', description: 'Analisis pertumbuhan pendaftar dalam 6 bulan terakhir.' }},
                { element: '#tour-registered-users', popover: { title: 'Daftar Pendaftar', description: 'Kelola data calon siswa langsung dari tabel ini.' }},
            ]
        });
        driverObj.drive();
    }
</script>
@endpush
