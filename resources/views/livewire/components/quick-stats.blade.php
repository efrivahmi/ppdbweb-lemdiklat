<?php

use App\Models\User;
use App\Models\Siswa\BuktiTransfer;
use App\Models\Pendaftaran\PendaftaranMurid;
use Livewire\Volt\Component;
use function Livewire\Volt\{state, computed, mount};

/**
 * Quick Stats Component (Livewire Volt - 2026 Style)
 * 
 * This is a functional single-file Livewire component using Volt syntax.
 * It displays real-time statistics with auto-refresh polling.
 */
new class extends Component
{
    // State properties
    public int $totalSiswa = 0;
    public int $pendingTransfers = 0;
    public int $approvedTransfers = 0;
    public int $pendaftaranDiterima = 0;
    public int $pendaftaranDitolak = 0;
    public int $dataLengkap = 0;

    public function mount(): void
    {
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $this->totalSiswa = User::where('role', 'siswa')->count();
        
        $this->pendingTransfers = BuktiTransfer::where('status', 'pending')->count();
        $this->approvedTransfers = BuktiTransfer::where('status', 'success')->count();
        
        $this->pendaftaranDiterima = PendaftaranMurid::where('status', 'diterima')->count();
        $this->pendaftaranDitolak = PendaftaranMurid::where('status', 'ditolak')->count();
        
        // Count students with complete data
        $this->dataLengkap = User::where('role', 'siswa')
            ->whereHas('dataMurid', fn($q) => $q->where('proses', '1'))
            ->whereHas('berkasMurid', fn($q) => $q->where('proses', '1'))
            ->count();
    }

    public function with(): array
    {
        return [
            'stats' => [
                [
                    'label' => 'Total Pendaftar',
                    'value' => $this->totalSiswa,
                    'icon' => 'users',
                    'color' => 'lime',
                    'trend' => '+' . $this->totalSiswa,
                ],
                [
                    'label' => 'Transfer Pending',
                    'value' => $this->pendingTransfers,
                    'icon' => 'clock',
                    'color' => 'yellow',
                    'trend' => $this->pendingTransfers > 0 ? 'Perlu verifikasi' : 'Semua terverifikasi',
                ],
                [
                    'label' => 'Transfer Disetujui',
                    'value' => $this->approvedTransfers,
                    'icon' => 'check-circle',
                    'color' => 'green',
                    'trend' => round(($this->approvedTransfers / max($this->totalSiswa, 1)) * 100) . '%',
                ],
                [
                    'label' => 'Diterima',
                    'value' => $this->pendaftaranDiterima,
                    'icon' => 'user-check',
                    'color' => 'emerald',
                    'trend' => 'Siswa diterima',
                ],
                [
                    'label' => 'Data Lengkap',
                    'value' => $this->dataLengkap,
                    'icon' => 'file-check',
                    'color' => 'blue',
                    'trend' => round(($this->dataLengkap / max($this->totalSiswa, 1)) * 100) . '% lengkap',
                ],
            ],
        ];
    }
};
?>

{{-- Auto-refresh every 30 seconds --}}
<div wire:poll.30s="refreshStats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
    @foreach($stats as $stat)
        <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stat['value']) }}</p>
                    <p class="text-xs text-{{ $stat['color'] }}-600 mt-1">{{ $stat['trend'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-{{ $stat['color'] }}-100 flex items-center justify-center">
                    @if($stat['icon'] === 'users')
                        <x-lucide-users class="w-6 h-6 text-{{ $stat['color'] }}-600" />
                    @elseif($stat['icon'] === 'clock')
                        <x-lucide-clock class="w-6 h-6 text-{{ $stat['color'] }}-600" />
                    @elseif($stat['icon'] === 'check-circle')
                        <x-lucide-check-circle class="w-6 h-6 text-{{ $stat['color'] }}-600" />
                    @elseif($stat['icon'] === 'user-check')
                        <x-lucide-user-check class="w-6 h-6 text-{{ $stat['color'] }}-600" />
                    @elseif($stat['icon'] === 'file-check')
                        <x-lucide-file-check class="w-6 h-6 text-{{ $stat['color'] }}-600" />
                    @endif
                </div>
            </div>
            
            {{-- Live indicator --}}
            <div class="mt-3 flex items-center gap-1">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $stat['color'] }}-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-{{ $stat['color'] }}-500"></span>
                </span>
                <span class="text-xs text-gray-400">Live</span>
            </div>
        </div>
    @endforeach
</div>
