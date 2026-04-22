<div class="min-h-screen p-6 bg-transparent">
    <!-- Header Section -->
    <div class="flex flex-col items-start justify-between gap-4 mb-8 md:flex-row md:items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 to-slate-500" id="tour-header">
                Admission Recapitulation
            </h1>
            <p class="mt-1 text-sm font-medium text-slate-500">Monitor real-time enrollment statistics and movements.</p>
        </div>
        
        <div class="flex items-center gap-3" id="tour-export-buttons">
            <button onclick="startTour()" class="flex items-center justify-center w-10 h-10 transition-all duration-300 bg-white border border-gray-200 rounded-full shadow-sm text-slate-500 hover:bg-slate-50 hover:text-indigo-600 hover:shadow-md hover:-translate-y-0.5" title="Page Tour">
                <i class="text-xl ri-guide-line"></i>
            </button>

            <a href="{{ route('ppdb.export.excel') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white transition-all duration-300 shadow-lg rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                <i class="text-lg ri-file-excel-2-line"></i>
                Export Excel
            </a>
            <a href="{{ route('ppdb.export.pdf') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white transition-all duration-300 shadow-lg rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 hover:shadow-rose-500/30 hover:-translate-y-0.5">
                <i class="text-lg ri-file-pdf-2-line"></i>
                Print PDF
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 mb-8 sm:grid-cols-2 lg:grid-cols-6" id="tour-stats">
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
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-blue-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-wallet-3-line text-blue-500"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-blue-600">Payment</p>
            <p class="mt-3 text-4xl font-extrabold text-blue-600">{{ $stats['payment'] }}</p>
            <p class="mt-3 text-xs font-medium text-blue-500/70">Proses pembayaran</p>
        </div>

        <!-- Card 5 -->
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-emerald-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-checkbox-circle-line text-emerald-500"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-emerald-600">Accepted (ACC)</p>
            <p class="mt-3 text-4xl font-extrabold text-emerald-600">{{ $stats['accepted'] }}</p>
            <p class="mt-3 text-xs font-medium text-emerald-500/70">Diterima</p>
        </div>

        <!-- Card 6 -->
        <div class="relative overflow-hidden transition-all duration-300 bg-white/80 backdrop-blur-xl border border-rose-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="text-6xl ri-close-circle-line text-rose-500"></i>
            </div>
            <p class="text-xs font-bold tracking-wider uppercase text-rose-600">Rejected</p>
            <p class="mt-3 text-4xl font-extrabold text-rose-600">{{ $stats['rejected'] }}</p>
            <p class="mt-3 text-xs font-medium text-rose-500/70">Ditolak</p>
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
                        <th class="px-6 py-4 text-blue-600">Payment</th>
                        <th class="px-6 py-4 text-emerald-600">Accepted</th>
                        <th class="px-6 py-4 text-rose-600">Rejected</th>
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
                        <td class="px-6 py-4 text-sm font-medium text-blue-600">
                            <span class="px-2 py-1 bg-blue-50 rounded-md">{{ $item->payment_count }}</span>
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
                        <td colspan="6" class="px-6 py-12 text-center">
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
