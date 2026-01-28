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
    public $logo_kiri = null;
    public $logo_kanan = null;
    public $pesan_pembayaran = '';
    public $catatan_penting = '';
    public $logo_kiri_preview = null;
    public $logo_kanan_preview = null;
    
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
    
    // Operators
    public $operators = [];
    public $editOperatorMode = false;
    public $selectedOperatorId = null;
    public $operator_nama = '';
    public $operator_jabatan = '';
    public $operator_is_active = true;

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
            'logo_kiri' => 'nullable|image|max:2048',
            'logo_kanan' => 'nullable|image|max:2048',
            'pesan_pembayaran' => 'nullable|string',
            'catatan_penting' => 'nullable|string',
            'maps_embed_link' => 'nullable|string',
            'maps_image' => 'nullable|image|max:2048',
            'operator_nama' => 'required|string|max:255',
            'operator_jabatan' => 'required|string|max:255',
        ];
    }

    protected $messages = [
        'nama_sekolah.required' => 'Nama sekolah wajib diisi',
        'alamat.required' => 'Alamat sekolah wajib diisi',
        'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
        'operator_nama.required' => 'Nama operator wajib diisi',
        'operator_jabatan.required' => 'Jabatan operator wajib diisi',
    ];

    public function mount()
    {
        $this->loadSchoolSettings();
        $this->loadOperators();
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
            $this->pesan_pembayaran = $settings->pesan_pembayaran;
            $this->catatan_penting = $settings->catatan_penting;
            $this->logo_kiri_preview = $settings->logo_kiri_url;
            $this->logo_kanan_preview = $settings->logo_kanan_url;
            $this->maps_embed_link = $settings->maps_embed_link ?? '';
            $this->maps_image_preview = $settings->maps_image_url;
            $this->social_links = $settings->social_links ?? [];
        } else {
            $this->tahun_ajaran = date('Y') . '/' . (date('Y') + 1);
            $this->social_links = [];
        }
    }

    public function loadOperators()
    {
        $this->operators = Operator::latest()->get();
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
            'logo_kiri' => $this->rules()['logo_kiri'],
            'logo_kanan' => $this->rules()['logo_kanan'],
            'pesan_pembayaran' => $this->rules()['pesan_pembayaran'],
            'catatan_penting' => $this->rules()['catatan_penting'],
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
                'pesan_pembayaran' => $this->pesan_pembayaran,
                'catatan_penting' => $this->catatan_penting,
                'maps_embed_link' => $this->maps_embed_link,
                'social_links' => $this->social_links,
            ];

            // Handle logo uploads
            if ($this->logo_kiri) {
                if ($this->schoolId) {
                    $oldSettings = SchoolSetting::find($this->schoolId);
                    if ($oldSettings && $oldSettings->logo_kiri) {
                        Storage::disk('public')->delete($oldSettings->logo_kiri);
                    }
                }
                $data['logo_kiri'] = $this->logo_kiri->store('school/logos', 'public');
            }

            if ($this->logo_kanan) {
                if ($this->schoolId) {
                    $oldSettings = SchoolSetting::find($this->schoolId);
                    if ($oldSettings && $oldSettings->logo_kanan) {
                        Storage::disk('public')->delete($oldSettings->logo_kanan);
                    }
                }
                $data['logo_kanan'] = $this->logo_kanan->store('school/logos', 'public');
            }

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

    // Operator Methods
    public function openOperatorModal()
    {
        $this->dispatch('open-modal', name: 'operator');
    }
    
    public function closeOperatorModal()
    {
        $this->dispatch('close-modal', name: 'operator');
        $this->resetOperatorForm();
    }

    public function resetOperatorForm()
    {
        $this->reset(['operator_nama', 'operator_jabatan', 'operator_is_active', 'editOperatorMode', 'selectedOperatorId']);
        $this->operator_is_active = true;
        $this->resetErrorBag();
    }

    public function createOperator()
    {
        $this->resetOperatorForm();
        $this->editOperatorMode = false;
        $this->openOperatorModal();
    }

    public function editOperator($id)
    {
        $operator = Operator::findOrFail($id);
        $this->selectedOperatorId = $id;
        $this->operator_nama = $operator->nama;
        $this->operator_jabatan = $operator->jabatan;
        $this->operator_is_active = $operator->is_active;
        $this->editOperatorMode = true;
        $this->openOperatorModal();
    }

    public function saveOperator()
    {
        $this->validate([
            'operator_nama' => $this->rules()['operator_nama'],
            'operator_jabatan' => $this->rules()['operator_jabatan'],
        ]);

        try {
            if ($this->editOperatorMode) {
                $operator = Operator::findOrFail($this->selectedOperatorId);
                $operator->update([
                    'nama' => $this->operator_nama,
                    'jabatan' => $this->operator_jabatan,
                    'is_active' => $this->operator_is_active,
                ]);
                $message = 'Operator berhasil diperbarui';
            } else {
                // Set all operators to inactive if this one is active
                if ($this->operator_is_active) {
                    Operator::where('is_active', true)->update(['is_active' => false]);
                }
                
                Operator::create([
                    'nama' => $this->operator_nama,
                    'jabatan' => $this->operator_jabatan,
                    'is_active' => $this->operator_is_active,
                ]);
                $message = 'Operator berhasil ditambahkan';
            }

            $this->closeOperatorModal();
            $this->dispatch('success', message: $message);
            $this->loadOperators();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Terjadi kesalahan saat menyimpan operator');
        }
    }

    public function deleteOperator($id)
    {
        try {
            Operator::findOrFail($id)->delete();
            $this->dispatch('success', message: 'Operator berhasil dihapus');
            $this->loadOperators();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Terjadi kesalahan saat menghapus operator');
        }
    }

    public function toggleOperatorStatus($id)
    {
        try {
            $operator = Operator::findOrFail($id);
            
            if (!$operator->is_active) {
                // Set all others to inactive
                Operator::where('is_active', true)->update(['is_active' => false]);
            }
            
            $operator->update(['is_active' => !$operator->is_active]);
            $message = 'Status operator berhasil ' . ($operator->is_active ? 'diaktifkan' : 'dinonaktifkan');
            $this->dispatch('success', message: $message);
            $this->loadOperators();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Terjadi kesalahan saat mengubah status');
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