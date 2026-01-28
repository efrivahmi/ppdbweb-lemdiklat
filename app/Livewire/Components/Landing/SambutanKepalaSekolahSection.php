<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Landing\SambutanKepalaSekolah;

class SambutanKepalaSekolahSection extends Component
{
    public $greetingData = [];
    public $isLoading = true;
    public $errorMessage = null;

    public function mount($greetingData = [])
    {
        try {
            // Jika data diteruskan dari parent component, gunakan itu
            if (!empty($greetingData)) {
                $this->greetingData = $greetingData;
            } else {
                // Ambil data dari database
                $greeting = SambutanKepalaSekolah::getActive();
                
                if ($greeting) {
                    $this->greetingData = $greeting->getFormattedData();
                } else {
                    // Gunakan data default jika tidak ada data di database
                    $this->greetingData = $this->getDefaultGreetingData();
                }
            }
            
            $this->isLoading = false;
        } catch (\Exception $e) {
            // Log error dan gunakan data default
            Log::error('Error loading principal greeting: ' . $e->getMessage());
            $this->errorMessage = 'Gagal memuat data sambutan kepala sekolah';
            $this->greetingData = $this->getDefaultGreetingData();
            $this->isLoading = false;
        }
    }

    /**
     * Refresh data
     */
    public function refreshData()
    {
        try {
            $this->isLoading = true;
            $this->errorMessage = null;
            
            // Ambil data dari database
            $greeting = SambutanKepalaSekolah::getActive();
            
            if ($greeting) {
                $this->greetingData = $greeting->getFormattedData();
            } else {
                $this->greetingData = $this->getDefaultGreetingData();
            }
            
            $this->isLoading = false;
            
            // Emit event untuk memberitahu parent component
            $this->dispatch('greeting-data-refreshed');
        } catch (\Exception $e) {
            Log::error('Error refreshing principal greeting: ' . $e->getMessage());
            $this->errorMessage = 'Gagal memuat ulang data sambutan';
            $this->isLoading = false;
        }
    }

    /**
     * Fallback data (data statis)
     */
    private function getDefaultGreetingData()
    {
        return [
            'badge' => [
                'text' => 'Sambutan',
                'variant' => 'indigo',
                'size' => 'md'
            ],
            'title' => [
                'text' => 'Sambutan Kepala Sekolah',
                'highlight' => 'Kepala Sekolah',
                'size' => '3xl',
                'className' => 'lg:text-5xl'
            ],
            'principal' => [
                'name' => 'Dr. Ahmad Suryanto, S.Pd., M.Pd',
                'title' => 'Kepala Sekolah',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'signature' => null
            ],
            'greeting' => [
                'opening' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh,',
                'paragraphs' => [
                    'Puji syukur kehadirat Allah SWT atas segala rahmat dan karunia-Nya. Selamat datang di website resmi sekolah kami. Saya menyambut baik kehadiran Bapak/Ibu orang tua, calon peserta didik, dan seluruh pengunjung website ini.',
                    'Pendidikan adalah fondasi penting dalam membangun karakter dan masa depan generasi muda. Di sekolah kami, kami berkomitmen untuk memberikan pendidikan berkualitas yang tidak hanya fokus pada akademik, tetapi juga pengembangan karakter, kreativitas, dan keterampilan yang dibutuhkan di era modern.',
                    'Kami menyediakan lingkungan belajar yang kondusif, didukung oleh tenaga pendidik yang profesional dan berpengalaman, serta fasilitas yang memadai. Mari bersama-sama kita ciptakan generasi yang cerdas, berkarakter, dan siap menghadapi tantangan masa depan.',
                ],
                'closing' => 'Mari bergabung bersama kami dalam mencetak generasi emas Indonesia!'
            ],
            'quote' => [
                'text' => 'Pendidikan adalah kunci membuka pintu emas kebebasan.',
                'author' => 'George Washington Carver'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.components.landing.sambutan-kepala-sekolah-section');
    }
}