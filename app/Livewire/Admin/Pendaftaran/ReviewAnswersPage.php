<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Review Jawaban")]
class ReviewAnswersPage extends Component
{
    use WithPagination;
    
    public $currentView = 'tests';
    public $selectedTestId = null;
    public $selectedUserId = null;
    public $selectedTest = null;
    public $selectedUser = null;
    public $searchUser = '';
    
    public function mount()
    {
        $this->currentView = 'tests';
    }
    
    // Navigation Methods
    public function viewTest($testId)
    {
        $this->selectedTestId = $testId;
        $this->selectedTest = CustomTest::findOrFail($testId);
        $this->currentView = 'users';
        $this->resetPage();
    }
    
    public function viewUserAnswers($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedUser = User::findOrFail($userId);
        $this->currentView = 'answers';
        $this->resetPage();
    }
    
    public function backToTests()
    {
        $this->currentView = 'tests';
        $this->selectedTestId = null;
        $this->selectedTest = null;
        $this->selectedUserId = null;
        $this->selectedUser = null;
        $this->searchUser = '';
        $this->resetPage();
    }
    
    public function backToUsers()
    {
        $this->currentView = 'users';
        $this->selectedUserId = null;
        $this->selectedUser = null;
        $this->resetPage();
    }
    
    // Search
    public function updatingSearchUser()
    {
        $this->resetPage();
    }
    
    // Review Actions
    public function approveAnswer($answerId)
    {
        try {
            $answer = CustomTestAnswer::findOrFail($answerId);
            $answer->update(['is_correct' => true]);
            $this->dispatch("alert", message: "Jawaban disetujui", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Error saat menyetujui jawaban.", type: "error");
        }
    }
    
    public function rejectAnswer($answerId)
    {
        try {
            $answer = CustomTestAnswer::findOrFail($answerId);
            $answer->update(['is_correct' => false]);
            $this->dispatch("alert", message: "Jawaban ditolak", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Error saat menolak jawaban", type: "error");
        }
    }
    
    public function approveAllEssayForUser()
    {
        try {
            $updated = CustomTestAnswer::where('user_id', $this->selectedUserId)
                ->where('custom_test_id', $this->selectedTestId)
                ->whereHas('customTestQuestion', function($query) {
                    $query->whereIn('tipe_soal', ['text', 'checkbox']);
                })
                ->where('is_correct', null)
                ->update(['is_correct' => true]);
                
            if ($updated > 0) {
                $this->dispatch("alert", message: "Semua jawaban disetujui", type: "success");
            } else {
                $this->dispatch("alert", message: "Tidak ada jawaban yang dapat disetujui", type: "info");
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat menyetujui jawaban", type: "error");
        }
    }
    
    public function rejectAllEssayForUser()
    {
        try {
            $updated = CustomTestAnswer::where('user_id', $this->selectedUserId)
                ->where('custom_test_id', $this->selectedTestId)
                ->whereHas('customTestQuestion', function($query) {
                    $query->whereIn('tipe_soal', ['text', 'checkbox']);
                })
                ->where('is_correct', null)
                ->update(['is_correct' => false]);
                
            if ($updated > 0) {
                $this->dispatch("alert", message: "Semua jawaban ditolak", type: "success");
            } else {
                $this->dispatch("alert", message: "Tidak ada jawaban yang dapat ditolak", type: "info");
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat menolak jawaban", type: "error");
        }
    }
    
    public function resetTestForUser()
    {
        try {
            $deleted = CustomTestAnswer::where('user_id', $this->selectedUserId)
                ->where('custom_test_id', $this->selectedTestId)
                ->delete();
                
            if ($deleted > 0) {
                $this->dispatch("alert", message: "Test berhasil direset", type: "success");
                
                $this->currentView = 'users';
                $this->selectedUserId = null;
                $this->selectedUser = null;
            } else {
                $this->dispatch("alert", message: "Tidak ada test yang dapat direset", type: "info");
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi error saat mereset test", type: "error");
        }
    }
    
    public function resetTestForUserFromList($userId)
    {
        try {
            $user = User::findOrFail($userId);
            
            $deleted = CustomTestAnswer::where('user_id', $userId)
                ->where('custom_test_id', $this->selectedTestId)
                ->delete();
                
            if ($deleted > 0) {
                $this->dispatch("alert", message: "Test berhasil direset", type: "success");
            } else {
                $this->dispatch("alert", message: "Tidak ada test yang dapat direset", type: "info");
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat mereset test", type: "error");
        }
    }
    
    // Helper method untuk decode checkbox answers
    private function decodeCheckboxAnswer($answer)
    {
        if (is_string($answer)) {
            $decoded = json_decode($answer, true);
            return is_array($decoded) ? $decoded : [$answer];
        }
        return is_array($answer) ? $answer : [$answer];
    }
    
    // Data Methods
    private function getTestsWithStats()
    {
        return CustomTest::with('mapel')
            ->withCount([
                'answers as total_participants' => function($query) {
                    $query->selectRaw('COUNT(DISTINCT user_id)');
                },
                'answers as essay_pending' => function($query) {
                    $query->whereHas('customTestQuestion', function($q) {
                        $q->whereIn('tipe_soal', ['text', 'checkbox']);
                    })->whereNull('is_correct');
                },
                'answers as essay_reviewed' => function($query) {
                    $query->whereHas('customTestQuestion', function($q) {
                        $q->whereIn('tipe_soal', ['text', 'checkbox']);
                    })->whereNotNull('is_correct');
                }
            ])
            ->where('is_active', true)
            ->latest()
            ->paginate(10);
    }
    
    private function getUsersForTest()
    {
        $query = User::whereHas('customTestAnswers', function($query) {
            $query->where('custom_test_id', $this->selectedTestId);
        })
        ->withCount([
            'customTestAnswers as total_answers' => function($query) {
                $query->where('custom_test_id', $this->selectedTestId);
            },
            'customTestAnswers as essay_pending' => function($query) {
                $query->where('custom_test_id', $this->selectedTestId)
                      ->whereHas('customTestQuestion', function($q) {
                          $q->whereIn('tipe_soal', ['text', 'checkbox']);
                      })
                      ->whereNull('is_correct');
            },
            'customTestAnswers as essay_reviewed' => function($query) {
                $query->where('custom_test_id', $this->selectedTestId)
                      ->whereHas('customTestQuestion', function($q) {
                          $q->whereIn('tipe_soal', ['text', 'checkbox']);
                      })
                      ->whereNotNull('is_correct');
            },
            'customTestAnswers as essay_approved' => function($query) {
                $query->where('custom_test_id', $this->selectedTestId)
                      ->whereHas('customTestQuestion', function($q) {
                          $q->whereIn('tipe_soal', ['text', 'checkbox']);
                      })
                      ->where('is_correct', true);
            }
        ]);
        
        if ($this->searchUser) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchUser . '%')
                  ->orWhere('email', 'like', '%' . $this->searchUser . '%')
                  ->orWhere('nisn', 'like', '%' . $this->searchUser . '%');
            });
        }
        
        return $query->latest()->paginate(15);
    }
    
    private function getUserAnswers()
    {
        return CustomTestAnswer::where('user_id', $this->selectedUserId)
            ->where('custom_test_id', $this->selectedTestId)
            ->with(['customTestQuestion'])
            ->orderBy('id')
            ->get()
            ->groupBy('customTestQuestion.tipe_soal');
    }
    
    private function getUserStats()
    {
        $answers = CustomTestAnswer::where('user_id', $this->selectedUserId)
            ->where('custom_test_id', $this->selectedTestId)
            ->with('customTestQuestion')
            ->get();
        
        $radioAnswers = $answers->where('customTestQuestion.tipe_soal', 'radio');
        $essayAnswers = $answers->where('customTestQuestion.tipe_soal', 'text');
        $checkboxAnswers = $answers->where('customTestQuestion.tipe_soal', 'checkbox');
        
        return [
            'radio_total' => $radioAnswers->count(),
            'radio_correct' => $radioAnswers->where('is_correct', true)->count(),
            'essay_total' => $essayAnswers->count(),
            'essay_pending' => $essayAnswers->whereNull('is_correct')->count(),
            'essay_approved' => $essayAnswers->where('is_correct', true)->count(),
            'essay_rejected' => $essayAnswers->where('is_correct', false)->count(),
            'checkbox_total' => $checkboxAnswers->count(),
            'checkbox_pending' => $checkboxAnswers->whereNull('is_correct')->count(),
            'checkbox_approved' => $checkboxAnswers->where('is_correct', true)->count(),
            'checkbox_rejected' => $checkboxAnswers->where('is_correct', false)->count(),
            'total_score' => $answers->where('is_correct', true)->count(),
            'total_reviewed' => $answers->whereNotNull('is_correct')->count(),
        ];
    }
    
    public function render()
    {
        try {
            $data = [];
            
            switch ($this->currentView) {
                case 'tests':
                    $data['tests'] = $this->getTestsWithStats();
                    break;
                    
                case 'users':
                    $data['users'] = $this->getUsersForTest();
                    break;
                    
                case 'answers':
                    $data['userAnswers'] = $this->getUserAnswers();
                    $data['userStats'] = $this->getUserStats();
                    break;
            }
            
            return view('livewire.admin.pendaftaran.review-answers-page', $data);
                
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
            
            return view('livewire.admin.pendaftaran.review-answers-page', [
                'tests' => collect(),
                'users' => collect(),
                'userAnswers' => collect(),
                'userStats' => []
            ]);
        }
    }
}