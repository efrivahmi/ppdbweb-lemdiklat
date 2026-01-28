<?php

namespace App\Livewire\Siswa;

use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.siswa")]
#[Title("Test")]
class TestTakingPage extends Component
{
    public $customTest;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public array $answers = [];
    public $isCompleted = false;
    public $showResult = false;
    public $scoreData = [];
    public $startTime;
    
    public function mount($testId)
    {
        $this->customTest = CustomTest::with(['questions' => fn($q) => $q->orderBy('urutan')])
            ->findOrFail($testId);
        
        $this->questions = $this->customTest->questions->toArray();
        $this->startTime = now();
        
        // Initialize answers dengan question ID sebagai key
        $this->initializeAnswers();
        
        // Cek existing answers - jika sudah ada, langsung tampilkan hasil
        if ($this->checkExistingAnswers()) {
            $this->loadCompletedTest();
        }
    }
    
    private function initializeAnswers(): void
    {
        $this->answers = [];
        foreach ($this->questions as $question) {
            // Untuk checkbox, initialize sebagai array kosong
            if ($question['tipe_soal'] === 'checkbox') {
                $this->answers[$question['id']] = [];
            } else {
                $this->answers[$question['id']] = '';
            }
        }
    }
    
    private function checkExistingAnswers(): bool
    {
        return CustomTestAnswer::where('user_id', Auth::id())
            ->where('custom_test_id', $this->customTest->id)
            ->exists();
    }
    
    private function loadCompletedTest(): void
    {
        $existingAnswers = CustomTestAnswer::where('user_id', Auth::id())
            ->where('custom_test_id', $this->customTest->id)
            ->with('customTestQuestion')
            ->get()
            ->keyBy('custom_test_question_id');
            
        foreach ($this->questions as $question) {
            if ($answer = $existingAnswers->get($question['id'])) {
                // Untuk checkbox, parse JSON menjadi array
                if ($question['tipe_soal'] === 'checkbox') {
                    $this->answers[$question['id']] = json_decode($answer->jawaban, true) ?? [];
                } else {
                    $this->answers[$question['id']] = $answer->jawaban;
                }
            }
        }
        
        $this->scoreData = $this->calculateScoreData($existingAnswers->values());
        $this->isCompleted = true;
        $this->showResult = true;
    }
    
    // Method untuk handle perubahan jawaban radio
    public function selectAnswer($questionId, $answer)
    {
        // Cegah perubahan jika test sudah selesai
        if ($this->isCompleted) {
            return;
        }
        
        $this->answers[$questionId] = $answer;
    }
    
    // Method untuk handle checkbox toggle
    public function toggleCheckbox($questionId, $optionValue)
    {
        // Cegah perubahan jika test sudah selesai
        if ($this->isCompleted) {
            return;
        }
        
        if (!isset($this->answers[$questionId])) {
            $this->answers[$questionId] = [];
        }
        
        // Toggle checkbox value
        $currentAnswers = $this->answers[$questionId];
        
        if (in_array($optionValue, $currentAnswers)) {
            // Remove if already selected
            $this->answers[$questionId] = array_values(
                array_filter($currentAnswers, fn($v) => $v !== $optionValue)
            );
        } else {
            // Add if not selected
            $this->answers[$questionId][] = $optionValue;
        }
    }
    
    public function nextQuestion(): void
    {
        if ($this->isCompleted) return;
        
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }
    
    public function previousQuestion(): void
    {
        if ($this->isCompleted) return;
        
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }
    
    public function goToQuestion($index): void
    {
        if ($this->isCompleted) return;
        
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentQuestionIndex = $index;
        }
    }
    
    public function submitTest(): void
    {
        // Cegah submit jika sudah completed
        if ($this->isCompleted) {
            $this->dispatch("alert", message: "Test sudah dikerjakan", type: "info");
            return;
        }
        
        // Validate semua pertanyaan dijawab
        $unanswered = [];
        foreach ($this->questions as $index => $question) {
            $answer = $this->answers[$question['id']] ?? '';
            
            // Check untuk checkbox (array) dan text/radio (string)
            if (is_array($answer)) {
                if (empty($answer)) {
                    $unanswered[] = $index + 1;
                }
            } else {
                if (empty(trim($answer))) {
                    $unanswered[] = $index + 1;
                }
            }
        }
        
        if (!empty($unanswered)) {
            $this->dispatch("alert", message: 'Soal nomor ' . implode(', ', $unanswered) . ' belum dijawab', type: "warning");
            return;
        }
        
        try {
            DB::transaction(function() {
                // Cek ulang apakah user sudah pernah submit (race condition prevention)
                $existingCount = CustomTestAnswer::where('user_id', Auth::id())
                    ->where('custom_test_id', $this->customTest->id)
                    ->count();
                
                if ($existingCount > 0) {
                    throw new \Exception('Test sudah pernah dikerjakan sebelumnya');
                }
                
                // Insert new answers
                foreach ($this->questions as $question) {
                    $answer = $this->answers[$question['id']];
                    $isCorrect = null;
                    
                    // Format answer untuk checkbox (simpan sebagai JSON)
                    if ($question['tipe_soal'] === 'checkbox') {
                        $answer = json_encode($answer);
                    }
                    
                    // Auto-score radio questions
                    if ($question['tipe_soal'] === 'radio') {
                        $isCorrect = $this->answers[$question['id']] === $question['jawaban_benar'];
                    }
                    
                    CustomTestAnswer::create([
                        'user_id' => Auth::id(),
                        'custom_test_id' => $this->customTest->id,
                        'custom_test_question_id' => $question['id'],
                        'jawaban' => $answer,
                        'is_correct' => $isCorrect,
                        'completed_at' => now()
                    ]);
                }
                
                // Calculate score
                $savedAnswers = CustomTestAnswer::where('user_id', Auth::id())
                    ->where('custom_test_id', $this->customTest->id)
                    ->with('customTestQuestion')
                    ->get();
                
                $this->scoreData = $this->calculateScoreData($savedAnswers);
            });
            
            $this->isCompleted = true;
            $this->showResult = true;
            
            $this->dispatch("alert", message: "Soal sudah dikirim", type: "success");
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }
    
    private function calculateScoreData($answers): array
    {
        $grouped = $answers->groupBy('customTestQuestion.tipe_soal');
        $radio = $grouped->get('radio', collect());
        $essay = $grouped->get('text', collect());
        $checkbox = $grouped->get('checkbox', collect());
        
        $radioCorrect = $radio->where('is_correct', true)->count();
        $essayCorrect = $essay->where('is_correct', true)->count();
        $checkboxCorrect = $checkbox->where('is_correct', true)->count();
        
        $essayReviewed = $essay->whereNotNull('is_correct')->count();
        $checkboxReviewed = $checkbox->whereNotNull('is_correct')->count();
        
        $totalCorrect = $radioCorrect + $essayCorrect + $checkboxCorrect;
        $totalReviewed = $radio->count() + $essayReviewed + $checkboxReviewed;
        
        return [
            'total_correct' => $totalCorrect,
            'total_reviewed' => $totalReviewed,
            'radio_correct' => $radioCorrect,
            'radio_total' => $radio->count(),
            'essay_correct' => $essayCorrect,
            'essay_reviewed' => $essayReviewed,
            'essay_pending' => $essay->whereNull('is_correct')->count(),
            'checkbox_correct' => $checkboxCorrect,
            'checkbox_reviewed' => $checkboxReviewed,
            'checkbox_pending' => $checkbox->whereNull('is_correct')->count(),
            'percentage' => $totalReviewed > 0 ? ($totalCorrect / $totalReviewed) * 100 : 0
        ];
    }
    
    // Computed properties
    public function getCurrentQuestion(): ?array
    {
        return $this->questions[$this->currentQuestionIndex] ?? null;
    }
    
    public function getCurrentQuestionId(): ?int
    {
        $question = $this->getCurrentQuestion();
        return $question['id'] ?? null;
    }
    
    public function getAnsweredCount(): int
    {
        $count = 0;
        foreach ($this->answers as $answer) {
            if (is_array($answer)) {
                if (!empty($answer)) $count++;
            } else {
                if (!empty(trim($answer))) $count++;
            }
        }
        return $count;
    }
    
    public function getProgress(): float
    {
        $total = count($this->questions);
        return $total > 0 ? (($this->currentQuestionIndex + 1) / $total) * 100 : 0;
    }
    
    public function getQuestionStatus($index): string
    {
        $question = $this->questions[$index] ?? null;
        if (!$question) return 'unanswered';
        
        if ($this->currentQuestionIndex === $index) return 'current';
        
        $answer = $this->answers[$question['id']] ?? '';
        $isAnswered = is_array($answer) ? !empty($answer) : !empty(trim($answer));
        
        return $isAnswered ? 'answered' : 'unanswered';
    }
    
    public function getTimeElapsed(): int
    {
        return $this->startTime ? now()->diffInMinutes($this->startTime) : 0;
    }
    
    public function render()
    {
        return view('livewire.siswa.test-taking-page', [
            'currentQuestion' => $this->getCurrentQuestion(),
            'currentQuestionId' => (int) $this->getCurrentQuestionId(),
            'answeredCount' => $this->getAnsweredCount(),
            'totalQuestions' => count($this->questions),
            'progress' => $this->getProgress(),
            'timeElapsed' => $this->getTimeElapsed()
        ]);
    }
}