<?php

namespace App\Livewire\Siswa\Formulir;

use App\Models\Siswa\BerkasMurid;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.siswa")]
#[Title("Berkas Siswa")]
class BerkasMuridPage extends Component
{
    use WithFileUploads;

    public $user_id, $proses = 0;

    // Berkas
    public $kk, $ktp_ortu, $akte, $surat_sehat, $pas_foto;

    public function mount(): void
    {
        $this->user_id = Auth::id();
        $berkas = BerkasMurid::firstOrCreate(['user_id' => $this->user_id]);

        $this->proses = $berkas->proses;
    }

    protected function rules(): array
    {
        $berkas = BerkasMurid::where('user_id', $this->user_id)->first();

        return [
            'kk' => ($berkas && $berkas->kk) ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ortu' => ($berkas && $berkas->ktp_ortu) ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akte' => ($berkas && $berkas->akte) ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_sehat' => ($berkas && $berkas->surat_sehat) ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto' => ($berkas && $berkas->pas_foto) ? 'nullable|file|mimes:jpg,jpeg,png|max:2048' : 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    protected array $messages = [
        'kk.required' => 'Kartu Keluarga wajib diupload.',
        'kk.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
        'kk.max' => 'Ukuran file maksimal 2MB.',
        
        'ktp_ortu.required' => 'KTP Orang Tua wajib diupload.',
        'ktp_ortu.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
        'ktp_ortu.max' => 'Ukuran file maksimal 2MB.',
        
        'akte.required' => 'Akte Kelahiran wajib diupload.',
        'akte.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
        'akte.max' => 'Ukuran file maksimal 2MB.',
        
        'surat_sehat.required' => 'Surat Sehat wajib diupload.',
        'surat_sehat.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
        'surat_sehat.max' => 'Ukuran file maksimal 2MB.',
        
        'pas_foto.required' => 'Pas Foto wajib diupload.',
        'pas_foto.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
        'pas_foto.max' => 'Ukuran file maksimal 2MB.',
    ];

    public function update(): void
    {
        $this->validate();

        $berkas = BerkasMurid::firstOrCreate(['user_id' => $this->user_id]);

        $fields = ['kk', 'ktp_ortu', 'akte', 'surat_sehat', 'pas_foto'];

        foreach ($fields as $field) {
            if ($this->$field) {
                if ($berkas->$field && Storage::disk('public')->exists($berkas->$field)) {
                    Storage::disk('public')->delete($berkas->$field);
                }

                $path = $this->$field->store("berkas/{$this->user_id}", 'public');
                $berkas->$field = $path;
            }
        }

        $this->proses = collect($fields)->every(fn($f) => $berkas->$f) ? 1 : 0;
        $berkas->proses = $this->proses;
        $berkas->save();

        $this->dispatch("alert", message: "Berkas berhasil diperbarui", type: "success");
    }

    public function deleteFile(string $field): void
    {
        $berkas = BerkasMurid::where('user_id', $this->user_id)->first();

        if ($berkas && $berkas->$field) {
            if (Storage::disk('public')->exists($berkas->$field)) {
                Storage::disk('public')->delete($berkas->$field);
            }

            $berkas->$field = null;
            $berkas->proses = 0;
            $berkas->save();

            $this->$field = null;

            $this->dispatch("alert", message: "File berhasil dihapus", type: "success");
        }
    }

    public function getIsCompleteProperty(): bool
    {
        $fields = ['kk', 'ktp_ortu', 'akte', 'surat_sehat', 'pas_foto'];
        $berkas = BerkasMurid::where('user_id', $this->user_id)->first();

        return collect($fields)->every(
            fn($f) =>
            $this->$f || ($berkas && $berkas->$f)
        );
    }

    public function getProgressProperty(): int
    {
        $fields = ['kk', 'ktp_ortu', 'akte', 'surat_sehat', 'pas_foto'];
        $berkas = BerkasMurid::where('user_id', $this->user_id)->first();

        $filled = collect($fields)->filter(
            fn($f) =>
            $this->$f || ($berkas && $berkas->$f)
        )->count();

        return intval(($filled / count($fields)) * 100);
    }


    public function render()
    {
        return view('livewire.siswa.formulir.berkas-murid-page');
    }
}
