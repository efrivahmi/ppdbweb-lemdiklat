<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\About;
use Illuminate\Support\Facades\Log;

class SchoolSection extends Component
{
    public $profileData = [];
    public $isLoading = true;
    public $errorMessage = null;

    public function mount($profileData = [])
    {
        try {
            // Jika data diteruskan dari parent component, gunakan itu
            if (!empty($profileData)) {
                $this->profileData = $profileData;
            } else {
                // Ambil data dari database
                $this->profileData = About::getActiveProfile();
            }
            
            $this->isLoading = false;
        } catch (\Exception $e) {
            // Log error dan gunakan data default
            Log::error('Error loading about profile: ' . $e->getMessage());
            $this->errorMessage = 'Gagal memuat data profil sekolah';
            $this->profileData = $this->getDefaultProfileData();
            $this->isLoading = false;
        }
    }

    /**
     * Refresh data from database
     */
    public function refreshData()
    {
        try {
            $this->isLoading = true;
            $this->errorMessage = null;
            
            $this->profileData = About::getActiveProfile();
            $this->isLoading = false;
            
            // Emit event untuk memberitahu parent component
            $this->dispatch('profile-data-refreshed');
        } catch (\Exception $e) {
            Log::error('Error refreshing about profile: ' . $e->getMessage());
            $this->errorMessage = 'Gagal memuat ulang data profil';
            $this->isLoading = false;
        }
    }

    /**
     * Switch to different profile by ID
     */
    public function switchProfile($profileId)
    {
        try {
            $this->isLoading = true;
            
            $profile = About::find($profileId);
            if ($profile) {
                $this->profileData = $profile->profile_data;
            } else {
                throw new \Exception('Profile not found');
            }
            
            $this->isLoading = false;
            $this->dispatch('profile-switched', ['profileId' => $profileId]);
        } catch (\Exception $e) {
            Log::error('Error switching profile: ' . $e->getMessage());
            $this->errorMessage = 'Gagal mengganti profil';
            $this->isLoading = false;
        }
    }

    /**
     * Get all available profiles for admin/selection purposes
     */
    public function getAvailableProfiles()
    {
        return About::ordered()->get(['id', 'title_text', 'is_active']);
    }

    /**
     * Fallback data jika database kosong atau error
     */
    private function getDefaultProfileData()
    {
        return [
            'badge' => [
                'text' => 'Tentang Kami',
                'variant' => 'emerald',
                'size' => 'md'
            ],
            'title' => [
                'text' => 'Profil Sekolah',
                'highlight' => 'Sekolah',
                'size' => '3xl',
                'className' => 'lg:text-5xl'
            ],
            'descriptions' => [
                'Lemdiklat Taruna Nusantara Indonesia adalah sekolah menengah atas yang berkomitmen untuk membentuk generasi muda yang berintegritas, berkarakter, dan siap menghadapi tantangan masa depan.',
                'Dengan kurikulum komprehensif dan fasilitas modern, kami memberikan pendidikan terbaik yang menggabungkan akademik dan pengembangan karakter.'
            ],
            'image' => [
                'url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'title' => 'Gedung Sekolah',
                'description' => 'Fasilitas modern untuk mendukung proses pembelajaran'
            ],
            'contact' => [
                [
                    'icon' => 'MapPinIcon',
                    'text' => 'Jl. Pendidikan No. 123, Jakarta Selatan'
                ],
                [
                    'icon' => 'PhoneIcon',
                    'text' => '(021) 1234-5678'
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.components.landing.school-section');
    }
}