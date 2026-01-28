<?php

namespace App\Livewire\Components\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $userDropdownOpen = false;
    public $notificationDropdownOpen = false;

    protected $notifications = [
        [
            'id' => 1,
            'title' => 'Pendaftaran siswa baru diterima',
            'time' => '2 menit yang lalu',
            'type' => 'info',
            'color' => 'blue-500'
        ],
        [
            'id' => 2,
            'title' => 'Verifikasi dokumen selesai',
            'time' => '1 jam yang lalu',
            'type' => 'success',
            'color' => 'green-500'
        ],
        [
            'id' => 3,
            'title' => 'Pembayaran berhasil diverifikasi',
            'time' => '3 jam yang lalu',
            'type' => 'success',
            'color' => 'lime-500'
        ],
        [
            'id' => 4,
            'title' => 'Data siswa perlu diverifikasi',
            'time' => '5 jam yang lalu',
            'type' => 'warning',
            'color' => 'yellow-500'
        ],
        [
            'id' => 5,
            'title' => 'Sistem backup berhasil',
            'time' => '1 hari yang lalu',
            'type' => 'info',
            'color' => 'blue-500'
        ]
    ];

    protected $userMenuItems = [
        [
            'name' => 'Profile Settings',
            'icon' => 'ri-user-line',
            'url' => 'admin.profile',
            'action' => null
        ],
        // [
        //     'name' => 'System Settings',
        //     'icon' => 'ri-settings-3-line',
        //     'url' => 'admin.dashboard',
        //     'action' => null
        // ],
        // [
        //     'name' => 'User Management',
        //     'icon' => 'ri-group-line',
        //     'url' => 'admin.siswa',
        //     'action' => null
        // ]
    ];

    public function toggleSidebar()
    {
        $this->dispatch('toggle-sidebar');
    }

    public function toggleUserDropdown()
    {
        $this->userDropdownOpen = !$this->userDropdownOpen;
        $this->notificationDropdownOpen = false;
    }

    public function toggleNotificationDropdown()
    {
        $this->notificationDropdownOpen = !$this->notificationDropdownOpen;
        $this->userDropdownOpen = false;
    }

    public function closeDropdowns()
    {
        $this->userDropdownOpen = false;
        $this->notificationDropdownOpen = false;
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->dispatch('notification-read', $notificationId);
    }

    public function markAllNotificationsAsRead()
    {
        $this->dispatch('all-notifications-read');
    }

    public function getNotifications()
    {
        return $this->notifications;
    }

    public function getUserMenuItems()
    {
        return collect($this->userMenuItems)->map(function ($item) {
            if (isset($item['url']) && $item['url'] !== '') {
                try {
                    $item['url'];
                } catch (\Exception $e) {
                    $item['url'] = 'admin.dashboard';
                }
            }
            return $item;
        })->toArray();
    }

    public function getUnreadNotificationCount()
    {
        return count($this->notifications); 
    }

    public function render()
    {
        return view('livewire.components.admin.navbar', [
            'notifications' => $this->getNotifications(),
            'userMenuItems' => $this->getUserMenuItems(),
            'unreadCount' => $this->getUnreadNotificationCount()
        ]);
    }
}