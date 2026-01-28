<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\LinkPhoto;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Setting Link Photo")]
class LinkPhotoSection extends Component
{
    use WithPagination, WithFileUploads;

    // Properties
    public $search = '';
    public $linkPhotoId;
    public $title;
    public $url;
    public $image;
    public $new_image;
    public $editMode = false;

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
        ];

        if ($this->new_image) {
            $rules['new_image'] = 'image|max:2048|mimes:jpg,jpeg,png';
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'Judul harus diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'url.required' => 'URL harus diisi',
        'url.url' => 'URL tidak valid',
        'url.max' => 'URL maksimal 500 karakter',
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
        $this->dispatch('open-modal', name: 'link-photo-modal');
    }

    public function edit($id)
    {
        $linkPhoto = LinkPhoto::findOrFail($id);
        
        $this->linkPhotoId = $linkPhoto->id;
        $this->title = $linkPhoto->title;
        $this->url = $linkPhoto->url;
        $this->image = $linkPhoto->image;
        $this->editMode = true;
        
        $this->dispatch('open-modal', name: 'link-photo-modal');
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $linkPhoto = LinkPhoto::findOrFail($this->linkPhotoId);
                
                // Handle image upload
                if ($this->new_image) {
                    // Delete old image
                    if ($linkPhoto->image) {
                        Storage::disk('public')->delete($linkPhoto->image);
                    }
                    
                    $imagePath = $this->new_image->store('link-photos', 'public');
                    $linkPhoto->image = $imagePath;
                }
                
                $linkPhoto->title = $this->title;
                $linkPhoto->url = $this->url;
                $linkPhoto->save();
                
                session()->flash('message', 'Link Photo berhasil diupdate!');
            } else {
                $data = [
                    'title' => $this->title,
                    'url' => $this->url,
                ];
                
                // Handle image upload
                if ($this->new_image) {
                    $imagePath = $this->new_image->store('link-photos', 'public');
                    $data['image'] = $imagePath;
                }
                
                LinkPhoto::create($data);
                
                session()->flash('message', 'Link Photo berhasil ditambahkan!');
            }

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $linkPhoto = LinkPhoto::findOrFail($id);
            
            // Delete image from storage
            if ($linkPhoto->image) {
                Storage::disk('public')->delete($linkPhoto->image);
            }
            
            $linkPhoto->delete();
            
            session()->flash('message', 'Link Photo berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteImage($id)
    {
        try {
            $linkPhoto = LinkPhoto::findOrFail($id);
            
            if ($linkPhoto->image) {
                Storage::disk('public')->delete($linkPhoto->image);
                $linkPhoto->image = null;
                $linkPhoto->save();
                
                session()->flash('message', 'Gambar berhasil dihapus!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->dispatch('close-modal', name: 'link-photo-modal');
    }

    private function resetForm()
    {
        $this->reset(['linkPhotoId', 'title', 'url', 'image', 'new_image', 'editMode']);
        $this->resetValidation();
    }

    public function render()
    {
        $linkPhotos = LinkPhoto::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('url', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.landing.link-photo-section', [
            'linkPhotos' => $linkPhotos
        ]);
    }
}