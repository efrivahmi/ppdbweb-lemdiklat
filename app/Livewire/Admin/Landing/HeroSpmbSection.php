<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\HeroSpmb;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Hero SPMB")]
class HeroSpmbSection extends Component
{
    use WithFileUploads;

    public $heroSpmb;

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
        $this->loadHeroSpmb();
    }

    public function loadHeroSpmb()
    {
        $this->heroSpmb = HeroSpmb::first();

        if ($this->heroSpmb) {
            $this->image = $this->heroSpmb->image;
        }
    }

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'hero-spmb-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'hero-spmb-modal');
        $this->resetErrorBag();
    }

    public function edit()
    {
        $this->loadHeroSpmb();
        $this->resetErrorBag();
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        if ($this->new_image) {
            if ($this->heroSpmb && $this->heroSpmb->image && Storage::disk('public')->exists($this->heroSpmb->image)) {
                Storage::disk('public')->delete($this->heroSpmb->image);
            }

            $imagePath = $this->new_image->store('hero-spmb', 'public');
            $data['image'] = $imagePath;
        } elseif ($this->heroSpmb && $this->heroSpmb->image) {
            $data['image'] = $this->heroSpmb->image;
        }

        if ($this->heroSpmb) {
            $this->heroSpmb->update($data);
            $message = 'Hero SPMB berhasil diperbarui';
        } else {
            HeroSpmb::create($data);
            $message = 'Hero SPMB berhasil dibuat';
        }

        $this->new_image = null;
        $this->loadHeroSpmb();
        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
    }

    public function cancel()
    {
        $this->resetErrorBag();
        $this->reset(['new_image']);
        $this->loadHeroSpmb();
        $this->closeModal();
    }

    public function deleteImage()
    {
        if ($this->heroSpmb && $this->heroSpmb->image) {
            if (Storage::disk('public')->exists($this->heroSpmb->image)) {
                Storage::disk('public')->delete($this->heroSpmb->image);
            }

            $this->heroSpmb->update(['image' => null]);
            $this->loadHeroSpmb();
            $this->dispatch("alert", message: "Berhasil menghapus gambar", type: "success");
        }
    }

    public function render()
    {
        return view('livewire.admin.landing.hero-spmb-section');
    }
}