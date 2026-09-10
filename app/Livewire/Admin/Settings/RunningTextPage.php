<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Settings\RunningText;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout("layouts.admin")]
#[Title("Manajemen Running Text")]
class RunningTextPage extends Component
{
    public $texts = [];
    public $text_id = null;
    public $text = '';
    public $is_active = true;
    public $showModal = false;
    public $isEdit = false;

    public function render()
    {
        $this->texts = RunningText::latest()->get();
        return view('livewire.admin.settings.running-text-page');
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->text = '';
        $this->is_active = true;
        
        if ($id) {
            $item = RunningText::find($id);
            if ($item) {
                $this->text_id = $item->id;
                $this->text = $item->text;
                $this->is_active = $item->is_active;
                $this->isEdit = true;
            }
        } else {
            $this->text_id = null;
            $this->isEdit = false;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate([
            'text' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        if ($this->isEdit && $this->text_id) {
            RunningText::find($this->text_id)->update([
                'text' => $this->text,
                'is_active' => $this->is_active
            ]);
            $this->dispatch('alert', type: 'success', message: 'Running text berhasil diperbarui.');
        } else {
            RunningText::create([
                'text' => $this->text,
                'is_active' => $this->is_active
            ]);
            $this->dispatch('alert', type: 'success', message: 'Running text berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        RunningText::find($id)->delete();
        $this->dispatch('alert', type: 'success', message: 'Running text berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $item = RunningText::find($id);
        if ($item) {
            $item->update(['is_active' => !$item->is_active]);
            $this->dispatch('alert', type: 'success', message: 'Status berhasil diubah.');
        }
    }
}
