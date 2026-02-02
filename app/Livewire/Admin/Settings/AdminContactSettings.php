<?php

namespace App\Livewire\Admin\Settings;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Pengaturan Kontak Admin")]
class AdminContactSettings extends Component
{
    use WithPagination;

    public $search = '';

    public function toggleVisibility($adminId)
    {
        $admin = User::find($adminId);
        if ($admin && $admin->role === 'admin') {
            $admin->show_in_contact = !$admin->show_in_contact;
            $admin->save();
            $this->dispatch('alert', message: 'Status visibilitas diperbarui', type: 'success');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $admins = User::where('role', 'admin')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.settings.admin-contact-settings', [
            'admins' => $admins
        ]);
    }
}
