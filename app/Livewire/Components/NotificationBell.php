<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

/**
 * Real-time Notification Bell Component
 * 
 * Listens to Pusher events and displays notifications in real-time.
 * Used in admin/siswa dashboards for live updates.
 */
class NotificationBell extends Component
{
    public array $notifications = [];
    public int $unreadCount = 0;
    public bool $isOpen = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        // Load recent notifications from database
        $this->notifications = auth()->user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->data['type'] ?? 'info',
                    'icon' => $notification->data['icon'] ?? 'bell',
                    'title' => $this->getTitleForType($notification->data['type'] ?? 'info'),
                    'message' => $notification->data['message'] ?? 'Notifikasi baru',
                    'timestamp' => $notification->created_at->toIso8601String(),
                    'read_at' => $notification->read_at,
                ];
            })
            ->toArray();

        $this->unreadCount = auth()->user()->unreadNotifications()->count();
    }

    protected function getTitleForType($type)
    {
        return match($type) {
            'registration' => 'Pendaftar Baru',
            'payment' => 'Pembayaran',
            'status' => 'Status Diperbarui',
            default => 'Notifikasi',
        };
    }

    public function toggleDropdown()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->markAllAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->unreadCount = 0;
        
        // Mark loaded notifications as read locally
        $this->notifications = array_map(function($n) {
            $n['read_at'] = now();
            return $n;
        }, $this->notifications);
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        $this->notifications = [];
        $this->unreadCount = 0;
    }

    // Handlers
    #[On('echo-private:admin-dashboard,.new.registration')] 
    public function handleNewRegistration($data)
    {
        // Debugging
        // \Illuminate\Support\Facades\Log::info('Bell received new registration', $data);
        
        $this->addNotification([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'registration',
            'icon' => 'user-plus',
            'title' => 'Pendaftar Baru',
            'message' => $data['message'] ?? "Pendaftar baru: {$data['user_name']}",
            'timestamp' => $data['timestamp'] ?? now()->toIso8601String(),
            'read_at' => null,
        ]);
        
        $this->dispatch('refresh-dashboard');
    }

    #[On('echo-private:admin-dashboard,.payment.verified')]
    public function handlePaymentVerified($data)
    {
        $statusIcons = [
            'success' => 'check-circle',
            'decline' => 'x-circle',
            'pending' => 'clock',
        ];

        $this->addNotification([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'payment',
            'icon' => $statusIcons[$data['status']] ?? 'credit-card',
            'title' => 'Pembayaran',
            'message' => $data['message'] ?? "Status pembayaran {$data['user_name']} diperbarui",
            'timestamp' => $data['timestamp'] ?? now()->toIso8601String(),
            'read_at' => null,
        ]);
        
        $this->dispatch('refresh-dashboard');
    }

    #[On('echo-private:admin-dashboard,.pendaftaran.status.updated')]
    public function handleStatusUpdated($data)
    {
        $this->addNotification([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'status',
            'icon' => 'bell',
            'title' => 'Status Diperbarui',
            'message' => $data['message'] ?? "Status {$data['user_name']} diperbarui menjadi {$data['status']}",
            'timestamp' => $data['timestamp'] ?? now()->toIso8601String(),
            'read_at' => null,
        ]);
        
        $this->dispatch('refresh-dashboard');
    }

    #[On('echo-private:admin-dashboard,.dashboard.updated')]
    public function handleDashboardUpdated($data)
    {
        $this->dispatch('refresh-dashboard');
    }
    
    protected function addNotification(array $notification)
    {
        array_unshift($this->notifications, $notification);
        $this->notifications = array_slice($this->notifications, 0, 10);
        $this->unreadCount++;

        $this->dispatch('alert', 
            message: $notification['message'], 
            type: 'info'
        );
        
        // Optional: Re-fetch correct count from DB to be safe? 
        // No, let's trust the increment for UI responsiveness.
    }

    public function render()
    {
        return view('livewire.components.notification-bell');
    }
}
