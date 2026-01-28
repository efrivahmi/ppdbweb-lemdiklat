<?php

namespace App\Livewire\Guru\Siswa;

use App\Models\User;
use App\Models\Siswa\BerkasMurid;
use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Pendaftaran\CustomTest;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.guru")]
#[Title("Detail Siswa")]
class DetailSiswa extends Component
{
    use WithFileUploads;

    public User $user;
    public $showEditData = false;
    public $showEditOrangTua = false;
    public $showUploadBerkas = false;

    // Data Murid Properties
    public  $tempat_lahir, $tgl_lahir, $agama, $whatsapp, $alamat, $asal_sekolah, $berat_badan, $tinggi_badan, $riwayat_penyakit, $jenis_kelamin;

    // Data Orang Tua Properties
    public $nama_ayah, $pendidikan_ayah, $telp_ayah, $pekerjaan_ayah, $penghasilan_ayah, $alamat_ayah;
    public $nama_ibu, $pendidikan_ibu, $telp_ibu, $pekerjaan_ibu, $penghasilan_ibu, $alamat_ibu;
    public $nama_wali, $pendidikan_wali, $telp_wali, $pekerjaan_wali, $penghasilan_wali, $alamat_wali;

    // Berkas Properties
    public $kartu_keluarga, $akte_kelahiran, $surat_kelakuan_baik, $surat_sehat;
    public $surat_tidak_buta_warna, $rapor, $foto, $ijazah;

    public function mount($id)
    {
        $this->user = User::with([
            'dataMurid',
            'dataOrangTua',
            'berkasMurid',
            'buktiTransfer',
            'pendaftaranMurids.jalurPendaftaran',
            'pendaftaranMurids.tipeSekolah',
            'pendaftaranMurids.jurusan',
            'customTestAnswers.customTest',
            'customTestAnswers.customTestQuestion'
        ])->findOrFail($id);

        $this->loadDataMurid();
        $this->loadDataOrangTua();
    }

    protected function loadDataMurid()
    {
        if ($this->user->dataMurid) {
            $data = $this->user->dataMurid;
            $this->tempat_lahir = $data->tempat_lahir;
            $this->tgl_lahir = $data->tgl_lahir;
            $this->agama = $data->agama;
            $this->whatsapp = $data->whatsapp;
            $this->alamat = $data->alamat;
            $this->asal_sekolah = $data->asal_sekolah;
            $this->berat_badan = $data->berat_badan;
            $this->tinggi_badan = $data->tinggi_badan;
            $this->riwayat_penyakit = $data->riwayat_penyakit;
            $this->jenis_kelamin = $data->jenis_kelamin;
        }
    }

    protected function loadDataOrangTua()
    {
        if ($this->user->dataOrangTua) {
            $data = $this->user->dataOrangTua;
            // Ayah
            $this->nama_ayah = $data->nama_ayah;
            $this->pendidikan_ayah = $data->pendidikan_ayah;
            $this->telp_ayah = $data->telp_ayah;
            $this->pekerjaan_ayah = $data->pekerjaan_ayah;
            $this->penghasilan_ayah = $data->penghasilan_ayah;
            $this->alamat_ayah = $data->alamat_ayah;
            // Ibu
            $this->nama_ibu = $data->nama_ibu;
            $this->pendidikan_ibu = $data->pendidikan_ibu;
            $this->telp_ibu = $data->telp_ibu;
            $this->pekerjaan_ibu = $data->pekerjaan_ibu;
            $this->penghasilan_ibu = $data->penghasilan_ibu;
            $this->alamat_ibu = $data->alamat_ibu;
            // Wali
            $this->nama_wali = $data->nama_wali;
            $this->pendidikan_wali = $data->pendidikan_wali;
            $this->telp_wali = $data->telp_wali;
            $this->pekerjaan_wali = $data->pekerjaan_wali;
            $this->penghasilan_wali = $data->penghasilan_wali;
            $this->alamat_wali = $data->alamat_wali;
        }
    }

    // Get Test Results
    public function getTestResults()
    {
        $completedTests = CustomTestAnswer::where('user_id', $this->user->id)
            ->with(['customTest', 'customTestQuestion'])
            ->get()
            ->groupBy('custom_test_id');

        $testResults = [];
        
        foreach ($completedTests as $testId => $answers) {
            $test = $answers->first()->customTest;
            
            $radioAnswers = $answers->where('customTestQuestion.tipe_soal', 'radio');
            $essayAnswers = $answers->where('customTestQuestion.tipe_soal', 'text');
            
            $radioCorrect = $radioAnswers->where('is_correct', true)->count();
            $essayCorrect = $essayAnswers->where('is_correct', true)->count();
            $essayPending = $essayAnswers->whereNull('is_correct')->count();
            $essayReviewed = $essayAnswers->whereNotNull('is_correct')->count();
            
            $totalCorrect = $radioCorrect + $essayCorrect;
            $totalReviewed = $radioAnswers->count() + $essayReviewed;
            $percentage = $totalReviewed > 0 ? ($totalCorrect / $totalReviewed) * 100 : 0;
            
            $testResults[] = [
                'test' => $test,
                'answers' => $answers,
                'stats' => [
                    'radio_total' => $radioAnswers->count(),
                    'radio_correct' => $radioCorrect,
                    'essay_total' => $essayAnswers->count(),
                    'essay_correct' => $essayCorrect,
                    'essay_pending' => $essayPending,
                    'essay_reviewed' => $essayReviewed,
                    'total_correct' => $totalCorrect,
                    'total_reviewed' => $totalReviewed,
                    'percentage' => round($percentage, 1),
                    'completed_at' => $answers->first()->completed_at
                ]
            ];
        }
        
        // Sort by completion date
        usort($testResults, function($a, $b) {
            return $b['stats']['completed_at'] <=> $a['stats']['completed_at'];
        });
        
        return $testResults;
    }

    // Review Actions for Essays
    public function approveEssayAnswer($answerId)
    {
        try {
            $answer = CustomTestAnswer::findOrFail($answerId);
            $answer->update(['is_correct' => true]);
            $this->user->refresh();
            $this->dispatch("alert", message: "Jawaban essay disetujui", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }
    
    public function rejectEssayAnswer($answerId)
    {
        try {
            $answer = CustomTestAnswer::findOrFail($answerId);
            $answer->update(['is_correct' => false]);
            $this->user->refresh();
            $this->dispatch("alert", message: "Jawaban essay ditolak", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }

    public function approveAllEssayForTest($testId)
    {
        try {
            $updated = CustomTestAnswer::where('user_id', $this->user->id)
                ->where('custom_test_id', $testId)
                ->whereHas('customTestQuestion', function($query) {
                    $query->where('tipe_soal', 'text');
                })
                ->whereNull('is_correct')
                ->update(['is_correct' => true]);
                
            if ($updated > 0) {
                $this->user->refresh();
                $this->dispatch("alert", message: "Semua jawaban essay telah di setujui", type: "success");
            } else {
                $this->dispatch('info', message: 'Tidak ada jawaban essay yang perlu disetujui');
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }

    // Update Status Transfer
    public function updateStatusTransfer($status)
    {
        if ($this->user->buktiTransfer) {
            $this->user->buktiTransfer->update(['status' => $status]);
            $this->user->refresh();
            $this->dispatch("alert", message: "Status transfer berhasil di setujui", type: "success");
        }
    }

    // Update Status Pendaftaran
    public function updateStatusPendaftaran($pendaftaranId, $status)
    {
        $pendaftaran = PendaftaranMurid::findOrFail($pendaftaranId);
        $pendaftaran->update(['status' => $status]);
        
        $this->user->refresh();
        $this->dispatch("alert", message: "Status pendaftaran berhasil di ubah", type: "success");
    }

    // Update Data Murid
    public function updateDataMurid()
    {
        $this->validate([
            'tempat_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:100',
            'berat_badan' => 'nullable|numeric|min:1|max:999',
            'tinggi_badan' => 'nullable|numeric|min:1|max:999',
            'riwayat_penyakit' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
        ]);

        $proses =  $this->tempat_lahir && $this->tgl_lahir && 
                 $this->agama && $this->whatsapp && $this->alamat && 
                 $this->asal_sekolah && $this->berat_badan && $this->tinggi_badan && $this->jenis_kelamin ? 1 : 0;

        DataMurid::updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $this->tgl_lahir,
                'agama' => $this->agama,
                'whatsapp' => $this->whatsapp,
                'alamat' => $this->alamat,
                'asal_sekolah' => $this->asal_sekolah,
                'berat_badan' => $this->berat_badan,
                'tinggi_badan' => $this->tinggi_badan,
                'riwayat_penyakit' => $this->riwayat_penyakit,
                'jenis_kelamin' => $this->jenis_kelamin,
                'proses' => $proses,
            ]
        );

        $this->user->refresh();
        $this->showEditData = false;
        $this->dispatch("alert", message: "Data murid berhasil di perbarui", type: "success");
    }

    // Update Data Orang Tua
    public function updateDataOrangTua()
    {
        $this->validate([
            'nama_ayah' => 'nullable|string|max:255',
            'pendidikan_ayah' => 'nullable|string|max:50',
            'telp_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:50',
            'penghasilan_ayah' => 'nullable|string|max:50',
            'alamat_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pendidikan_ibu' => 'nullable|string|max:50',
            'telp_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:50',
            'penghasilan_ibu' => 'nullable|string|max:50',
            'alamat_ibu' => 'nullable|string|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'pendidikan_wali' => 'nullable|string|max:50',
            'telp_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:50',
            'penghasilan_wali' => 'nullable|string|max:50',
            'alamat_wali' => 'nullable|string|max:255',
        ]);

        DataOrangTua::updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'nama_ayah' => $this->nama_ayah,
                'pendidikan_ayah' => $this->pendidikan_ayah,
                'telp_ayah' => $this->telp_ayah,
                'pekerjaan_ayah' => $this->pekerjaan_ayah,
                'penghasilan_ayah' => $this->penghasilan_ayah,
                'alamat_ayah' => $this->alamat_ayah,
                'nama_ibu' => $this->nama_ibu,
                'pendidikan_ibu' => $this->pendidikan_ibu,
                'telp_ibu' => $this->telp_ibu,
                'pekerjaan_ibu' => $this->pekerjaan_ibu,
                'penghasilan_ibu' => $this->penghasilan_ibu,
                'alamat_ibu' => $this->alamat_ibu,
                'nama_wali' => $this->nama_wali,
                'pendidikan_wali' => $this->pendidikan_wali,
                'telp_wali' => $this->telp_wali,
                'pekerjaan_wali' => $this->pekerjaan_wali,
                'penghasilan_wali' => $this->penghasilan_wali,
                'alamat_wali' => $this->alamat_wali,
            ]
        );

        $this->user->refresh();
        $this->showEditOrangTua = false;
        $this->dispatch("alert", message: "Data orang tua berhasil di perbarui", type: "success");
    }

    // Upload Berkas
    public function uploadBerkas()
    {
        $this->validate([
            'kartu_keluarga' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akte_kelahiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_kelakuan_baik' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_sehat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_tidak_buta_warna' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'rapor' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $berkas = BerkasMurid::firstOrCreate(['user_id' => $this->user->id]);

        $fields = [
            'kartu_keluarga', 'akte_kelahiran', 'surat_kelakuan_baik',
            'surat_sehat', 'surat_tidak_buta_warna', 'rapor', 'foto', 'ijazah'
        ];

        foreach ($fields as $field) {
            if ($this->$field) {
                // Hapus file lama
                if ($berkas->$field && Storage::disk('public')->exists($berkas->$field)) {
                    Storage::disk('public')->delete($berkas->$field);
                }

                // Simpan file baru
                $path = $this->$field->store("berkas/{$this->user->id}", 'public');
                $berkas->$field = $path;
                $this->$field = null; // Reset input
            }
        }

        // Update status proses
        $proses = collect($fields)->every(fn($f) => $berkas->$f) ? 1 : 0;
        $berkas->proses = $proses;
        $berkas->save();

        $this->user->refresh();
        $this->showUploadBerkas = false;
        $this->dispatch("alert", message: "Berkas berhasil di perbarui", type: "success");
    }

    // Delete Berkas
    public function deleteBerkas($field)
    {
        $berkas = BerkasMurid::where('user_id', $this->user->id)->first();

        if ($berkas && $berkas->$field) {
            if (Storage::disk('public')->exists($berkas->$field)) {
                Storage::disk('public')->delete($berkas->$field);
            }

            $berkas->$field = null;
            
            // Update status proses
            $fields = ['kartu_keluarga', 'akte_kelahiran', 'surat_kelakuan_baik',
                      'surat_sehat', 'surat_tidak_buta_warna', 'rapor', 'foto', 'ijazah'];
            $berkas->proses = collect($fields)->every(fn($f) => $berkas->$f) ? 1 : 0;
            $berkas->save();

            $this->user->refresh();
            $this->dispatch("alert", message: "File berhasil di perbarui", type: "success");
        }
    }

    // Toggle Methods
    public function toggleEditData()
    {
        $this->showEditData = !$this->showEditData;
        if ($this->showEditData) {
            $this->loadDataMurid();
        }
    }

    public function toggleEditOrangTua()
    {
        $this->showEditOrangTua = !$this->showEditOrangTua;
        if ($this->showEditOrangTua) {
            $this->loadDataOrangTua();
        }
    }

    public function toggleUploadBerkas()
    {
        $this->showUploadBerkas = !$this->showUploadBerkas;
    }

    public function getPenghasilanOptions()
    {
        return DataOrangTua::getPenghasilanOptions();
    }

    public array $jenisKelaminOptions = [
        'Laki-laki' => 'Laki-laki',
        'Perempuan' => 'Perempuan'
    ];


    public function render()
    {
        $testResults = $this->getTestResults();
        
        return view('livewire.guru.siswa.detail-siswa', [
            'testResults' => $testResults
        ]);
    }
}