<?php

use App\Models\Siswa\BuktiTransfer;
use Livewire\Volt\Component;

/**
 * Pending Transfers Card (Livewire Volt - 2026 Style)
 * 
 * Shows pending transfers that need verification with auto-refresh.
 */
new class extends Component
{
    public array $transfers = [];
    public int $pendingCount = 0;

    public function mount(): void
    {
        $this->refreshTransfers();
    }

    public function refreshTransfers(): void
    {
        $pending = BuktiTransfer::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $this->transfers = $pending->map(fn($t) => [
            'id' => $t->id,
            'user_name' => $t->user->name ?? 'Unknown',
            'user_nisn' => $t->user->nisn ?? '-',
            'created_at' => $t->created_at->diffForHumans(),
            'image' => $t->image,
        ])->toArray();

        $this->pendingCount = BuktiTransfer::where('status', 'pending')->count();
    }
};
?>

{{-- Auto-refresh every 15 seconds for urgent items --}}
<div wire:poll.15s="refreshTransfers" class="bg-white rounded-xl border border-gray-200 p-4">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center">
                <x-lucide-clock class="w-4 h-4 text-yellow-600" />
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Transfer Pending</h3>
                <p class="text-xs text-gray-500">Perlu verifikasi</p>
            </div>
        </div>
        @if($pendingCount > 0)
            <span class="px-2 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded-full animate-pulse">
                {{ $pendingCount }} pending
            </span>
        @else
            <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                Semua terverifikasi
            </span>
        @endif
    </div>

    @if(count($transfers) > 0)
        <div class="space-y-2">
            @foreach($transfers as $transfer)
                <div class="flex items-center gap-3 p-2 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-yellow-200 flex items-center justify-center text-yellow-700 text-xs font-bold">
                        {{ substr($transfer['user_name'], 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $transfer['user_name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $transfer['user_nisn'] }} • {{ $transfer['created_at'] }}</p>
                    </div>
                    <a href="{{ route('admin.pembayaran.bukti-transfer') }}" 
                       class="px-2 py-1 text-xs font-medium text-yellow-700 hover:text-yellow-900">
                        Verifikasi →
                    </a>
                </div>
            @endforeach
        </div>

        @if($pendingCount > 5)
            <a href="{{ route('admin.pembayaran.bukti-transfer') }}" 
               class="block mt-3 text-center text-xs text-lime-600 hover:text-lime-700">
                Lihat semua ({{ $pendingCount }})
            </a>
        @endif
    @else
        <div class="text-center py-6">
            <x-lucide-check-circle class="w-10 h-10 mx-auto text-green-400 mb-2" />
            <p class="text-sm text-gray-500">Tidak ada transfer pending</p>
        </div>
    @endif

    {{-- Live indicator --}}
    <div class="mt-3 flex items-center justify-center gap-1 text-xs text-gray-400">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
        </span>
        Update setiap 15 detik
    </div>
</div>
