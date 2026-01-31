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

    public function mount()
    {
        $this->user = Auth::user();
        $this->register_setting = \App\Models\Admin\SchoolSetting::getCached();
        
        // Prioritize finding ACCCEPTED status
        $acceptedRegistration = PendaftaranMurid::where('user_id', $this->user->id)
            ->where('status', 'diterima')
            ->latest()
            ->first();

        if ($acceptedRegistration) {
            $this->status = 'diterima';
            $this->dataPendaftaran = $acceptedRegistration;
        } else {
            // If not accepted, check latest status
            $latestRegistration = PendaftaranMurid::where('user_id', $this->user->id)
                ->latest()
                ->first();
            
            if ($latestRegistration) {
                $this->status = $latestRegistration->status;
                $this->dataPendaftaran = $latestRegistration;
            } else {
                $this->status = 'belum_daftar';
            }
        }
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
