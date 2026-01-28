<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Landing\SambutanKepalaLemdiklat;

class SambutanKepalaLemdiklatSection extends Component
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
                $greeting = SambutanKepalaLemdiklat::getActive();
                
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
            Log::error('Error loading lemdiklat greeting: ' . $e->getMessage());
            $this->errorMessage = 'Gagal memuat data sambutan kepala lemdiklat';
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
            $greeting = SambutanKepalaLemdiklat::getActive();
            
            if ($greeting) {
                $this->greetingData = $greeting->getFormattedData();
            } else {
                $this->greetingData = $this->getDefaultGreetingData();
            }
            
            $this->isLoading = false;
            
            // Emit event untuk memberitahu parent component
            $this->dispatch('greeting-data-refreshed');
        } catch (\Exception $e) {
            Log::error('Error refreshing lemdiklat greeting: ' . $e->getMessage());
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
                'text' => 'Sambutan Kepala Lemdiklat',
                'highlight' => 'Kepala Lemdiklat',
                'size' => '3xl',
                'className' => 'lg:text-5xl'
            ],
            'principal' => [
                'name' => 'Dr. Budi Hartono, S.Pd., M.M',
                'title' => 'Kepala Lemdiklat',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'signature' => null
            ],
            'greeting' => [
                'opening' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh,',
                'paragraphs' => [
                    'Puji syukur kehadirat Allah SWT atas segala rahmat dan karunia-Nya. Selamat datang di website resmi Lembaga Pendidikan dan Pelatihan (Lemdiklat) kami. Saya menyambut baik kehadiran Bapak/Ibu, para peserta pelatihan, dan seluruh pengunjung website ini.',
                    'Lemdiklat berkomitmen untuk menghadirkan program pelatihan dan pendidikan yang berkualitas, relevan dengan kebutuhan industri, dan mampu meningkatkan kompetensi sumber daya manusia. Kami menyediakan berbagai program pelatihan yang dirancang untuk mengembangkan keterampilan teknis maupun soft skills yang dibutuhkan di dunia kerja.',
                    'Dengan tenaga pengajar yang berpengalaman, fasilitas yang memadai, dan metode pembelajaran yang inovatif, kami siap mendampingi perjalanan pengembangan kompetensi Anda. Mari bersama-sama kita tingkatkan kualitas SDM Indonesia melalui pendidikan dan pelatihan yang profesional.',
                ],
                'closing' => 'Mari bergabung bersama kami dalam mencetak SDM yang kompeten dan profesional!'
            ],
            'quote' => [
                'text' => 'Investasi terbaik adalah investasi pada diri sendiri melalui pendidikan dan pelatihan.',
                'author' => 'Benjamin Franklin'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.components.landing.sambutan-kepala-lemdiklat-section');
    }
}