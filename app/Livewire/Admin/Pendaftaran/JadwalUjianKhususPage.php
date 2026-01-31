<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\JadwalUjianKhusus;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Jadwal Ujian Khusus")]
class JadwalUjianKhususPage extends Component
{
    use WithPagination;

    // Form properties
    public $nama = '';
    public $deskripsi = '';
    public $waktu_mulai = '';
    public $waktu_selesai = '';
    public $is_active = true;

    // State
    public $editingId = null;
    public $showModal = false;
    public $showSiswaModal = false;
    public $selectedJadwalId = null;
    public $selectedJadwal = null;

    // Search for students
    public $searchSiswa = '';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'waktu_mulai' => 'required|date_format:Y-m-d\TH:i',
        'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after:waktu_mulai',
    ];

    protected $messages = [
        'nama.required' => 'Nama jadwal wajib diisi',
        'waktu_mulai.required' => 'Waktu mulai wajib diisi',
        'waktu_mulai.date_format' => 'Format waktu tidak valid',
        'waktu_selesai.required' => 'Waktu selesai wajib diisi',
        'waktu_selesai.date_format' => 'Format waktu tidak valid',
        'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['nama', 'deskripsi', 'waktu_mulai', 'waktu_selesai', 'editingId']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $jadwal = JadwalUjianKhusus::findOrFail($id);
        $this->editingId = $id;
        $this->nama = $jadwal->nama;
        $this->deskripsi = $jadwal->deskripsi;
        $this->waktu_mulai = $jadwal->waktu_mulai->format('Y-m-d\TH:i');
        $this->waktu_selesai = $jadwal->waktu_selesai->format('Y-m-d\TH:i');
        $this->is_active = $jadwal->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'waktu_mulai' => Carbon::createFromFormat('Y-m-d\TH:i', $this->waktu_mulai),
            'waktu_selesai' => Carbon::createFromFormat('Y-m-d\TH:i', $this->waktu_selesai),
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            JadwalUjianKhusus::findOrFail($this->editingId)->update($data);
            $this->dispatch('alert', message: 'Jadwal berhasil diperbarui', type: 'success');
        } else {
            JadwalUjianKhusus::create($data);
            $this->dispatch('alert', message: 'Jadwal berhasil ditambahkan', type: 'success');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        JadwalUjianKhusus::findOrFail($id)->delete();
        $this->dispatch('alert', message: 'Jadwal berhasil dihapus', type: 'success');
    }

    public function toggleActive($id)
    {
        $jadwal = JadwalUjianKhusus::findOrFail($id);
        $jadwal->is_active = !$jadwal->is_active;
        $jadwal->save();

        $status = $jadwal->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('alert', message: "Jadwal berhasil $status", type: 'success');
    }

    // Student management methods
    public function openSiswaModal($jadwalId)
    {
        $this->selectedJadwalId = $jadwalId;
        $this->selectedJadwal = JadwalUjianKhusus::with('siswa')->findOrFail($jadwalId);
        $this->searchSiswa = '';
        $this->showSiswaModal = true;
    }

    public function closeSiswaModal()
    {
        $this->showSiswaModal = false;
        $this->selectedJadwalId = null;
        $this->selectedJadwal = null;
        $this->searchSiswa = '';
    }

    public function addSiswa($userId)
    {
        if ($this->selectedJadwal) {
            // Check if not already assigned
            if (!$this->selectedJadwal->siswa()->where('user_id', $userId)->exists()) {
                $this->selectedJadwal->siswa()->attach($userId);
                $this->selectedJadwal->load('siswa');
                $this->dispatch('alert', message: 'Siswa berhasil ditambahkan', type: 'success');
            } else {
                $this->dispatch('alert', message: 'Siswa sudah terdaftar', type: 'warning');
            }
        }
    }

    public function removeSiswa($userId)
    {
        if ($this->selectedJadwal) {
            $this->selectedJadwal->siswa()->detach($userId);
            $this->selectedJadwal->load('siswa');
            $this->dispatch('alert', message: 'Siswa berhasil dihapus dari jadwal', type: 'success');
        }
    }

    public function getSearchResultsProperty()
    {
        if (empty($this->searchSiswa) || strlen($this->searchSiswa) < 2) {
            return collect();
        }

        $assignedIds = $this->selectedJadwal ? $this->selectedJadwal->siswa->pluck('id')->toArray() : [];

        return User::where('role', 'siswa')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchSiswa . '%')
                    ->orWhere('email', 'like', '%' . $this->searchSiswa . '%')
                    ->orWhere('nisn', 'like', '%' . $this->searchSiswa . '%');
            })
            ->whereNotIn('id', $assignedIds)
            ->limit(10)
            ->get();
    }

    public function render()
    {
        $jadwals = JadwalUjianKhusus::withCount('siswa')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.pendaftaran.jadwal-ujian-khusus-page', [
            'jadwals' => $jadwals,
            'searchResults' => $this->searchResults,
        ]);
    }
}
