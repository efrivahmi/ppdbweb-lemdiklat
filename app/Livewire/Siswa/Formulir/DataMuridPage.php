<?php

namespace App\Livewire\Siswa\Formulir;

use App\Models\Siswa\DataMurid;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.siswa")]
#[Title("Data Murid")]
class DataMuridPage extends Component
{
    // Properti publik
    public ?int $user_id = null;
    public ?string $nomor_kartu_keluarga = null;
    public ?string $tempat_lahir = null;
    public ?string $tgl_lahir = null;
    public string $jenis_kelamin = 'Laki-laki'; // Default value
    public ?string $agama = null;
    public ?string $whatsapp = null;
    public ?string $alamat = null;
    public ?string $asal_sekolah = null;
    public ?string $berat_badan = null;
    public ?string $tinggi_badan = null;
    public ?string $riwayat_penyakit = null;
    public string $proses = '0';

    // Options untuk jenis kelamin
    public array $jenisKelaminOptions = [
        'Laki-laki' => 'Laki-laki',
        'Perempuan' => 'Perempuan'
    ];

    // Options untuk agama
    public array $agamaOptions = [
        'Islam' => 'Islam',
        'Kristen' => 'Kristen',
        'Katolik' => 'Katolik',
        'Hindu' => 'Hindu',
        'Buddha' => 'Buddha',
        'Konghucu' => 'Konghucu'
    ];

    public function mount(): void
    {
        $this->user_id = Auth::id();
        $this->loadDataMurid();
    }

    protected function loadDataMurid(): void
    {
        $data = DataMurid::where('user_id', $this->user_id)->first();

        if ($data) {
            $this->nomor_kartu_keluarga = $data->nomor_kartu_keluarga;
            $this->tempat_lahir = $data->tempat_lahir;
            $this->tgl_lahir = $data->tgl_lahir ? $data->tgl_lahir->format('Y-m-d') : null;
            $this->jenis_kelamin = $data->jenis_kelamin ?? 'Laki-laki';
            $this->agama = $data->agama;
            $this->whatsapp = $data->whatsapp;
            $this->alamat = $data->alamat;
            $this->asal_sekolah = $data->asal_sekolah;
            $this->berat_badan = $data->berat_badan;
            $this->tinggi_badan = $data->tinggi_badan;
            $this->riwayat_penyakit = $data->riwayat_penyakit;
            $this->proses = (string) $data->proses;
        } else {
            DataMurid::create([
                'user_id' => $this->user_id,
                'jenis_kelamin' => 'Laki-laki',
                'proses' => '0',
            ]);
            $this->jenis_kelamin = 'Laki-laki';
            $this->proses = '0';
        }
    }

    // Validasi
    protected array $rules = [
        'nomor_kartu_keluarga' => 'required|string|size:16|regex:/^[0-9]+$/',
        'tempat_lahir' => 'required|string|max:100',
        'tgl_lahir' => 'required|date|before:today',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'agama' => 'required|string|max:50',
        'whatsapp' => 'required|string|max:20|regex:/^[0-9+\-\s()]*$/',
        'alamat' => 'required|string|max:500',
        'asal_sekolah' => 'required|string|max:100',
        'berat_badan' => 'required|numeric|min:1|max:999',
        'tinggi_badan' => 'required|numeric|min:50|max:300',
        'riwayat_penyakit' => 'nullable|string|max:1000',
    ];

    protected array $messages = [
        'nomor_kartu_keluarga.required' => 'Nomor Kartu Keluarga wajib diisi.',
        'nomor_kartu_keluarga.string' => 'Nomor Kartu Keluarga harus berupa teks.',
        'nomor_kartu_keluarga.size' => 'Nomor Kartu Keluarga harus tepat 16 digit.',
        'nomor_kartu_keluarga.regex' => 'Nomor Kartu Keluarga hanya boleh berisi angka.',
        'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
        'tempat_lahir.max' => 'Tempat lahir maksimal 100 karakter.',
        'tgl_lahir.date' => 'Tanggal lahir tidak valid.',
        'tgl_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
        'agama.string' => 'Agama harus berupa teks.',
        'agama.max' => 'Agama maksimal 50 karakter.',
        'whatsapp.string' => 'Nomor WhatsApp harus berupa teks.',
        'whatsapp.max' => 'Nomor WhatsApp maksimal 20 karakter.',
        'whatsapp.regex' => 'Format nomor WhatsApp tidak valid.',
        'alamat.string' => 'Alamat harus berupa teks.',
        'alamat.max' => 'Alamat maksimal 500 karakter.',
        'asal_sekolah.string' => 'Asal sekolah harus berupa teks.',
        'asal_sekolah.max' => 'Asal sekolah maksimal 100 karakter.',
        'berat_badan.numeric' => 'Berat badan harus berupa angka.',
        'berat_badan.min' => 'Berat badan minimal 1 kg.',
        'berat_badan.max' => 'Berat badan maksimal 999 kg.',
        'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
        'tinggi_badan.min' => 'Tinggi badan minimal 50 cm.',
        'tinggi_badan.max' => 'Tinggi badan maksimal 300 cm.',
        'riwayat_penyakit.max' => 'Riwayat penyakit maksimal 1000 karakter.',
    ];

    // Render tampilan
    public function render()
    {
        return view('livewire.siswa.formulir.data-murid-page');
    }

    // ubah protected jadi public biar bisa dipanggil di blade
    public function checkAllFilled(): bool
    {
        return $this->nomor_kartu_keluarga &&
            $this->tempat_lahir &&
            $this->tgl_lahir &&
            $this->jenis_kelamin &&
            $this->agama &&
            $this->whatsapp &&
            $this->alamat &&
            $this->asal_sekolah &&
            $this->berat_badan &&
            $this->tinggi_badan;
    }

    public function update(): mixed
    {
        $this->validate();

        $this->proses = $this->checkAllFilled() ? '1' : '0';

        DataMurid::updateOrCreate(
            ['user_id' => $this->user_id],
            [
                'nomor_kartu_keluarga' => $this->nomor_kartu_keluarga,
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $this->tgl_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'agama' => $this->agama,
                'whatsapp' => $this->whatsapp,
                'alamat' => $this->alamat,
                'asal_sekolah' => $this->asal_sekolah,
                'berat_badan' => $this->berat_badan,
                'tinggi_badan' => $this->tinggi_badan,
                'riwayat_penyakit' => $this->riwayat_penyakit,
                'proses' => $this->proses,
            ]
        );

        $this->loadDataMurid();

        // kasih alert sukses
        $this->dispatch('alert', type: 'success', message: 'Data murid berhasil diperbarui.');

        // redirect otomatis ke halaman berikutnya
        return $this->redirectRoute('siswa.formulir.data-orang-tua');
    }



    // Hitung BMI (Body Mass Index)
    public function calculateBMI(): ?float
    {
        if ($this->berat_badan && $this->tinggi_badan) {
            $tinggiMeter = $this->tinggi_badan / 100; // convert cm to meter
            return round($this->berat_badan / ($tinggiMeter * $tinggiMeter), 2);
        }
        return null;
    }

    // Status BMI
    public function getBMIStatus(): ?string
    {
        $bmi = $this->calculateBMI();

        if (!$bmi) return null;

        if ($bmi < 18.5) return 'Kurus';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Gemuk';
        return 'Obesitas';
    }

    // Hitung umur berdasarkan tanggal lahir
    public function calculateAge(): ?int
    {
        if ($this->tgl_lahir) {
            return \Carbon\Carbon::parse($this->tgl_lahir)->age;
        }
        return null;
    }

    // Reset form
    public function resetForm(): void
    {
        $this->reset([
            'nomor_kartu_keluarga',
            'tempat_lahir',
            'tgl_lahir',
            'agama',
            'whatsapp',
            'alamat',
            'asal_sekolah',
            'berat_badan',
            'tinggi_badan',
            'riwayat_penyakit'
        ]);
        $this->jenis_kelamin = 'Laki-laki'; // Reset ke default
        $this->loadDataMurid();
    }

    // Method untuk mendapatkan progress pengisian
    public function getProgress(): int
    {
        $fields = [
            'nomor_kartu_keluarga',
            'tempat_lahir',
            'tgl_lahir',
            'jenis_kelamin',
            'agama',
            'whatsapp',
            'alamat',
            'asal_sekolah',
            'berat_badan',
            'tinggi_badan'
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        return round(($filled / count($fields)) * 100);
    }
}