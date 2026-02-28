<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.siswa')]
#[Title('Semua Notifikasi')]
class NotificationPage extends Component
{
    use WithPagination;

    public function mount()
    {
        // Mark all as read when visiting this page
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        $this->resetPage();
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        
        return view('livewire.siswa.notification-page', [
            'notifications' => $notifications
        ]);
    }
}
