<?php

namespace App\Livewire\Siswa;

use App\Models\GelombangPendaftaran;
use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Pendaftaran\TesJalur;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Siswa\BuktiTransfer;
use App\Models\Siswa\DataMurid;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.siswa")]
#[Title("Test")]
class AvailableTestsPage extends Component
{
    public $availableTests = [];
    public $userRegistration = null;
    public $statusTransfer = "pending";

    // Payment and schedule access properties
    public $paymentApproved = false;
    public $hasUrgentSchedule = false;
    public $canAccessTest = false;
    public $activeUrgentSchedules = [];
    public $gelombangActive = null;
    public $regularScheduleActive = false;
    
    // Test completion tracking
    public $allTestsCompleted = false;

    public function mount()
    {
        $user = Auth::user();

        // Get active gelombang once
        $this->gelombangActive = GelombangPendaftaran::aktif()->first();
        $this->regularScheduleActive = $this->gelombangActive?->isUjianAktif() ?? false;

        // Check payment status
        $payment = BuktiTransfer::where('user_id', $user->id)
            ->where('status', 'success')
            ->exists();
        $this->paymentApproved = $payment;

        // Check urgent schedule access
        $this->hasUrgentSchedule = $user->hasActiveUrgentSchedule();
        $this->activeUrgentSchedules = $user->getActiveUrgentSchedules();

        // Can access test if: payment approved AND (regular schedule active OR has urgent schedule)
        $this->canAccessTest = $this->paymentApproved && ($this->regularScheduleActive || $this->hasUrgentSchedule);

        $this->userRegistration = PendaftaranMurid::with('jalurPendaftaran')
            ->where('user_id', $user->id)
            ->first();

        if ($this->userRegistration) {
            // Ambil status transfer (for display purposes)
            $getStatusPembayaran = BuktiTransfer::where("user_id", $this->userRegistration->user_id)
                ->latest()
                ->first();
            $this->statusTransfer = $getStatusPembayaran?->status ?? "pending";

            /**
             * 🔹 1. Ambil semua tes khusus jalur (category = custom_test)
             */
            $tesJalurs = TesJalur::with(['customTests.questions'])
                ->where('jalur_pendaftaran_id', $this->userRegistration->jalur_pendaftaran_id)
                ->get();

            foreach ($tesJalurs as $tesJalur) {
                foreach ($tesJalur->customTests as $customTest) {
                    if ($customTest->is_active && $customTest->category === 'custom_test') {
                        $this->availableTests[] = $this->formatTestData($customTest, $tesJalur);
                    }
                }
            }

            /**
             * 🔹 2. Ambil kuesioner ortu (category = kuesioner_ortu)
             *     - Filter berdasarkan agama siswa
             *     - Islam -> Kuesioner Muslim
             *     - Lainnya (Kristen, dll) -> Kuesioner Non Muslim
             */
            $dataMurid = DataMurid::where('user_id', $user->id)->first();
            $studentReligion = strtolower($dataMurid->agama ?? '');
            
            // Determine which kuesioner type to show based on religion
            $isMuslim = str_contains($studentReligion, 'islam');
            
            $kuesioners = CustomTest::with('questions')
                ->where('category', 'kuesioner_ortu')
                ->where('is_active', true)
                ->get()
                ->filter(function ($kuesioner) use ($isMuslim) {
                    $namaLower = strtolower($kuesioner->nama_test);
                    
                    // Check if kuesioner name contains "non muslim" or "muslim"
                    $isNonMuslimKuesioner = str_contains($namaLower, 'non muslim') || str_contains($namaLower, 'non-muslim');
                    $isMuslimKuesioner = !$isNonMuslimKuesioner && str_contains($namaLower, 'muslim');
                    
                    // If it's a religion-specific kuesioner, filter accordingly
                    if ($isNonMuslimKuesioner) {
                        return !$isMuslim; // Show to non-Muslim students
                    } elseif ($isMuslimKuesioner) {
                        return $isMuslim; // Show to Muslim students
                    }
                    
                    // If not religion-specific, show to everyone
                    return true;
                });

            foreach ($kuesioners as $customTest) {
                $this->availableTests[] = $this->formatTestData($customTest, null);
            }
            
            // Check if all jalur tests are completed
            $jalurTests = collect($this->availableTests)->where('test.category', 'custom_test');
            if ($jalurTests->count() > 0) {
                $this->allTestsCompleted = $jalurTests->every(fn($test) => $test['has_completed']);
            }
        }
    }

    /**
     * Format data test agar rapi dan reusable
     */
    private function formatTestData($customTest, $tesJalur = null)
    {
        $userId = Auth::id();

        // Apakah user sudah mengerjakan?
        $hasCompleted = CustomTestAnswer::where('user_id', $userId)
            ->where('custom_test_id', $customTest->id)
            ->exists();

        $score = null;

        if ($hasCompleted) {
            $allAnswers = CustomTestAnswer::where('user_id', $userId)
                ->where('custom_test_id', $customTest->id)
                ->with('customTestQuestion')
                ->get();

            $radioCorrect = $allAnswers->where('is_correct', true)
                ->filter(fn($a) => $a->customTestQuestion->tipe_soal === 'radio')
                ->count();

            $essayCorrect = $allAnswers->where('is_correct', true)
                ->filter(fn($a) => $a->customTestQuestion->tipe_soal === 'text')
                ->count();

            $totalCorrect = $radioCorrect + $essayCorrect;
            $reviewedCount = $allAnswers->whereIn('is_correct', [true, false])->count();

            $radioQuestions = $customTest->questions()->where('tipe_soal', 'radio')->count();
            $essayQuestions = $customTest->questions()->where('tipe_soal', 'text')->count();

            $essayReviewed = $allAnswers
                ->filter(fn($a) => $a->customTestQuestion->tipe_soal === 'text' && $a->is_correct !== null)
                ->count();

            $essayPending = $essayQuestions - $essayReviewed;

            $score = [
                'total_correct' => $totalCorrect,
                'total_reviewed' => $reviewedCount,
                'radio_correct' => $radioCorrect,
                'radio_total' => $radioQuestions,
                'essay_correct' => $essayCorrect,
                'essay_reviewed' => $essayReviewed,
                'essay_pending' => $essayPending,
                'total_questions' => $customTest->questions->count()
            ];
        }

        $radioCount = $customTest->questions()->where('tipe_soal', 'radio')->count();
        $essayCount = $customTest->questions()->where('tipe_soal', 'text')->count();

        return [
            'test' => $customTest,
            'tes_jalur' => $tesJalur,
            'has_completed' => $hasCompleted,
            'score' => $score,
            'question_count' => $customTest->questions->count(),
            'radio_count' => $radioCount,
            'essay_count' => $essayCount,
        ];
    }

    public function render()
    {
        return view('livewire.siswa.available-tests-page');
    }
}

