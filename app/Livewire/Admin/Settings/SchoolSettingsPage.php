<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Admin\SchoolSetting;
use App\Models\Admin\Operator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SchoolSettingsPage extends Component
{
    use WithFileUploads;
    
    // School Settings
    public $schoolId = null;
    public $nama_sekolah = '';
    public $alamat = '';
    public $kode_pos = '';
    public $telp = '';
    public $email = '';
    public $website = '';
    public $tahun_ajaran = '';

    // Maps Settings
    public $maps_embed_link = '';
    public $maps_image = null;
    public $maps_image_preview = null;
    
    // Social Media Links
    public $social_links = [];
    public $availablePlatforms = [
        'website' => ['name' => 'Website', 'icon' => 'ri-global-line', 'placeholder' => 'https://www.example.com'],
        'facebook' => ['name' => 'Facebook', 'icon' => 'ri-facebook-fill', 'placeholder' => 'https://facebook.com/yourpage'],
        'instagram' => ['name' => 'Instagram', 'icon' => 'ri-instagram-fill', 'placeholder' => 'https://instagram.com/yourpage'],
        'twitter' => ['name' => 'Twitter/X', 'icon' => 'ri-twitter-x-fill', 'placeholder' => 'https://x.com/yourpage'],
        'youtube' => ['name' => 'YouTube', 'icon' => 'ri-youtube-fill', 'placeholder' => 'https://youtube.com/@yourchannel'],
        'tiktok' => ['name' => 'TikTok', 'icon' => 'ri-tiktok-fill', 'placeholder' => 'https://tiktok.com/@yourpage'],
        'whatsapp' => ['name' => 'WhatsApp', 'icon' => 'ri-whatsapp-fill', 'placeholder' => 'https://wa.me/6281234567890'],
        'linkedin' => ['name' => 'LinkedIn', 'icon' => 'ri-linkedin-fill', 'placeholder' => 'https://linkedin.com/company/yourcompany'],
    ];
    
    protected function rules()
    {
        return [
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kode_pos' => 'nullable|string|max:10',
            'telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'tahun_ajaran' => 'required|string|max:20',
            'maps_embed_link' => 'nullable|string',
            'maps_image' => 'nullable|image|max:2048',
        ];
    }

    protected $messages = [
        'nama_sekolah.required' => 'Nama sekolah wajib diisi',
        'alamat.required' => 'Alamat sekolah wajib diisi',
        'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
    ];

    public function mount()
    {
        $this->loadSchoolSettings();
    }

    public function loadSchoolSettings()
    {
        $settings = SchoolSetting::first();
        if ($settings) {
            $this->schoolId = $settings->id;
            $this->nama_sekolah = $settings->nama_sekolah;
            $this->alamat = $settings->alamat;
            $this->kode_pos = $settings->kode_pos;
            $this->telp = $settings->telp;
            $this->email = $settings->email;
            $this->website = $settings->website;
            $this->tahun_ajaran = $settings->tahun_ajaran;
            $this->maps_embed_link = $settings->maps_embed_link ?? '';
            $this->maps_image_preview = $settings->maps_image_url;
            $this->social_links = $settings->social_links ?? [];
        } else {
            $this->tahun_ajaran = date('Y') . '/' . (date('Y') + 1);
            $this->social_links = [];
        }
    }

    public function saveSchoolSettings()
    {
        $this->validate([
            'nama_sekolah' => $this->rules()['nama_sekolah'],
            'alamat' => $this->rules()['alamat'],
            'kode_pos' => $this->rules()['kode_pos'],
            'telp' => $this->rules()['telp'],
            'email' => $this->rules()['email'],
            'website' => $this->rules()['website'],
            'tahun_ajaran' => $this->rules()['tahun_ajaran'],
            'maps_embed_link' => $this->rules()['maps_embed_link'],
            'maps_image' => $this->rules()['maps_image'],
        ]);

        try {
            $data = [
                'nama_sekolah' => $this->nama_sekolah,
                'alamat' => $this->alamat,
                'kode_pos' => $this->kode_pos,
                'telp' => $this->telp,
                'email' => $this->email,
                'website' => $this->website,
                'tahun_ajaran' => $this->tahun_ajaran,
                'maps_embed_link' => $this->maps_embed_link,
                'social_links' => $this->social_links,
            ];

            // Handle maps image upload
            if ($this->maps_image) {
                if ($this->schoolId) {
                    $oldSettings = SchoolSetting::find($this->schoolId);
                    if ($oldSettings && $oldSettings->maps_image_path) {
                        Storage::disk('public')->delete($oldSettings->maps_image_path);
                    }
                }
                $data['maps_image_path'] = $this->maps_image->store('settings', 'public');
            }

            if ($this->schoolId) {
                SchoolSetting::find($this->schoolId)->update($data);
                $message = 'Pengaturan sekolah berhasil diperbarui';
            } else {
                $settings = SchoolSetting::create($data);
                $this->schoolId = $settings->id;
                $message = 'Pengaturan sekolah berhasil disimpan';
            }

            // Cache busting - clear the cached settings so frontend updates immediately
            SchoolSetting::clearCache();

            $this->dispatch('success', message: $message);
            $this->loadSchoolSettings();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Terjadi kesalahan saat menyimpan pengaturan');
        }
    }

    // Social Links Methods
    public function addSocialLink()
    {
        $this->social_links[] = [
            'platform' => 'website',
            'url' => '',
        ];
    }

    public function removeSocialLink($index)
    {
        unset($this->social_links[$index]);
        $this->social_links = array_values($this->social_links);
    }

    public function render()
    {
        return view('livewire.admin.settings.school-settings-page')
            ->layout('layouts.admin', ['title' => 'Pengaturan Sekolah']);
    }
}