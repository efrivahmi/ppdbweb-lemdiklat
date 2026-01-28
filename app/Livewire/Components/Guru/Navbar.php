<?php

namespace App\Livewire\Components\Guru;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $userDropdownOpen = false;
    public $notificationDropdownOpen = false;

    protected $notifications = [
        [
            'id' => 1,
            'title' => 'Review test essay siswa',
            'time' => '15 menit yang lalu',
            'type' => 'info',
            'color' => 'blue-500'
        ],
        [
            'id' => 2,
            'title' => 'Verifikasi transfer baru',
            'time' => '1 jam yang lalu',
            'type' => 'warning',
            'color' => 'yellow-500'
        ],
        [
            'id' => 3,
            'title' => 'Pendaftaran siswa baru',
            'time' => '2 jam yang lalu',
            'type' => 'success',
            'color' => 'green-500'
        ]
    ];

    protected $userMenuItems = [
        [
            'name' => 'Profile Settings',
            'icon' => 'ri-user-line',
            'url' => 'guru.profile',
            'action' => null
        ]
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
                    $item['url'] = 'guru.dashboard';
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
        return view('livewire.components.guru.navbar', [
            'notifications' => $this->getNotifications(),
            'userMenuItems' => $this->getUserMenuItems(),
            'unreadCount' => $this->getUnreadNotificationCount()
        ]);
    }
}