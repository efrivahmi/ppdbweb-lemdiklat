<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\HeroProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Hero Profile")]
class HeroProfileSection extends Component
{
    use WithFileUploads;

    public $heroProfile;

    public $image, $new_image;

    protected $rules = [
        'new_image' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'new_image.image' => 'File harus berupa gambar',
        'new_image.max' => 'Ukuran gambar maksimal 2MB',
    ];

    public function mount()
    {
        $this->loadHeroProfile();
    }

    public function loadHeroProfile()
    {
        $this->heroProfile = HeroProfile::first();

        if ($this->heroProfile) {
            $this->image = $this->heroProfile->image;
        }
    }

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'hero-Profile-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'hero-Profile-modal');
        $this->resetErrorBag();
    }

    public function edit()
    {
        $this->loadHeroProfile();
        $this->resetErrorBag();
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        if ($this->new_image) {
            if ($this->heroProfile && $this->heroProfile->image && Storage::disk('public')->exists($this->heroProfile->image)) {
                Storage::disk('public')->delete($this->heroProfile->image);
            }

            $imagePath = $this->new_image->store('hero-Profile', 'public');
            $data['image'] = $imagePath;
        } elseif ($this->heroProfile && $this->heroProfile->image) {
            $data['image'] = $this->heroProfile->image;
        }

        if ($this->heroProfile) {
            $this->heroProfile->update($data);
            $message = 'Hero Profile berhasil diperbarui';
        } else {
            HeroProfile::create($data);
            $message = 'Hero Profile berhasil dibuat';
        }

        $this->new_image = null;
        $this->loadHeroProfile();
        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
    }

    public function cancel()
    {
        $this->resetErrorBag();
        $this->reset(['new_image']);
        $this->loadHeroProfile();
        $this->closeModal();
    }

    public function deleteImage()
    {
        if ($this->heroProfile && $this->heroProfile->image) {
            if (Storage::disk('public')->exists($this->heroProfile->image)) {
                Storage::disk('public')->delete($this->heroProfile->image);
            }

            $this->heroProfile->update(['image' => null]);
            $this->loadHeroProfile();
            $this->dispatch("alert", message: "Berhasil menghapus gambar", type: "success");
        }
    }

    public function render()
    {
        return view('livewire.admin.landing.hero-profile-section');
    }
}
