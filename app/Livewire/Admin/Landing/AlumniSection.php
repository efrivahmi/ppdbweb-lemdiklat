<?php

namespace App\Livewire\Admin\Landing;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Landing\Alumni;
use App\Models\Pendaftaran\Jurusan;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Alumni Section")]
class AlumniSection extends Component
{
    use WithFileUploads, WithPagination;

    // Properties untuk filter dan search
    public $search = '';
    public $jurusanFilter = '';
    public $statusFilter = '';
    public $selectedFilter = '';

    // Properties untuk form
    public $alumniId;
    public $name = '';
    public $tahun_lulus = '';
    public $desc = '';
    public $jurusan_id = '';
    public $is_selected = 0; // Default to 0 (Alumni Biasa)
    public $image;
    public $new_image;

    // State management
    public $editMode = false;
    public $showModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'jurusanFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'selectedFilter' => ['except' => '']
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'tahun_lulus' => 'required|integer|min:1970|max:2030',
        'desc' => 'required|string',
        'jurusan_id' => 'required|exists:jurusans,id',
        'is_selected' => 'required|in:0,1',
        'new_image' => 'nullable|image|max:2048', // max 2MB
    ];

    protected $messages = [
        'name.required' => 'Nama alumni harus diisi.',
        'name.max' => 'Nama alumni maksimal 255 karakter.',
        'tahun_lulus.required' => 'Tahun lulus harus diisi.',
        'tahun_lulus.integer' => 'Tahun lulus harus berupa angka.',
        'tahun_lulus.min' => 'Tahun lulus minimal 1970.',
        'tahun_lulus.max' => 'Tahun lulus maksimal 2030.',
        'desc.required' => 'Deskripsi alumni harus diisi.',
        'jurusan_id.required' => 'Jurusan harus dipilih.',
        'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
        'is_selected.required' => 'Status alumni harus dipilih.',
        'is_selected.in' => 'Status alumni harus Alumni Biasa atau Alumni Terpilih.',
        'new_image.image' => 'File harus berupa gambar.',
        'new_image.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function mount()
    {
        // Initialize default values if needed
        $this->tahun_lulus = date('Y');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJurusanFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSelectedFilter()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;

        // Dispatch browser event untuk debug
        $this->dispatch('modal-opened');
    }

    public function edit($id)
    {
        try {
            $alumni = Alumni::findOrFail($id);
            $this->alumniId = $alumni->id;
            $this->name = $alumni->name;
            $this->tahun_lulus = $alumni->tahun_lulus;
            $this->desc = $alumni->desc;
            $this->jurusan_id = $alumni->jurusan_id;
            $this->is_selected = $alumni->is_selected ? 1 : 0;
            $this->image = $alumni->image;

            $this->editMode = true;
            $this->showModal = true;

            // Dispatch browser event untuk debug
            $this->dispatch('modal-opened');
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Error saat membuka data alumni", type: "error");
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $alumni = Alumni::findOrFail($this->alumniId);
            } else {
                $alumni = new Alumni();
            }

            $alumni->name = $this->name;
            $alumni->tahun_lulus = $this->tahun_lulus;
            $alumni->desc = $this->desc;
            $alumni->jurusan_id = $this->jurusan_id;
            $alumni->is_selected = (bool) $this->is_selected;

            // Handle image upload
            if ($this->new_image) {
                // Delete old image if exists
                if ($alumni->image && Storage::exists('public/' . $alumni->image)) {
                    Storage::delete('public/' . $alumni->image);
                }

                $imagePath = $this->new_image->store('alumni-images', 'public');
                $alumni->image = $imagePath;
            }

            $alumni->save();

            $this->dispatch("alert", message: $this->editMode ? 'Alumni berhasil diupdate!' : 'Alumni berhasil ditambahkan!', type: "success");

            $this->cancel();
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat menambahkan data", type: "error");
        }
    }

    public function delete($id)
    {
        try {
            $alumni = Alumni::findOrFail($id);

            // Delete image if exists
            if ($alumni->image && Storage::exists('public/' . $alumni->image)) {
                Storage::delete('public/' . $alumni->image);
            }

            $alumni->delete();

            $this->dispatch("alert", message: "Alumni berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat menghapus data", type: "error");
        }
    }

    public function deleteImage($id)
    {
        try {
            $alumni = Alumni::findOrFail($id);

            if ($alumni->image && Storage::exists('public/' . $alumni->image)) {
                Storage::delete('public/' . $alumni->image);
                $alumni->image = null;
                $alumni->save();

                $this->dispatch("alert", message: "Foto alumni berhasil di hapus", type: "success");
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat menghapus foto", type: "error");
        }
    }

    public function toggleSelected($id)
    {
        try {
            $alumni = Alumni::findOrFail($id);
            $alumni->is_selected = !$alumni->is_selected;
            $alumni->save();

            $this->dispatch("alert", message: $alumni->is_selected ? 'Alumni berhasil ditandai sebagai terpilih!' : 'Alumni berhasil dihapus dari terpilih!', type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    public function closeModal()
    {
        $this->cancel();
    }

    private function resetForm()
    {
        $this->alumniId = null;
        $this->name = '';
        $this->tahun_lulus = date('Y');
        $this->desc = '';
        $this->jurusan_id = '';
        $this->is_selected = 0; // Default to Alumni Biasa
        $this->image = null;
        $this->new_image = null;
        $this->resetValidation();
    }

    public function render()
    {
        $alumnis = Alumni::with('jurusan')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('desc', 'like', '%' . $this->search . '%')
                        ->orWhere('tahun_lulus', 'like', '%' . $this->search . '%')
                        ->orWhereHas('jurusan', function ($subQuery) {
                            $subQuery->whereRaw('LOWER(nama) like ?', ['%' . strtolower($this->search) . '%']);
                        });
                });
            })

            ->when($this->jurusanFilter, function ($query) {
                $query->where('jurusan_id', $this->jurusanFilter);
            })
            ->when($this->selectedFilter !== '', function ($query) {
                $query->where('is_selected', $this->selectedFilter);
            })
            ->latest()
            ->paginate(10);

        $jurusans = Jurusan::all();
        $allJurusans = $jurusans; // untuk form select

        return view('livewire.admin.landing.alumni-section', compact('alumnis', 'jurusans', 'allJurusans'));
    }
}
