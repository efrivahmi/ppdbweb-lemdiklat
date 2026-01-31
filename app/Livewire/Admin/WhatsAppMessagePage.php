<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Services\WhatsAppService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("WhatsApp Message")]
class WhatsAppMessagePage extends Component
{
    use WithPagination;

    // Search & Filter
    public $search = '';
    public $perPage = 10;

    // Selected students
    public $selectedStudents = [];
    public $selectAll = false;

    // Message
    public $messageType = 'custom'; // 'custom' or 'template'
    public $selectedTemplate = '';
    public $customMessage = '';

    // Templates
    public $templates = [
        'welcome' => [
            'name' => 'Selamat Datang',
            'message' => "Halo {nama}! 👋\n\nSelamat datang di SPMB Lemdiklat Taruna Nusantara Indonesia.\n\nSilakan lengkapi data pendaftaran Anda melalui dashboard.\n\nTerima kasih 🙏"
        ],
        'payment_reminder' => [
            'name' => 'Reminder Pembayaran',
            'message' => "Halo {nama}! 📢\n\nKami ingatkan untuk segera melakukan pembayaran pendaftaran dan upload bukti transfer.\n\nJika sudah melakukan pembayaran, silakan upload bukti transfer melalui dashboard.\n\nTerima kasih 🙏"
        ],
        'data_reminder' => [
            'name' => 'Reminder Lengkapi Data',
            'message' => "Halo {nama}! 📋\n\nData pendaftaran Anda belum lengkap. Silakan lengkapi:\n- Data Siswa\n- Data Orang Tua\n- Berkas/Dokumen\n\nMelalui dashboard SPMB.\n\nTerima kasih 🙏"
        ],
        'test_reminder' => [
            'name' => 'Reminder Ujian',
            'message' => "Halo {nama}! 📝\n\nJangan lupa untuk mengerjakan ujian seleksi di dashboard SPMB.\n\nPastikan koneksi internet Anda stabil saat mengerjakan ujian.\n\nSemangat! 💪"
        ],
        'accepted' => [
            'name' => 'Penerimaan',
            'message' => "Halo {nama}! 🎉\n\nSELAMAT! Anda telah DITERIMA sebagai siswa baru di Lemdiklat Taruna Nusantara Indonesia.\n\nSilakan download Surat Penerimaan melalui dashboard.\n\nSampai bertemu di sekolah! 🎓"
        ],
        'rejected' => [
            'name' => 'Penolakan',
            'message' => "Halo {nama},\n\nMohon maaf, setelah melalui proses seleksi, Anda belum dapat diterima sebagai siswa baru pada periode ini.\n\nJangan menyerah! Tetap semangat untuk kesempatan lainnya.\n\nTerima kasih telah mendaftar 🙏"
        ],
    ];

    // Status
    public $sendingStatus = [];
    public $isSending = false;

    protected $queryString = ['search'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedStudents = $this->getStudentsQuery()->pluck('id')->toArray();
        } else {
            $this->selectedStudents = [];
        }
    }

    public function updatedSelectedStudents()
    {
        $totalStudents = $this->getStudentsQuery()->count();
        $this->selectAll = count($this->selectedStudents) === $totalStudents && $totalStudents > 0;
    }

    public function selectTemplate($key)
    {
        $this->selectedTemplate = $key;
        $this->messageType = 'template';
        if (isset($this->templates[$key])) {
            $this->customMessage = $this->templates[$key]['message'];
        }
    }

    public function clearSelection()
    {
        $this->selectedStudents = [];
        $this->selectAll = false;
    }

    public function sendMessages()
    {
        if (empty($this->selectedStudents)) {
            $this->dispatch('alert', message: 'Pilih siswa terlebih dahulu', type: 'warning');
            return;
        }

        if (empty($this->customMessage)) {
            $this->dispatch('alert', message: 'Pesan tidak boleh kosong', type: 'warning');
            return;
        }

        $this->isSending = true;
        $whatsApp = app(WhatsAppService::class);
        
        $successCount = 0;
        $failCount = 0;

        $students = User::whereIn('id', $this->selectedStudents)->get();

        foreach ($students as $student) {
            // Get phone number from dataMurid or user telp
            $phone = $student->dataMurid?->whatsapp ?? $student->telp;
            
            if (!$phone) {
                $this->sendingStatus[$student->id] = 'no_phone';
                $failCount++;
                continue;
            }

            // Replace placeholders
            $message = str_replace('{nama}', $student->name, $this->customMessage);
            
            try {
                $result = $whatsApp->send($phone, $message);
                
                if ($result) {
                    $this->sendingStatus[$student->id] = 'success';
                    $successCount++;
                } else {
                    $this->sendingStatus[$student->id] = 'failed';
                    $failCount++;
                }
            } catch (\Exception $e) {
                $this->sendingStatus[$student->id] = 'error';
                $failCount++;
            }
        }

        $this->isSending = false;

        if ($successCount > 0) {
            $this->dispatch('alert', 
                message: "Berhasil mengirim {$successCount} pesan" . ($failCount > 0 ? ", {$failCount} gagal" : ""), 
                type: $failCount > 0 ? 'warning' : 'success'
            );
        } else {
            $this->dispatch('alert', message: 'Gagal mengirim semua pesan', type: 'error');
        }

        // Clear selection after sending
        $this->clearSelection();
        $this->customMessage = '';
        $this->selectedTemplate = '';
        $this->sendingStatus = [];
    }

    private function getStudentsQuery()
    {
        return User::where('role', 'siswa')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('nisn', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $students = $this->getStudentsQuery()->paginate($this->perPage);

        return view('livewire.admin.whatsapp-message-page', [
            'students' => $students,
        ]);
    }
}
