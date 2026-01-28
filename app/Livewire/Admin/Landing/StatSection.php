<?php

namespace App\Livewire\Admin\Landing;

use Livewire\Component;
use App\Models\Landing\StatSections;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Stat Section")]
class StatSection extends Component
{
    public $stats = [];

    public function mount()
    {
        // Ambil semua stat
        $this->stats = StatSections::all()->toArray();
    }

    public function updateStat($id, $field, $value)
    {
        $stat = StatSections::find($id);

        // hanya bisa update kalau editable
        if ($stat && $stat->is_editable && in_array($field, ['label', 'value'])) {
            $stat->update([$field => $value]);
            $this->dispatch("alert", message: "Stat berhasil diperbarui", type: "success");
        } else {
            $this->dispatch("alert", message: "Stat ini tidak bisa diedit", type: "error");
        }
    }

    public function render()
    {
        return view('livewire.admin.landing.stat-section');
    }
}
