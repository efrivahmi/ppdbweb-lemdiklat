<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Gallery;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Gallery")]
class GallerySection extends Component
{
    use WithPagination, WithFileUploads;

    // Properties
    public $search = '';
    public $galleryId;
    public $title;
    public $image;
    public $new_image;
    public $editMode = false;

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
        ];

        if (!$this->editMode || $this->new_image) {
            $rules['new_image'] = 'required|image|max:2048|mimes:jpg,jpeg,png';
        } elseif ($this->new_image) {
            $rules['new_image'] = 'image|max:2048|mimes:jpg,jpeg,png';
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'Judul harus diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'new_image.required' => 'Gambar harus diupload',
        'new_image.image' => 'File harus berupa gambar',
        'new_image.max' => 'Ukuran gambar maksimal 2MB',
        'new_image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->dispatch('open-modal', name: 'gallery-modal');
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        $this->galleryId = $gallery->id;
        $this->title = $gallery->title;
        $this->image = $gallery->image;
        $this->editMode = true;
        
        $this->dispatch('open-modal', name: 'gallery-modal');
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $gallery = Gallery::findOrFail($this->galleryId);
                
                // Handle image upload
                if ($this->new_image) {
                    // Delete old image
                    if ($gallery->image) {
                        Storage::disk('public')->delete($gallery->image);
                    }
                    
                    $imagePath = $this->new_image->store('galleries', 'public');
                    $gallery->image = $imagePath;
                }
                
                $gallery->title = $this->title;
                $gallery->save();
                
                session()->flash('message', 'Galeri berhasil diupdate!');
            } else {
                $imagePath = $this->new_image->store('galleries', 'public');
                
                Gallery::create([
                    'title' => $this->title,
                    'image' => $imagePath,
                ]);
                
                session()->flash('message', 'Galeri berhasil ditambahkan!');
            }

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            // Delete image from storage
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            
            $gallery->delete();
            
            session()->flash('message', 'Galeri berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteImage($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
                $gallery->image = null;
                $gallery->save();
                
                session()->flash('message', 'Gambar berhasil dihapus!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->dispatch('close-modal', name: 'gallery-modal');
    }

    private function resetForm()
    {
        $this->reset(['galleryId', 'title', 'image', 'new_image', 'editMode']);
        $this->resetValidation();
    }

    public function render()
    {
        $galleries = Gallery::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);

        return view('livewire.admin.landing.gallery-section', [
            'galleries' => $galleries
        ]);
    }
}