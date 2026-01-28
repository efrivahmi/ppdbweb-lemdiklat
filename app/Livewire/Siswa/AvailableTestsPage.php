<?php

namespace App\Livewire\Siswa;

use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Pendaftaran\TesJalur;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Siswa\BuktiTransfer;
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

    public function mount()
    {
        $this->userRegistration = PendaftaranMurid::with('jalurPendaftaran')
            ->where('user_id', Auth::id())
            ->first();

        if ($this->userRegistration) {
            // Ambil status transfer
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
             * 🔹 2. Ambil semua kuesioner ortu (category = kuesioner_ortu)
             *     - tidak dibatasi jalur
             *     - tidak perlu relasi TesJalur
             */
            $kuesioners = CustomTest::with('questions')
                ->where('category', 'kuesioner_ortu')
                ->where('is_active', true)
                ->get();

            foreach ($kuesioners as $customTest) {
                $this->availableTests[] = $this->formatTestData($customTest, null);
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
