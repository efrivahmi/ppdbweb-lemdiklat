<?php

namespace App\Livewire\Admin\ProfileSekolah;

use App\Models\Landing\ProfileSekolah;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Profile SMK Taruna Nusantara")]
class SmkPage extends Component
{
    use WithFileUploads;

    public $profile;
    
    // Hero section
    public $hero_title_prefix = 'SMK';
    public $hero_title_main = 'Taruna Nusantara Jaya';
    public $hero_subtitle = '';
    public $hero_badges = ['Akreditasi: A', 'NPSN: 87654321', 'Berdiri: 2012'];
    
    // Identity section
    public $school_name = 'SMK Taruna Nusantara Jaya';
    public $npsn = '';
    public $accreditation = 'A (Unggul)';
    public $year_founded = '';
    public $curriculum = 'Kurikulum Merdeka SMK';
    public $students_teachers = '';
    public $description = '';
    
    // Kompetensi Keahlian
    public $kompetensi = [
        [
            'name' => 'Teknik Komputer Jaringan & Telekomunikasi',
            'code' => 'TKJT',
            'color' => 'blue',
            'description' => 'Mempelajari rancang bangun infrastruktur jaringan, administrasi server, keamanan siber, dan teknologi komunikasi data terkini.',
            'subjects' => ['Instalasi Fiber Optic & Wireless', 'Administrasi Server & Cloud', 'Network Security (Keamanan Jaringan)', 'Internet of Things (IoT)'],
            'career' => 'Network Engineer, IT Support, Cyber Security Analyst'
        ],
        [
            'name' => 'Teknik Kendaraan Ringan Otomotif',
            'code' => 'TKRO',
            'color' => 'red',
            'description' => 'Kompetensi keahlian yang berfokus pada perbaikan, perawatan, dan diagnosa kerusakan kendaraan ringan roda empat.',
            'subjects' => ['Pemeliharaan Mesin Kendaraan', 'Sistem Sasis & Pemindah Tenaga', 'Kelistrikan Otomotif & AC', 'Engine Management System (EFI)'],
            'career' => 'Mekanik Senior, Service Advisor, Wirausaha Bengkel'
        ],
        [
            'name' => 'Manajemen Perkantoran & Layanan Bisnis',
            'code' => 'MPLB',
            'color' => 'purple',
            'description' => 'Membekali siswa dengan kemampuan manajemen informasi, layanan pelanggan prima, dan pengelolaan administrasi berbasis digital.',
            'subjects' => ['Teknologi Perkantoran Digital', 'Layanan Pelanggan (Service Excellence)', 'Manajemen Kearsipan Elektronik', 'Public Relations & Komunikasi'],
            'career' => 'Sekretaris, Customer Service, Staff Administrasi'
        ],
    ];
    
    // Kesiswaan & Kegiatan (PKL)
    public $pkl_description = 'Program PKL selama 3 bulan di perusahaan mitra untuk memberikan pengalaman kerja nyata kepada siswa.';
    public $pkl_duration = '3 bulan';
    public $pkl_timing = 'Kelas XII';
    public $pkl_partners = '50+ Mitra';
    
    // Seragam section
    public $seragam = [
        ['title' => 'PDH Putih Abu', 'image' => null],
        ['title' => 'PDH Batik', 'image' => null],
        ['title' => 'Olahraga', 'image' => null],
        ['title' => 'Pramuka', 'image' => null],
    ];
    public $new_seragam_images = [];
    
    // CTA section
    public $cta_badge_text = 'Bergabunglah Bersama Kami';
    public $cta_title = '';
    public $cta_description = '';
    public $cta_primary_button_text = 'Daftar Sekarang';
    public $cta_primary_button_url = '/login';
    public $cta_secondary_button_text = 'Info Pendaftaran';
    public $cta_secondary_button_url = '/spmb';

    public function mount()
    {
        $this->loadProfile();
    }

    public function loadProfile()
    {
        $this->profile = ProfileSekolah::byType('smk')->first();
        
        if ($this->profile) {
            // Load hero data
            $heroData = $this->profile->hero_data ?? [];
            $this->hero_title_prefix = $heroData['title_prefix'] ?? 'SMK';
            $this->hero_title_main = $heroData['title_main'] ?? 'Taruna Nusantara Jaya';
            $this->hero_subtitle = $heroData['subtitle'] ?? '';
            $this->hero_badges = $heroData['badges'] ?? ['Akreditasi: A', 'NPSN: 87654321', 'Berdiri: 2012'];
            
            // Load identity data
            $identityData = $this->profile->identity_data ?? [];
            $this->school_name = $identityData['school_name'] ?? 'SMK Taruna Nusantara Jaya';
            $this->npsn = $identityData['npsn'] ?? '';
            $this->accreditation = $identityData['accreditation'] ?? 'A (Unggul)';
            $this->year_founded = $identityData['year_founded'] ?? '';
            $this->curriculum = $identityData['curriculum'] ?? 'Kurikulum Merdeka SMK';
            $this->students_teachers = $identityData['students_teachers'] ?? '';
            $this->description = $identityData['description'] ?? '';
            
            // Load competency data
            $competencyData = $this->profile->academic_data ?? [];
            if (!empty($competencyData['kompetensi'])) {
                $this->kompetensi = $competencyData['kompetensi'];
            }
            
            // Load activity data (PKL)
            $activityData = $this->profile->activity_data ?? [];
            $this->pkl_description = $activityData['pkl_description'] ?? $this->pkl_description;
            $this->pkl_duration = $activityData['pkl_duration'] ?? $this->pkl_duration;
            $this->pkl_timing = $activityData['pkl_timing'] ?? $this->pkl_timing;
            $this->pkl_partners = $activityData['pkl_partners'] ?? $this->pkl_partners;
            
            // Load uniform data
            $uniformData = $this->profile->uniform_data ?? [];
            if (!empty($uniformData['items'])) {
                $this->seragam = $uniformData['items'];
            }
            
            // Load CTA data
            $ctaData = $this->profile->cta_data ?? [];
            $this->cta_badge_text = $ctaData['badge_text'] ?? 'Bergabunglah Bersama Kami';
            $this->cta_title = $ctaData['title'] ?? '';
            $this->cta_description = $ctaData['description'] ?? '';
            $this->cta_primary_button_text = $ctaData['primary_button_text'] ?? 'Daftar Sekarang';
            $this->cta_primary_button_url = $ctaData['primary_button_url'] ?? '/login';
            $this->cta_secondary_button_text = $ctaData['secondary_button_text'] ?? 'Info Pendaftaran';
            $this->cta_secondary_button_url = $ctaData['secondary_button_url'] ?? '/spmb';
        }
    }

    public function addHeroBadge()
    {
        $this->hero_badges[] = '';
    }

    public function removeHeroBadge($index)
    {
        unset($this->hero_badges[$index]);
        $this->hero_badges = array_values($this->hero_badges);
    }

    public function addKompetensiSubject($kompIndex)
    {
        $this->kompetensi[$kompIndex]['subjects'][] = '';
    }

    public function removeKompetensiSubject($kompIndex, $subjectIndex)
    {
        unset($this->kompetensi[$kompIndex]['subjects'][$subjectIndex]);
        $this->kompetensi[$kompIndex]['subjects'] = array_values($this->kompetensi[$kompIndex]['subjects']);
    }

    // Kompetensi Keahlian dynamic methods
    public function addKompetensi()
    {
        $this->kompetensi[] = [
            'name' => '',
            'code' => '',
            'color' => 'blue',
            'description' => '',
            'subjects' => [''],
            'career' => ''
        ];
    }

    public function removeKompetensi($index)
    {
        unset($this->kompetensi[$index]);
        $this->kompetensi = array_values($this->kompetensi);
    }

    // Seragam dynamic methods
    public function addSeragam()
    {
        $this->seragam[] = ['title' => '', 'image' => null];
    }

    public function removeSeragam($index)
    {
        // Delete image if exists
        if (isset($this->seragam[$index]['image']) && $this->seragam[$index]['image']) {
            Storage::disk('public')->delete($this->seragam[$index]['image']);
        }
        unset($this->seragam[$index]);
        $this->seragam = array_values($this->seragam);
    }

    public function save()
    {
        // Handle seragam image uploads
        foreach ($this->new_seragam_images as $index => $image) {
            if ($image) {
                // Delete old image if exists
                if (isset($this->seragam[$index]['image']) && $this->seragam[$index]['image']) {
                    Storage::disk('public')->delete($this->seragam[$index]['image']);
                }
                // Store new image
                $path = $image->store('seragam-smk', 'public');
                $this->seragam[$index]['image'] = $path;
            }
        }
        $this->new_seragam_images = [];

        // Build hero data
        $heroData = [
            'title_prefix' => $this->hero_title_prefix,
            'title_main' => $this->hero_title_main,
            'subtitle' => $this->hero_subtitle,
            'badges' => array_filter($this->hero_badges),
        ];
        
        // Build identity data
        $identityData = [
            'school_name' => $this->school_name,
            'npsn' => $this->npsn,
            'accreditation' => $this->accreditation,
            'year_founded' => $this->year_founded,
            'curriculum' => $this->curriculum,
            'students_teachers' => $this->students_teachers,
            'description' => $this->description,
        ];
        
        // Build competency data (using academic_data column)
        $academicData = [
            'kompetensi' => $this->kompetensi,
        ];
        
        // Build activity data
        $activityData = [
            'pkl_description' => $this->pkl_description,
            'pkl_duration' => $this->pkl_duration,
            'pkl_timing' => $this->pkl_timing,
            'pkl_partners' => $this->pkl_partners,
        ];
        
        // Build uniform data
        $uniformData = [
            'items' => $this->seragam,
        ];
        
        // Build CTA data
        $ctaData = [
            'badge_text' => $this->cta_badge_text,
            'title' => $this->cta_title,
            'description' => $this->cta_description,
            'primary_button_text' => $this->cta_primary_button_text,
            'primary_button_url' => $this->cta_primary_button_url,
            'secondary_button_text' => $this->cta_secondary_button_text,
            'secondary_button_url' => $this->cta_secondary_button_url,
        ];
        
        // Save or create profile
        ProfileSekolah::updateOrCreate(
            ['school_type' => 'smk'],
            [
                'hero_data' => $heroData,
                'identity_data' => $identityData,
                'academic_data' => $academicData,
                'activity_data' => $activityData,
                'uniform_data' => $uniformData,
                'cta_data' => $ctaData,
            ]
        );
        
        session()->flash('message', 'Profile SMK berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.profile-sekolah.smk-page');
    }
}
