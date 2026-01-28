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

    protected array $rules = [
        'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'ktp_ortu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'akte' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'surat_sehat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pas_foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
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
