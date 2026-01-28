<?php

namespace App\Livewire\Components\Siswa;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $userDropdownOpen = false;
    public $notificationDropdownOpen = false;

    protected $notifications = [
        [
            'id' => 1,
            'title' => 'Pendaftaran siswa baru',
            'time' => '2 menit yang lalu',
            'type' => 'info',
            'color' => 'lime-500'
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
            'title' => 'Reminder: Lengkapi berkas',
            'time' => '3 jam yang lalu',
            'type' => 'warning',
            'color' => 'yellow-500'
        ]
    ];

    protected $userMenuItems = [
        [
            'name' => 'Profile',
            'icon' => 'ri-user-line',
            'url' => 'siswa.profile',
            'action' => null
        ],
    ];

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

    public function getNotifications()
    {
        return $this->notifications;
    }

    public function getUserMenuItems()
    {
        return $this->userMenuItems;
    }

    public function getUnreadNotificationCount()
    {
        return count($this->notifications);
    }

    public function render()
    {
        return view('livewire.components.siswa.navbar', [
            'notifications' => $this->getNotifications(),
            'userMenuItems' => $this->getUserMenuItems(),
            'unreadCount' => $this->getUnreadNotificationCount()
        ]);
    }
}