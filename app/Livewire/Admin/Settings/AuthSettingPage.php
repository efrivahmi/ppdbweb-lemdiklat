<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Settings\AuthSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Halaman Auth")]
class AuthSettingPage extends Component
{
    use WithFileUploads;

    public $authSetting;

    public $title;
    public $subtitle;
    public $description;
    public $image;
    public $new_image;

    protected $rules = [
        'title' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'new_image' => 'nullable|image|max:5120', // 5MB Max
    ];

    protected $messages = [
        'new_image.image' => 'File harus berupa gambar',
        'new_image.max' => 'Ukuran gambar maksimal 5MB',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->authSetting = AuthSetting::first();

        if ($this->authSetting) {
            $this->title = $this->authSetting->title;
            $this->subtitle = $this->authSetting->subtitle;
            $this->description = $this->authSetting->description;
            $this->image = $this->authSetting->image;
        } else {
            // Set defaults if null
            $this->title = 'Selamat Datang di SPMB';
            $this->subtitle = '2026/2027';
            $this->description = 'Sistem Penerimaan Murid Baru';
        }
    }

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'auth-setting-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'auth-setting-modal');
        $this->resetErrorBag();
    }

    public function edit()
    {
        $this->loadData();
        $this->resetErrorBag();
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
        ];

        if ($this->new_image) {
            if ($this->authSetting && $this->authSetting->image && Storage::disk('public')->exists($this->authSetting->image)) {
                Storage::disk('public')->delete($this->authSetting->image);
            }

            $imagePath = $this->new_image->store('auth-settings', 'public');
            $data['image'] = $imagePath;
        } elseif ($this->authSetting && $this->authSetting->image) {
            $data['image'] = $this->authSetting->image;
        }

        if ($this->authSetting) {
            $this->authSetting->update($data);
            $message = 'Pengaturan Halaman Auth berhasil diperbarui';
        } else {
            AuthSetting::create($data);
            $message = 'Pengaturan Halaman Auth berhasil dibuat';
        }

        $this->new_image = null;
        $this->loadData();
        $this->closeModal();
        
        $this->dispatch("alert", message: $message, type: "success");
        session()->flash('message', $message);
    }

    public function deleteImage()
    {
        if ($this->authSetting && $this->authSetting->image) {
            if (Storage::disk('public')->exists($this->authSetting->image)) {
                Storage::disk('public')->delete($this->authSetting->image);
            }
            $this->authSetting->update(['image' => null]);
            $this->image = null;
            session()->flash('message', 'Gambar berhasil dihapus');
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.auth-setting-page');
    }
}
