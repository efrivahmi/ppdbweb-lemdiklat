<?php

namespace App\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.siswa")]
#[Title("Profile")]
class Profile extends Component
{
    use WithFileUploads;

    // Profile data
    public $name;
    public $email;
    public $nisn; // Tetap ada tapi hanya untuk display
    public $telp;
    public $foto_profile;
    public $new_foto_profile;

    // Password change
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // State
    public $activeTab = 'profile';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nisn = $user->nisn;
        $this->telp = $user->telp;
        $this->foto_profile = $user->foto_profile;
    }

    public function updateProfile()
    {
        // NISN dihapus dari validation karena field disabled
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'telp' => 'nullable|string|max:20',
            'new_foto_profile' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();

        // Handle photo upload
        if ($this->new_foto_profile) {
            // Delete old photo if exists
            if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
                Storage::disk('public')->delete($user->foto_profile);
            }

            // Store new photo
            $photoPath = $this->new_foto_profile->store('profile_photos', 'public');
            $this->foto_profile = $photoPath;
        }

        // Update user data - NISN tidak disertakan
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'telp' => $this->telp,
            'foto_profile' => $this->foto_profile
        ]);

        $this->new_foto_profile = null;
        $this->dispatch("alert", message: "Profile berhasil diperbarui", type: "success");
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai.');
            return;
        }

        // Update password
        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        // Reset form
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->dispatch("alert", message: "Password berhasil diubah", type: "success");
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
            Storage::disk('public')->delete($user->foto_profile);
        }

        $user->update(['foto_profile' => null]);
        $this->foto_profile = null;
        $this->dispatch("alert", message: "Foto profile berhasil dihapus", type: "success");
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.siswa.profile');
    }
}