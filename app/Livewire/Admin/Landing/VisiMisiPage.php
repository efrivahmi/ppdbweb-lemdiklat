<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\VisiMisi;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Visi Misi")]
class VisiMisiPage extends Component
{
    use WithPagination;
    
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $type = 'visi';
    public $title = '';
    public $content = '';
    public $item_title = '';
    public $item_description = '';
    public $order = 1;
    public $is_active = true;
    public $content_type = 'main'; // 'main' or 'item'

    // Search and filter
    public $search = '';
    public $filterType = '';
    public $filterContentType = '';

    protected $rules = [
        'type' => 'required|in:visi,misi',
        'title' => 'required_if:content_type,main|string|max:255',
        'content' => 'required_if:content_type,main|string',
        'item_title' => 'required_if:content_type,item|string|max:255',
        'item_description' => 'required_if:content_type,item|string',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
        'content_type' => 'required|in:main,item',
    ];

    protected $messages = [
        'type.required' => 'Tipe wajib dipilih',
        'type.in' => 'Tipe harus berupa visi atau misi',
        'title.required_if' => 'Judul wajib diisi untuk konten utama',
        'content.required_if' => 'Deskripsi wajib diisi untuk konten utama',
        'item_title.required_if' => 'Judul item wajib diisi untuk item',
        'item_description.required_if' => 'Deskripsi item wajib diisi untuk item',
        'order.required' => 'Urutan wajib diisi',
        'order.integer' => 'Urutan harus berupa angka',
        'order.min' => 'Urutan minimal 0',
        'content_type.required' => 'Jenis konten wajib dipilih',
    ];

    public function updatedContentType()
    {
        // Jangan reset jika sedang dalam edit mode
        if (!$this->editMode) {
            // Reset form ketika content type berubah
            $this->reset(['title', 'content', 'item_title', 'item_description']);
            
            // Set order berdasarkan content type
            if ($this->content_type === 'main') {
                $this->order = 0;
            } else {
                $this->order = $this->getNextOrder();
            }
        }
    }

    public function updatedType()
    {
        // Jangan reset order jika sedang dalam edit mode  
        if (!$this->editMode) {
            // Reset order ketika type berubah
            $this->order = $this->content_type === 'main' ? 0 : $this->getNextOrder();
        }
    }

    private function getNextOrder()
    {
        $maxOrder = VisiMisi::where('type', $this->type)
            ->whereNotNull('item_title')
            ->max('order');
        
        return ($maxOrder ?? 0) + 1;
    }

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'visi-misi-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'visi-misi-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset([
            'type', 'title', 'content', 'item_title', 'item_description', 
            'order', 'is_active', 'content_type', 'editMode', 'selectedId'
        ]);
        $this->type = 'visi';
        $this->is_active = true;
        $this->content_type = 'main';
        $this->order = 0;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal();
    }

    public function edit($id)
    {
        try {
            $visimisi = VisiMisi::findOrFail($id);
            
            // Set edit mode first  
            $this->editMode = true;
            $this->selectedId = $id;
            
            // Load data
            $this->type = $visimisi->type;
            $this->title = $visimisi->title ?? '';
            $this->content = $visimisi->content ?? '';
            $this->item_title = $visimisi->item_title ?? '';
            $this->item_description = $visimisi->item_description ?? '';
            $this->order = $visimisi->order;
            $this->is_active = $visimisi->is_active;
            
            // Determine content type
            $this->content_type = $visimisi->isMainContent() ? 'main' : 'item';
            
            // Clear any previous validation errors
            $this->resetErrorBag();
            $this->resetValidation();
            
            $this->openModal();
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi error", type: "error");
        }
    }

    public function save()
    {
        // Validasi terlebih dahulu
        $this->validate();

        $data = [
            'type' => $this->type,
            'order' => (int) $this->order,
            'is_active' => (bool) $this->is_active,
        ];

        if ($this->content_type === 'main') {
            $data['title'] = $this->title;
            $data['content'] = $this->content;
            $data['item_title'] = null;
            $data['item_description'] = null;
        } else {
            $data['title'] = $this->title ?: ucfirst($this->type) . ' Kami';
            $data['content'] = null;
            $data['item_title'] = $this->item_title;
            $data['item_description'] = $this->item_description;
        }

        try {
            if ($this->editMode) {
                $visimisi = VisiMisi::findOrFail($this->selectedId);
                $visimisi->update($data);
                $message = ucfirst($this->type) . ' berhasil diperbarui';
            } else {
                VisiMisi::create($data);
                $message = ucfirst($this->type) . ' berhasil ditambahkan';
            }

            $this->closeModal();
            $this->resetForm();
            $this->dispatch("alert", message: $message, type: "success");
            $this->resetPage();
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi error", type: "error");
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $visimisi = VisiMisi::findOrFail($id);
            $type = $visimisi->type;
            $visimisi->delete();
            $this->dispatch("alert", message: "Berhasil di hapus", type: "success");
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus visi misi", type: "error");
        }
    }

    public function toggleActive($id)
    {
        try {
            $visimisi = VisiMisi::findOrFail($id);
            $visimisi->update(['is_active' => !$visimisi->is_active]);
            
            $status = $visimisi->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch("alert", message: "Berhasil " . $status, type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Tidak dapat mengganti status", type: "error");
        }
    }

    public function updateOrder($id, $newOrder)
    {
        try {
            $visimisi = VisiMisi::findOrFail($id);
            $visimisi->update(['order' => $newOrder]);
            $this->dispatch("alert", message: "Berhasil memperbarui urutan", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal memperbarui urutan", type: "error");
        }
    }

    public function render()
    {
        $query = VisiMisi::query();

        // Apply search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%')
                  ->orWhere('item_title', 'like', '%' . $this->search . '%')
                  ->orWhere('item_description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filters
        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->filterContentType) {
            if ($this->filterContentType === 'main') {
                $query->whereNull('item_title');
            } else {
                $query->whereNotNull('item_title');
            }
        }

        $visimisis = $query->orderBy('type', 'asc')
            ->orderBy('order', 'asc')
            ->paginate(15);

        // Statistics
        $visiMainCount = VisiMisi::visi()->whereNull('item_title')->count();
        $visiItemCount = VisiMisi::visi()->whereNotNull('item_title')->count();
        $misiMainCount = VisiMisi::misi()->whereNull('item_title')->count();
        $misiItemCount = VisiMisi::misi()->whereNotNull('item_title')->count();
        
        return view('livewire.admin.landing.visi-misi-page', [
            'visimisis' => $visimisis,
            'visiMainCount' => $visiMainCount,
            'visiItemCount' => $visiItemCount,
            'misiMainCount' => $misiMainCount,
            'misiItemCount' => $misiItemCount,
        ]);
    }
}