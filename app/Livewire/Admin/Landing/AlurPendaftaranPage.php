<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\AlurPendaftaran;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Alur Pendaftaran")]
class AlurPendaftaranPage extends Component
{
    use WithPagination;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $title, $description, $icon, $order_num;

    public $availableIcons = [
        'user-plus', 'document-text', 'academic-cap', 'arrow-down-tray', 
        'credit-card', 'computer-desktop', 'check-badge', 'information-circle',
        'document-check', 'clipboard-document-check', 'calendar-days', 
        'banknotes', 'users', 'identification', 'building-library', 
        'building-office', 'pencil-square', 'chat-bubble-left-ellipsis',
        'shield-check', 'clipboard', 'document-duplicate', 'envelope'
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'icon' => 'required|string|max:255',
        'order_num' => 'required|integer',
    ];

    protected $messages = [
        'title.required' => 'Judul wajib diisi',
        'description.required' => 'Deskripsi wajib diisi',
        'icon.required' => 'Ikon wajib diisi (contoh: check-circle)',
        'order_num.required' => 'Urutan wajib diisi',
    ];

    protected $listeners = [
        'search-changed' => 'updateSearch',
        'search-cleared' => 'clearSearch',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'alur-pendaftaran-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'alur-pendaftaran-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'icon', 'order_num', 'editMode', 'selectedId']);
        $this->resetErrorBag();
        
        // Auto-increment order_num for new item
        $lastOrder = AlurPendaftaran::max('order_num') ?? 0;
        $this->order_num = $lastOrder + 1;
        $this->icon = 'check-circle';
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal();
    }

    public function edit($id)
    {
        $alur = AlurPendaftaran::findOrFail($id);
        $this->selectedId = $id;
        $this->title = $alur->title;
        $this->description = $alur->description;
        $this->icon = $alur->icon;
        $this->order_num = $alur->order_num;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'order_num' => $this->order_num,
        ];

        if ($this->editMode) {
            $alur = AlurPendaftaran::findOrFail($this->selectedId);
            $alur->update($data);
            $message = 'Alur pendaftaran berhasil diperbarui';
        } else {
            AlurPendaftaran::create($data);
            $message = 'Alur pendaftaran berhasil ditambahkan';
        }

        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
    }

    public function cancel()
    {
        $this->resetForm();
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $alur = AlurPendaftaran::findOrFail($id);
            $alur->delete();
            $this->dispatch("alert", message: "Alur pendaftaran berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus data", type: "error");
        }
    }

    // Filter methods
    public function updateSearch($data)
    {
        $this->search = $data['search'] ?? '';
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $alurPendaftarans = AlurPendaftaran::where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('order_num', 'asc')
            ->paginate(10);
            
        return view('livewire.admin.landing.alur-pendaftaran-page', [
            'alurPendaftarans' => $alurPendaftarans
        ]);
    }
}
