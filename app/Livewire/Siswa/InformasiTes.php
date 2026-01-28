<?php

namespace App\Livewire\Siswa;

use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\TesJalur;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.siswa")]
#[Title("Informasi Test")]
class InformasiTes extends Component
{
    public $jalurData = [];

    public function mount()
    {
        $this->loadPendaftaranData();
    }

    public function loadPendaftaranData()
    {
        // Ambil semua pendaftaran siswa
        $pendaftaranList = PendaftaranMurid::with(['jalurPendaftaran', 'tipeSekolah', 'jurusan'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by jalur pendaftaran
        $groupedByJalur = $pendaftaranList->groupBy('jalur_pendaftaran_id');

        $this->jalurData = [];
        foreach ($groupedByJalur as $jalurId => $pendaftaranGroup) {
            $firstPendaftaran = $pendaftaranGroup->first();
            
            // Format program studi
            $programStudi = [];
            foreach ($pendaftaranGroup as $pendaftaran) {
                $programStudi[] = $pendaftaran->tipeSekolah->nama . ' - ' . $pendaftaran->jurusan->nama;
            }

            // Ambil informasi tes untuk jalur ini
            $tesJalur = TesJalur::where('jalur_pendaftaran_id', $jalurId)
                ->orderBy('nama_tes')
                ->get();

            $this->jalurData[] = [
                'jalur' => $firstPendaftaran->jalurPendaftaran,
                'program_studi' => $programStudi,
                'status' => $pendaftaranGroup->pluck('status')->unique()->toArray(),
                'tes_informasi' => $tesJalur,
                'created_at' => $firstPendaftaran->created_at
            ];
        }
    }

    public function render()
    {
        return view('livewire.siswa.informasi-tes');
    }
}