<?php

namespace App\Livewire\Admin\ProfileSekolah;

use App\Models\Landing\ProfileSekolah;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Profile SMA Taruna Nusantara")]
class SmaPage extends Component
{
    use WithFileUploads;

    public $profile;
    
    // Hero section
    public $hero_title_prefix = 'SMA';
    public $hero_title_main = 'Taruna Nusantara Indonesia';
    public $hero_subtitle = '';
    public $hero_badges = ['Akreditasi: A', 'NPSN: 12345678', 'Berdiri: 2010'];
    
    // Identity section
    public $school_name = 'SMA Taruna Nusantara Indonesia';
    public $npsn = '';
    public $accreditation = 'A (Unggul)';
    public $year_founded = '';
    public $curriculum = 'Kurikulum Merdeka';
    public $students_teachers = '';
    public $description = '';
    
    // Akademik section
    public $kurikulum_description = '';
    public $program_ipa = ['Matematika Lanjut', 'Fisika', 'Kimia', 'Biologi'];
    public $program_ips = ['Geografi', 'Sejarah', 'Ekonomi', 'Sosiologi'];
    
    // Additional Academic Programs (dynamic - admin can add new programs beyond IPA/IPS)
    public $academic_programs = [];
    
    // Program Unggulan section
    public $program_unggulan = [
        ['title' => 'Tahfidz Al-Quran', 'description' => 'Program menghafal Al-Quran dengan target minimal 5 juz selama 3 tahun.', 'icon' => 'book-open'],
        ['title' => 'Kepemimpinan', 'description' => 'Pembinaan karakter dan jiwa kepemimpinan melalui berbagai kegiatan.', 'icon' => 'user-group'],
        ['title' => 'Bahasa Asing', 'description' => 'Program intensif Bahasa Inggris dan Bahasa Arab untuk komunikasi global.', 'icon' => 'globe-alt'],
    ];
    
    // Seragam section (dynamic)
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
        $this->profile = ProfileSekolah::byType('sma')->first();
        
        if ($this->profile) {
            // Load hero data
            $heroData = $this->profile->hero_data ?? [];
            $this->hero_title_prefix = $heroData['title_prefix'] ?? 'SMA';
            $this->hero_title_main = $heroData['title_main'] ?? 'Taruna Nusantara Indonesia';
            $this->hero_subtitle = $heroData['subtitle'] ?? '';
            $this->hero_badges = $heroData['badges'] ?? ['Akreditasi: A', 'NPSN: 12345678', 'Berdiri: 2010'];
            
            // Load identity data
            $identityData = $this->profile->identity_data ?? [];
            $this->school_name = $identityData['school_name'] ?? 'SMA Taruna Nusantara Indonesia';
            $this->npsn = $identityData['npsn'] ?? '';
            $this->accreditation = $identityData['accreditation'] ?? 'A (Unggul)';
            $this->year_founded = $identityData['year_founded'] ?? '';
            $this->curriculum = $identityData['curriculum'] ?? 'Kurikulum Merdeka';
            $this->students_teachers = $identityData['students_teachers'] ?? '';
            $this->description = $identityData['description'] ?? '';
            
            // Load academic data
            $academicData = $this->profile->academic_data ?? [];
            $this->kurikulum_description = $academicData['kurikulum_description'] ?? '';
            $this->program_ipa = $academicData['program_ipa'] ?? ['Matematika Lanjut', 'Fisika', 'Kimia', 'Biologi'];
            $this->program_ips = $academicData['program_ips'] ?? ['Geografi', 'Sejarah', 'Ekonomi', 'Sosiologi'];
            $this->academic_programs = $academicData['academic_programs'] ?? [];
            $this->program_unggulan = $academicData['program_unggulan'] ?? $this->program_unggulan;
            
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

    public function addProgramIpa()
    {
        $this->program_ipa[] = '';
    }

    public function removeProgramIpa($index)
    {
        unset($this->program_ipa[$index]);
        $this->program_ipa = array_values($this->program_ipa);
    }

    public function clearProgramIpa()
    {
        $this->program_ipa = [];
    }

    public function addProgramIps()
    {
        $this->program_ips[] = '';
    }

    public function removeProgramIps($index)
    {
        unset($this->program_ips[$index]);
        $this->program_ips = array_values($this->program_ips);
    }

    public function clearProgramIps()
    {
        $this->program_ips = [];
    }

    public function addProgramUnggulan()
    {
        $this->program_unggulan[] = ['title' => '', 'description' => '', 'icon' => 'star'];
    }

    public function removeProgramUnggulan($index)
    {
        unset($this->program_unggulan[$index]);
        $this->program_unggulan = array_values($this->program_unggulan);
    }

    // Academic Programs (new programs beyond IPA/IPS)
    public function addAcademicProgram()
    {
        $this->academic_programs[] = ['title' => '', 'subjects' => ['']];
    }

    public function removeAcademicProgram($index)
    {
        unset($this->academic_programs[$index]);
        $this->academic_programs = array_values($this->academic_programs);
    }

    public function addAcademicProgramSubject($programIndex)
    {
        $this->academic_programs[$programIndex]['subjects'][] = '';
    }

    public function removeAcademicProgramSubject($programIndex, $subjectIndex)
    {
        unset($this->academic_programs[$programIndex]['subjects'][$subjectIndex]);
        $this->academic_programs[$programIndex]['subjects'] = array_values($this->academic_programs[$programIndex]['subjects']);
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
                $path = $image->store('seragam-sma', 'public');
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
        
        // Build academic data
        $academicData = [
            'kurikulum_description' => $this->kurikulum_description,
            'program_ipa' => array_filter($this->program_ipa),
            'program_ips' => array_filter($this->program_ips),
            'academic_programs' => $this->academic_programs,
            'program_unggulan' => $this->program_unggulan,
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
            ['school_type' => 'sma'],
            [
                'hero_data' => $heroData,
                'identity_data' => $identityData,
                'academic_data' => $academicData,
                'uniform_data' => $uniformData,
                'cta_data' => $ctaData,
            ]
        );
        
        session()->flash('message', 'Profile SMA berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.profile-sekolah.sma-page');
    }
}
