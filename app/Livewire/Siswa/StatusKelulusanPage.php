<?php

namespace App\Livewire\Siswa;

use App\Models\Pendaftaran\PendaftaranMurid;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.siswa")]
#[Title("Hasil Seleksi")]
class StatusKelulusanPage extends Component
{
    public $status = 'pending';
    public $isOpen = false;
    public $dataPendaftaran;
    public $user;
    public $register_setting;
    public $schoolName;

    public function mount()
    {
        $this->user = Auth::user();
        $this->register_setting = \App\Models\Admin\SchoolSetting::getCached();
        
        // Prioritize finding ACCCEPTED status
        $acceptedRegistration = PendaftaranMurid::with('tipeSekolah')->where('user_id', $this->user->id)
            ->where('status', 'diterima')
            ->latest()
            ->first();

        if ($acceptedRegistration) {
            $this->status = 'diterima';
            $this->dataPendaftaran = $acceptedRegistration;
        } else {
            // If not accepted, check latest status
            $latestRegistration = PendaftaranMurid::with('tipeSekolah')->where('user_id', $this->user->id)
                ->latest()
                ->first();
            
            if ($latestRegistration) {
                $this->status = $latestRegistration->status;
                $this->dataPendaftaran = $latestRegistration;
                $this->status = 'belum_daftar';
            }
        }
        
        $this->schoolName = $this->getDynamicSchoolName();
    }

    public function getDynamicSchoolName()
    {
        if ($this->dataPendaftaran && $this->dataPendaftaran->tipeSekolah) {
            $tipe = strtoupper($this->dataPendaftaran->tipeSekolah->nama);
            if (str_contains($tipe, 'SMK')) {
                return 'SMK Taruna Nusantara Jaya';
            }
            if (str_contains($tipe, 'SMA')) {
                return 'SMA Taruna Nusantara Indonesia';
            }
        }
        return $this->register_setting->nama_sekolah ?? 'Lemdiklat Taruna Nusantara Indonesia';
    }

    public function toggleOpen()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.siswa.status-kelulusan-page');
    }
}
