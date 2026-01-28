<?php

use App\Models\User;
use Livewire\Volt\Component;

/**
 * Recent Registrations Card (Livewire Volt - 2026 Style)
 * 
 * Shows latest registrations with auto-refresh.
 */
new class extends Component
{
    public array $registrations = [];
    public int $todayCount = 0;

    public function mount(): void
    {
        $this->refreshRegistrations();
    }

    public function refreshRegistrations(): void
    {
        $recent = User::where('role', 'siswa')
            ->latest()
            ->take(5)
            ->get();

        $this->registrations = $recent->map(fn($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'nisn' => $u->nisn,
            'created_at' => $u->created_at->diffForHumans(),
            'avatar' => $u->getProfilePhotoUrlAttribute(),
        ])->toArray();

        // Count today's registrations
        $this->todayCount = User::where('role', 'siswa')
            ->whereDate('created_at', today())
            ->count();
    }
};
?>

{{-- Auto-refresh every 30 seconds --}}
<div wire:poll.30s="refreshRegistrations" class="bg-white rounded-xl border border-gray-200 p-4">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-lime-100 flex items-center justify-center">
                <x-lucide-user-plus class="w-4 h-4 text-lime-600" />
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Pendaftar Terbaru</h3>
                <p class="text-xs text-gray-500">Registrasi baru</p>
            </div>
        </div>
        <span class="px-2 py-1 text-xs font-medium text-lime-700 bg-lime-100 rounded-full">
            +{{ $todayCount }} hari ini
        </span>
    </div>

    @if(count($registrations) > 0)
        <div class="space-y-2">
            @foreach($registrations as $reg)
                <div class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                    <img src="{{ $reg['avatar'] }}" alt="{{ $reg['name'] }}" 
                         class="w-8 h-8 rounded-full object-cover">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $reg['name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $reg['nisn'] }} • {{ $reg['created_at'] }}</p>
                    </div>
                    <a href="{{ route('admin.siswa.detail', $reg['id']) }}" 
                       class="text-xs text-lime-600 hover:text-lime-700">
                        Detail →
                    </a>
                </div>
            @endforeach
        </div>

        <a href="{{ route('admin.siswa') }}" 
           class="block mt-3 text-center text-xs text-lime-600 hover:text-lime-700">
            Lihat semua pendaftar
        </a>
    @else
        <div class="text-center py-6">
            <x-lucide-users class="w-10 h-10 mx-auto text-gray-300 mb-2" />
            <p class="text-sm text-gray-500">Belum ada pendaftar</p>
        </div>
    @endif

    {{-- Live indicator --}}
    <div class="mt-3 flex items-center justify-center gap-1 text-xs text-gray-400">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-lime-500"></span>
        </span>
        Live updates
    </div>
</div>
