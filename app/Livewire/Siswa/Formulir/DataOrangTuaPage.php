<?php

namespace App\Livewire\Siswa\Formulir;

use App\Models\Siswa\DataOrangTua;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.siswa")]
#[Title("Data Orang Tua")]
class DataOrangTuaPage extends Component
{
    public ?int $user_id = null;

    // Ayah
    public ?string $nama_ayah = null;
    public ?string $pendidikan_ayah = null;
    public ?string $telp_ayah = null;
    public ?string $pekerjaan_ayah = null;
    public ?string $alamat_ayah = null;
    public ?string $penghasilan_ayah = null;

    // Ibu
    public ?string $nama_ibu = null;
    public ?string $pendidikan_ibu = null;
    public ?string $telp_ibu = null;
    public ?string $pekerjaan_ibu = null;
    public ?string $alamat_ibu = null;
    public ?string $penghasilan_ibu = null;

    // Wali (opsional)
    public ?string $nama_wali = null;
    public ?string $pendidikan_wali = null;
    public ?string $telp_wali = null;
    public ?string $pekerjaan_wali = null;
    public ?string $alamat_wali = null;
    public ?string $penghasilan_wali = null;

    // progress
    public int $proses = 0;

    public function mount(): void
    {
        $this->user_id = Auth::id();
        $this->loadOrangTuaData();
        $this->proses = $this->checkRequiredFilled() ? 1 : 0;
    }

    protected function loadOrangTuaData(): void
    {
        $data = DataOrangTua::where('user_id', $this->user_id)->first();

        if ($data) {
            // Ayah
            $this->nama_ayah = $data->nama_ayah;
            $this->pendidikan_ayah = $data->pendidikan_ayah;
            $this->telp_ayah = $data->telp_ayah;
            $this->pekerjaan_ayah = $data->pekerjaan_ayah;
            $this->alamat_ayah = $data->alamat_ayah;
            $this->penghasilan_ayah = $data->penghasilan_ayah;

            // Ibu
            $this->nama_ibu = $data->nama_ibu;
            $this->pendidikan_ibu = $data->pendidikan_ibu;
            $this->telp_ibu = $data->telp_ibu;
            $this->pekerjaan_ibu = $data->pekerjaan_ibu;
            $this->alamat_ibu = $data->alamat_ibu;
            $this->penghasilan_ibu = $data->penghasilan_ibu;

            // Wali (opsional)
            $this->nama_wali = $data->nama_wali;
            $this->pendidikan_wali = $data->pendidikan_wali;
            $this->telp_wali = $data->telp_wali;
            $this->pekerjaan_wali = $data->pekerjaan_wali;
            $this->alamat_wali = $data->alamat_wali;
            $this->penghasilan_wali = $data->penghasilan_wali;
        } else {
            DataOrangTua::create(['user_id' => $this->user_id]);
        }
    }

    protected array $rules = [
        // Ayah (wajib)
        'nama_ayah' => 'required|string|max:255',
        'pendidikan_ayah' => 'required|string|max:50',
        'telp_ayah' => 'required|string|max:20',
        'pekerjaan_ayah' => 'required|string|max:50',
        'alamat_ayah' => 'required|string|max:255',
        'penghasilan_ayah' => 'required|string|max:50',

        // Ibu (wajib)
        'nama_ibu' => 'required|string|max:255',
        'pendidikan_ibu' => 'required|string|max:50',
        'telp_ibu' => 'required|string|max:20',
        'pekerjaan_ibu' => 'required|string|max:50',
        'alamat_ibu' => 'required|string|max:255',
        'penghasilan_ibu' => 'required|string|max:50',

        // Wali (opsional)
        'nama_wali' => 'nullable|string|max:255',
        'pendidikan_wali' => 'nullable|string|max:50',
        'telp_wali' => 'nullable|string|max:20',
        'pekerjaan_wali' => 'nullable|string|max:50',
        'alamat_wali' => 'nullable|string|max:255',
        'penghasilan_wali' => 'nullable|string|max:50',
    ];

    public function getPenghasilanOptions()
    {
        return DataOrangTua::getPenghasilanOptions();
    }

    public function getPekerjaanOptions()
    {
        return DataOrangTua::getPekerjaanOptions();
    }

    public function checkRequiredFilled(): bool
    {
        return !empty($this->nama_ayah)
            && !empty($this->pendidikan_ayah)
            && !empty($this->telp_ayah)
            && !empty($this->pekerjaan_ayah)
            && !empty($this->alamat_ayah)
            && !empty($this->penghasilan_ayah)
            && !empty($this->nama_ibu)
            && !empty($this->pendidikan_ibu)
            && !empty($this->telp_ibu)
            && !empty($this->pekerjaan_ibu)
            && !empty($this->alamat_ibu)
            && !empty($this->penghasilan_ibu);
    }

    public function getProgress(): int
    {
        $fields = [
            'nama_ayah',
            'pendidikan_ayah',
            'telp_ayah',
            'pekerjaan_ayah',
            'alamat_ayah',
            'penghasilan_ayah',
            'nama_ibu',
            'pendidikan_ibu',
            'telp_ibu',
            'pekerjaan_ibu',
            'alamat_ibu',
            'penghasilan_ibu'
        ];

        $filled = collect($fields)->filter(fn($f) => !empty($this->$f))->count();

        return (int)(($filled / count($fields)) * 100);
    }

    public function update()
    {
        $this->validate();

        $this->proses = $this->checkRequiredFilled() ? 1 : 0;

        DataOrangTua::updateOrCreate(
            ['user_id' => $this->user_id],
            [
                // Ayah
                'nama_ayah' => $this->nama_ayah,
                'pendidikan_ayah' => $this->pendidikan_ayah,
                'telp_ayah' => $this->telp_ayah,
                'pekerjaan_ayah' => $this->pekerjaan_ayah,
                'alamat_ayah' => $this->alamat_ayah,
                'penghasilan_ayah' => $this->penghasilan_ayah,

                // Ibu
                'nama_ibu' => $this->nama_ibu,
                'pendidikan_ibu' => $this->pendidikan_ibu,
                'telp_ibu' => $this->telp_ibu,
                'pekerjaan_ibu' => $this->pekerjaan_ibu,
                'alamat_ibu' => $this->alamat_ibu,
                'penghasilan_ibu' => $this->penghasilan_ibu,

                // Wali opsional
                'nama_wali' => $this->nama_wali,
                'pendidikan_wali' => $this->pendidikan_wali,
                'telp_wali' => $this->telp_wali,
                'pekerjaan_wali' => $this->pekerjaan_wali,
                'alamat_wali' => $this->alamat_wali,
                'penghasilan_wali' => $this->penghasilan_wali,

                'proses' => $this->proses,
            ]
        );

        $this->dispatch("alert", message: "Data orang tua berhasil diperbarui", type: "success");

        return $this->redirectRoute('siswa.formulir.berkas-murid');
    }

    public function getIsCompleteProperty(): bool
    {
        return $this->checkRequiredFilled();
    }


    public function render()
    {
        return view('livewire.siswa.formulir.data-orang-tua-page');
    }
}
