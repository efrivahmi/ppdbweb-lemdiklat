<?php

use App\Models\User;
use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\Siswa\BerkasMurid;
use App\Models\Pendaftaran\PendaftaranMurid;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Student Status Card (Livewire Volt - 2026 Style)
 * 
 * Displays student's registration status with auto-refresh.
 * Uses same logic as Siswa Dashboard for consistency.
 */
new class extends Component
{
    public array $status = [];
    public array $progress = [];
    public int $completionPercentage = 0;
    public int $dataMuridProgress = 0;
    public int $dataOrangTuaProgress = 0;
    public int $berkasMuridProgress = 0;
    public int $pendaftaranProgress = 0;

    public function mount(): void
    {
        $this->refreshStatus();
    }

    public function refreshStatus(): void
    {
        $userId = Auth::id();
        
        if (!$userId) return;

        // Progress Data Murid (same as Siswa Dashboard)
        $dataMurid = DataMurid::where('user_id', $userId)->first();
        if ($dataMurid) {
            $fields = ['tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'agama', 'whatsapp', 'alamat', 'asal_sekolah'];
            $filled = 0;
            foreach ($fields as $field) {
                if (!empty($dataMurid->$field)) $filled++;
            }
            $this->dataMuridProgress = round(($filled / count($fields)) * 100);
        }

        // Progress Data Orang Tua (same as Siswa Dashboard)
        $dataOrangTua = DataOrangTua::where('user_id', $userId)->first();
        if ($dataOrangTua) {
            $grupData = [
                'ayah' => ['nama_ayah', 'pendidikan_ayah', 'telp_ayah', 'pekerjaan_ayah', 'alamat_ayah'],
                'ibu' => ['nama_ibu', 'pendidikan_ibu', 'telp_ibu', 'pekerjaan_ibu', 'alamat_ibu'],
                'wali' => ['nama_wali', 'pendidikan_wali', 'telp_wali', 'pekerjaan_wali', 'alamat_wali'],
            ];

            $progress = 0;
            foreach ($grupData as $grup) {
                $lengkap = true;
                foreach ($grup as $field) {
                    if (empty($dataOrangTua->$field)) {
                        $lengkap = false;
                        break;
                    }
                }
                if ($lengkap) {
                    $progress = 100;
                    break;
                }
            }
            $this->dataOrangTuaProgress = $progress;
        }

        // Progress Berkas Murid (same as Siswa Dashboard)
        $berkasMurid = BerkasMurid::where('user_id', $userId)->first();
        if ($berkasMurid) {
            $fields = ['kk', 'ktp_ortu', 'akte', 'surat_sehat', 'pas_foto'];
            $filled = 0;
            foreach ($fields as $field) {
                if (!empty($berkasMurid->$field)) $filled++;
            }
            $this->berkasMuridProgress = round(($filled / count($fields)) * 100);
        }

        // Progress Pendaftaran
        $pendaftaranCount = PendaftaranMurid::where('user_id', $userId)->count();
        $this->pendaftaranProgress = $pendaftaranCount > 0 ? 100 : 0;

        // Overall Progress
        $this->completionPercentage = round(
            ($this->dataMuridProgress + $this->dataOrangTuaProgress + 
             $this->berkasMuridProgress + $this->pendaftaranProgress) / 4
        );

        // Build progress steps
        $this->progress = [
            [
                'name' => 'Akun Terdaftar',
                'completed' => true,
                'progress' => 100,
                'icon' => 'user-check',
            ],
            [
                'name' => 'Data Diri',
                'completed' => $this->dataMuridProgress >= 100,
                'progress' => $this->dataMuridProgress,
                'icon' => 'file-text',
                'route' => 'siswa.formulir.data-murid',
            ],
            [
                'name' => 'Data Orang Tua',
                'completed' => $this->dataOrangTuaProgress >= 100,
                'progress' => $this->dataOrangTuaProgress,
                'icon' => 'users',
                'route' => 'siswa.formulir.data-orang-tua',
            ],
            [
                'name' => 'Upload Berkas',
                'completed' => $this->berkasMuridProgress >= 100,
                'progress' => $this->berkasMuridProgress,
                'icon' => 'folder-open',
                'route' => 'siswa.formulir.berkas-murid',
            ],
            [
                'name' => 'Pendaftaran',
                'completed' => $this->pendaftaranProgress >= 100,
                'progress' => $this->pendaftaranProgress,
                'icon' => 'file-list',
                'route' => 'siswa.pendaftaran',
            ],
        ];

        // Get latest pendaftaran status
        $user = Auth::user();
        $user->load(['buktiTransfer', 'pendaftaranMurids']);
        $pendaftaran = $user->pendaftaranMurids()->latest()->first();
        
        $this->status = [
            'pendaftaran' => $pendaftaran?->status ?? 'belum_mendaftar',
            'pembayaran' => $user->buktiTransfer?->status ?? 'belum_upload',
        ];
    }
};
?>

{{-- Auto-refresh every 60 seconds --}}
<div wire:poll.60s="refreshStatus" class="bg-white rounded-xl border border-gray-200 p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Status Pendaftaran</h3>
            <p class="text-sm text-gray-500">Progress pengisian data</p>
        </div>
        <div class="text-right">
            <span class="text-3xl font-bold text-lime-600">{{ $completionPercentage }}%</span>
            <p class="text-xs text-gray-500">Selesai</p>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
        <div class="bg-gradient-to-r from-lime-500 to-green-500 h-3 rounded-full transition-all duration-500"
             style="width: {{ $completionPercentage }}%"></div>
    </div>

    {{-- Steps --}}
    <div class="space-y-3">
        @foreach($progress as $step)
            <div class="flex items-center gap-3 p-3 rounded-lg {{ $step['completed'] ? 'bg-lime-50' : 'bg-gray-50' }}">
                {{-- Status Icon --}}
                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $step['completed'] ? 'bg-lime-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                    @if($step['completed'])
                        <x-lucide-check class="w-4 h-4" />
                    @else
                        @if($step['icon'] === 'user-check')
                            <x-lucide-user class="w-4 h-4" />
                        @elseif($step['icon'] === 'file-text')
                            <x-lucide-file-text class="w-4 h-4" />
                        @elseif($step['icon'] === 'users')
                            <x-lucide-users class="w-4 h-4" />
                        @elseif($step['icon'] === 'folder-open')
                            <x-lucide-folder-open class="w-4 h-4" />
                        @elseif($step['icon'] === 'file-list')
                            <x-lucide-file-text class="w-4 h-4" />
                        @else
                            <x-lucide-circle class="w-4 h-4" />
                        @endif
                    @endif
                </div>

                {{-- Step Info --}}
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium {{ $step['completed'] ? 'text-lime-700' : 'text-gray-700' }}">
                            {{ $step['name'] }}
                        </p>
                        @if(isset($step['progress']))
                            <span class="text-xs font-medium {{ $step['completed'] ? 'text-lime-600' : 'text-gray-500' }}">
                                {{ $step['progress'] }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-xs {{ $step['completed'] ? 'text-lime-600' : 'text-gray-500' }}">
                        {{ $step['completed'] ? 'Selesai' : 'Belum selesai' }}
                    </p>
                </div>

                {{-- Action --}}
                @if(!$step['completed'] && isset($step['route']))
                    <a href="{{ route($step['route']) }}" 
                       class="px-3 py-1 text-xs font-medium text-lime-700 bg-lime-100 rounded-full hover:bg-lime-200 transition-colors">
                        Lengkapi
                    </a>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Live indicator --}}
    <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-lime-500"></span>
        </span>
        Status diperbarui otomatis
    </div>
</div>
