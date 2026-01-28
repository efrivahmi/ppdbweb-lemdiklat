@props([
    'overallProgress' => 0,
    'completedSections' => 0,
    'totalSections' => 4,
])

@php
    $progressColor = match(true) {
        $overallProgress >= 100 => 'from-lime-500 to-green-500',
        $overallProgress >= 75 => 'from-lime-500 to-lime-600',
        $overallProgress >= 50 => 'from-yellow-500 to-lime-500',
        default => 'from-orange-400 to-yellow-500',
    };
    
    $statusColor = match(true) {
        $overallProgress >= 100 => 'text-lime-600 bg-lime-50 border-lime-200',
        $overallProgress >= 75 => 'text-lime-600 bg-lime-50 border-lime-200',
        $overallProgress >= 50 => 'text-yellow-600 bg-yellow-50 border-yellow-200',
        default => 'text-orange-600 bg-orange-50 border-orange-200',
    };
@endphp

<div class="relative overflow-hidden bg-gradient-to-br from-white to-gray-50 border border-gray-200 shadow-lg rounded-2xl mt-6 p-6">
    {{-- Decorative Background --}}
    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-lime-100 to-transparent rounded-full -translate-y-1/2 translate-x-1/2 opacity-60"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-lime-50 to-transparent rounded-full translate-y-1/2 -translate-x-1/2 opacity-40"></div>
    
    <div class="relative z-10">
        {{-- Header with Live Badge --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br {{ $progressColor }} rounded-xl flex items-center justify-center shadow-lg">
                    <i class="ri-bar-chart-box-line text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Progress Keseluruhan</h3>
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-lime-500"></span>
                        </span>
                        <span class="text-xs text-gray-500">Live update</span>
                    </div>
                </div>
            </div>
            
            {{-- Progress Circle --}}
            <div class="relative w-20 h-20">
                <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <path class="text-lime-500 transition-all duration-1000" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none" stroke-dasharray="{{ $overallProgress }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xl font-bold text-gray-800">{{ number_format($overallProgress, 0) }}%</span>
                </div>
            </div>
        </div>
        
        {{-- Progress Bar --}}
        <div class="mb-4">
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-600 font-medium">Kelengkapan Data</span>
                <span class="font-bold text-gray-800">{{ $completedSections }}/{{ $totalSections }} bagian</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r {{ $progressColor }} h-3 rounded-full transition-all duration-1000 relative" 
                     style="width: {{ $overallProgress }}%">
                    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                </div>
            </div>
        </div>
        
        {{-- Status Message --}}
        <div class="flex items-center gap-2 p-3 rounded-xl border {{ $statusColor }}">
            @if($overallProgress >= 100)
                <div class="w-8 h-8 bg-lime-100 rounded-full flex items-center justify-center">
                    <i class="ri-check-line text-lime-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-sm">Semua data sudah lengkap!</p>
                    <p class="text-xs opacity-80">Anda dapat melanjutkan ke tahap berikutnya</p>
                </div>
            @else
                <div class="w-8 h-8 bg-current/10 rounded-full flex items-center justify-center">
                    <i class="ri-information-line text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-sm">{{ $totalSections - $completedSections }} bagian perlu dilengkapi</p>
                    <p class="text-xs opacity-80">Lengkapi semua data untuk melanjutkan</p>
                </div>
            @endif
        </div>
    </div>
</div>