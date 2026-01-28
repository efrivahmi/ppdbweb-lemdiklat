<?php

namespace App\Livewire\Admin\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Detail Admin")]
class DetailAdmin extends Component
{
    use WithFileUploads;

    public User $admin;
    public $showEditModal = false;
    public $showPasswordModal = false;

    // Edit form properties
    public $name, $email, $telp, $foto_profile;
    
    // Password form properties
    public $current_password, $password, $password_confirmation;

    public function mount($id)
    {
        $this->admin = User::where('role', 'admin')->findOrFail($id);
        $this->loadAdminData();
    }

    protected function loadAdminData()
    {
        $this->name = $this->admin->name;
        $this->email = $this->admin->email;
        $this->telp = $this->admin->telp;
    }

    // Edit Admin
    public function toggleEditModal()
    {
        $this->showEditModal = !$this->showEditModal;
        if ($this->showEditModal) {
            $this->loadAdminData();
        } else {
            $this->resetEditForm();
        }
    }

    public function resetEditForm()
    {
        $this->foto_profile = null;
        $this->resetErrorBag(['name', 'email', 'telp', 'foto_profile']);
    }

    public function updateAdmin()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->admin->id,
            'telp' => 'nullable|string|max:20',
            'foto_profile' => 'nullable|image|max:2048',
        ];

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'telp' => $this->telp,
        ];

        // Handle foto profile upload
        if ($this->foto_profile) {
            // Delete old photo
            if ($this->admin->foto_profile && Storage::disk('public')->exists($this->admin->foto_profile)) {
                Storage::disk('public')->delete($this->admin->foto_profile);
            }

            // Store new photo
            $path = $this->foto_profile->store('profile_photos', 'public');
            $data['foto_profile'] = $path;
        }

        $this->admin->update($data);
        $this->admin->refresh();
        
        $this->toggleEditModal();
        $this->dispatch("alert", message: "Berhasil memperbarui admin", type: "success");
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

        // Only require current password if updating own account
        if ($this->admin->id === Auth::id()) {
            $rules['current_password'] = 'required|current_password';
        }

        $this->validate($rules);

        $this->admin->update([
            'password' => bcrypt($this->password)
        ]);

        $this->togglePasswordModal();
        $this->dispatch("alert", message: "Berhasil memperbarui password", type: "success");
    }

    // Delete Photo
    public function deletePhoto()
    {
        if ($this->admin->foto_profile && Storage::disk('public')->exists($this->admin->foto_profile)) {
            Storage::disk('public')->delete($this->admin->foto_profile);
        }

        $this->admin->update(['foto_profile' => null]);
        $this->admin->refresh();
        
        $this->dispatch("alert", message: "Berhasil menghapus foto admin", type: "success");
    }

    public function render()
    {
        return view('livewire.admin.admin.detail-admin');
    }
}