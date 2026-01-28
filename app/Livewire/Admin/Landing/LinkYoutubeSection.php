<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\YoutubeVideo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Setting Link Youtube")]
class LinkYoutubeSection extends Component
{
    use WithPagination;

    public $search = '';
    public $youtubeVideoId;
    public $url = '';
    public $title = '';
    public $description = '';
    public $order = 0;
    public $is_active = true;
    public $editMode = false;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'url' => 'required|url',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'url.required' => 'URL YouTube wajib diisi',
        'url.url' => 'Format URL tidak valid',
        'title.required' => 'Judul wajib diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'description.max' => 'Deskripsi maksimal 1000 karakter',
        'order.required' => 'Urutan wajib diisi',
        'order.integer' => 'Urutan harus berupa angka',
        'order.min' => 'Urutan minimal 0',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->dispatch('open-modal', name: 'youtube-video-modal');
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->youtubeVideoId = $id;

        $video = YoutubeVideo::findOrFail($id);
        $this->url = $video->url;
        $this->title = $video->title;
        $this->description = $video->description;
        $this->order = $video->order;
        $this->is_active = $video->is_active;

        $this->dispatch('open-modal', name: 'youtube-video-modal');
    }

    public function save()
    {
        $this->validate();

        // Validasi URL YouTube
        if (!YoutubeVideo::validateYoutubeUrl($this->url)) {
            $this->addError('url', 'URL harus merupakan link YouTube yang valid');
            return;
        }

        try {
            if ($this->editMode) {
                $video = YoutubeVideo::findOrFail($this->youtubeVideoId);
                $video->update([
                    'url' => $this->url,
                    'title' => $this->title,
                    'description' => $this->description,
                    'order' => $this->order,
                    'is_active' => $this->is_active,
                ]);

                session()->flash('message', 'Video YouTube berhasil diperbarui!');
            } else {
                YoutubeVideo::create([
                    'url' => $this->url,
                    'title' => $this->title,
                    'description' => $this->description,
                    'order' => $this->order,
                    'is_active' => $this->is_active,
                ]);

                session()->flash('message', 'Video YouTube berhasil ditambahkan!');
            }

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $video = YoutubeVideo::findOrFail($id);
            $video->delete();

            session()->flash('message', 'Video YouTube berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $video = YoutubeVideo::findOrFail($id);
            $video->update(['is_active' => !$video->is_active]);

            session()->flash('message', 'Status video berhasil diubah!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->dispatch('close-modal', name: 'youtube-video-modal');
    }

    private function resetForm()
    {
        $this->reset(['youtubeVideoId', 'url', 'title', 'description', 'order', 'is_active', 'editMode']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.landing.link-youtube-section', [
            'youtubeVideos' => YoutubeVideo::query()
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('url', 'like', '%' . $this->search . '%');
                })
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }
}