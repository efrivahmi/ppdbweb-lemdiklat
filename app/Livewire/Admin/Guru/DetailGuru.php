<?php

namespace App\Livewire\Admin\Guru;

use App\Models\User;
use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Detail Guru")]
class DetailGuru extends Component
{
    use WithFileUploads;

    public User $guru;
    public $showEditModal = false;
    public $showPasswordModal = false;
    public $showSuratKerja = false;

    public $mapels;

    // Edit form properties
    public $name, $email, $telp, $foto_profile, $mapel_id;
    
    // Password form properties
    public $current_password, $password, $password_confirmation;

    public function mount($id)
    {
        $this->guru = User::with(['mapel', 'guru_documents'])
            ->where('role', 'guru')
            ->findOrFail($id);
        $this->mapels = Mapel::all();
        $this->loadGuruData();
    }

    protected function loadGuruData()
    {
        $this->name = $this->guru->name;
        $this->email = $this->guru->email;
        $this->telp = $this->guru->telp;
        $this->mapel_id = $this->guru->mapel_id; // Load mapel_id yang sudah dipilih
    }

    // Edit Guru
    public function toggleEditModal()
    {
        $this->showEditModal = !$this->showEditModal;
        if ($this->showEditModal) {
            $this->loadGuruData();
        } else {
            $this->resetEditForm();
        }
    }

    public function resetEditForm()
    {
        $this->foto_profile = null;
        $this->resetErrorBag(['name', 'email', 'telp', 'foto_profile', 'mapel_id']);
    }

    public function updateGuru()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->guru->id,
            'telp' => 'nullable|string|max:20',
            'foto_profile' => 'nullable|image|max:2048',
            'mapel_id' => 'nullable|exists:mapels,id',
        ];

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'telp' => $this->telp,
            'mapel_id' => $this->mapel_id,
        ];

        // Handle foto profile upload
        if ($this->foto_profile) {
            // Delete old photo
            if ($this->guru->foto_profile && Storage::disk('public')->exists($this->guru->foto_profile)) {
                Storage::disk('public')->delete($this->guru->foto_profile);
            }

            // Store new photo
            $path = $this->foto_profile->store('profile_photos', 'public');
            $data['foto_profile'] = $path;
        }

        $this->guru->update($data);
        $this->guru->refresh();
        
        $this->toggleEditModal();
        $this->dispatch("alert", message: "Berhasil memperbarui guru.", type: "success");
    }

    // Change Password
    public function togglePasswordModal()
    {
        $this->showPasswordModal = !$this->showPasswordModal;
        if (!$this->showPasswordModal) {
            $this->resetPasswordForm();
        }
    }

    public function resetPasswordForm()
    {
        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->resetErrorBag(['current_password', 'password']);
    }

    public function updatePassword()
    {
        $rules = [
            'password' => 'required|string|min:8|confirmed',
        ];

        $this->validate($rules);

        $this->guru->update([
            'password' => bcrypt($this->password)
        ]);

        $this->togglePasswordModal();
        $this->dispatch("alert", message: "Berhasil memperbarui password", type: "success");
    }

    // Delete Photo
    public function deletePhoto()
    {
        if ($this->guru->foto_profile && Storage::disk('public')->exists($this->guru->foto_profile)) {
            Storage::disk('public')->delete($this->guru->foto_profile);
        }

        $this->guru->update(['foto_profile' => null]);
        $this->guru->refresh();

        $this->dispatch("alert", message: "Berhasil menghapus foto.", type: "success");
    }

    // Approval Methods
    public function approveGuru()
    {
        if (auth()->user()->canManageUsers()) {
            $this->guru->update([
                'guru_approved' => true,
                'guru_approved_at' => now()
            ]);

            $this->guru->guru_documents()->update([
                'status' => 'approved'
            ]);

            $this->guru->refresh();
            $this->dispatch("alert", message: "Guru berhasil disetujui!", type: "success");
        }
    }

    public function rejectGuru()
    {
        if (auth()->user()->canManageUsers()) {
            $this->guru->update([
                'guru_approved' => false,
                'guru_approved_at' => null
            ]);

            $this->guru->guru_documents()->update([
                'status' => 'rejected'
            ]);

            $this->guru->refresh();
            $this->dispatch("alert", message: "Persetujuan guru dibatalkan!", type: "success");
        }
    }

    public function toggleSuratKerja()
    {
        $this->showSuratKerja = !$this->showSuratKerja;
    }

    public function render()
    {
        return view('livewire.admin.guru.detail-guru');
    }
}