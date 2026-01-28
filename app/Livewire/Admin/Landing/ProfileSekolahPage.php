<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\ProfileSekolah;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Profile Sekolah")]
class ProfileSekolahPage extends Component
{
    use WithFileUploads;

    public $profileSekolah;

    public $title, $content, $image, $new_image, $badge, $mobile_image, $new_mobile_image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'new_image' => 'nullable|image|max:2048',
        'new_mobile_image' => 'nullable|image|max:2048',
        'badge' => 'nullable|string',
    ];

    protected $messages = [
        'title.required' => 'Judul wajib diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'content.required' => 'Konten wajib diisi',
        'new_image.image' => 'File harus berupa gambar',
        'new_image.max' => 'Ukuran gambar maksimal 2MB',
        'new_mobile_image.image' => 'File mobile harus berupa gambar',
        'new_mobile_image.max' => 'Ukuran gambar mobile maksimal 2MB',
    ];

    public function mount()
    {
        $this->loadProfileSekolah();
    }

    public function loadProfileSekolah()
    {
        $this->profileSekolah = ProfileSekolah::first();

        if ($this->profileSekolah) {
            $this->title = $this->profileSekolah->title;
            $this->content = $this->profileSekolah->content;
            $this->image = $this->profileSekolah->image;
            $this->mobile_image = $this->profileSekolah->mobile_image;
            $this->badge = $this->profileSekolah->badge;
        }
    }

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'profile-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'profile-modal');
        $this->resetErrorBag();
    }

    public function edit()
    {
        $this->loadProfileSekolah();
        $this->resetErrorBag();
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'badge' => $this->badge,
        ];

        if ($this->new_image) {
            if ($this->profileSekolah && $this->profileSekolah->image && Storage::disk('public')->exists($this->profileSekolah->image)) {
                Storage::disk('public')->delete($this->profileSekolah->image);
            }

            $imagePath = $this->new_image->store('profile-sekolah', 'public');
            $data['image'] = $imagePath;
        } elseif ($this->profileSekolah && $this->profileSekolah->image) {
            $data['image'] = $this->profileSekolah->image;
        }

        if ($this->new_mobile_image) {
            if ($this->profileSekolah && $this->profileSekolah->mobile_image && Storage::disk('public')->exists($this->profileSekolah->mobile_image)) {
                Storage::disk('public')->delete($this->profileSekolah->mobile_image);
            }

            $mobileImagePath = $this->new_mobile_image->store('profile-sekolah', 'public');
            $data['mobile_image'] = $mobileImagePath;
        } elseif ($this->profileSekolah && $this->profileSekolah->mobile_image) {
            $data['mobile_image'] = $this->profileSekolah->mobile_image;
        }

        if ($this->profileSekolah) {
            $this->profileSekolah->update($data);
            $message = 'Profile sekolah berhasil diperbarui';
        } else {
            ProfileSekolah::create($data);
            $message = 'Profile sekolah berhasil dibuat';
        }

        $this->loadProfileSekolah();
        $this->new_image = null;
        $this->new_mobile_image = null;
        $this->closeModal();
        
        session()->flash('message', $message);
    }

    public function deleteImage()
    {
        if ($this->profileSekolah && $this->profileSekolah->image) {
            if (Storage::disk('public')->exists($this->profileSekolah->image)) {
                Storage::disk('public')->delete($this->profileSekolah->image);
            }
            $this->profileSekolah->update(['image' => null]);
            $this->image = null;
            session()->flash('message', 'Gambar berhasil dihapus');
        }
    }

    public function deleteMobileImage()
    {
        if ($this->profileSekolah && $this->profileSekolah->mobile_image) {
            if (Storage::disk('public')->exists($this->profileSekolah->mobile_image)) {
                Storage::disk('public')->delete($this->profileSekolah->mobile_image);
            }
            $this->profileSekolah->update(['mobile_image' => null]);
            $this->mobile_image = null;
            session()->flash('message', 'Gambar mobile berhasil dihapus');
        }
    }

    public function render()
    {
        return view('livewire.admin.landing.profile-sekolah-page');
    }
}