<?php

namespace App\Livewire\Guru\Pendaftaran;

use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.guru")]
#[Title("Review Jawaban")]
class ReviewAnswersPage extends Component
{
    use WithPagination;
    
    public $currentView = 'tests'; // 'tests', 'users', 'answers'
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
        $test = CustomTest::findOrFail($testId);

        // Check if guru can manage this test
        if (!auth()->user()->canManageCustomTest($test)) {
            $this->dispatch("alert", message: "Anda tidak memiliki akses untuk melihat jawaban test ini", type: "error");
            return;
        }

        $this->selectedTestId = $testId;
        $this->selectedTest = $test;
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
            $answer = CustomTestAnswer::with('customTest')->findOrFail($answerId);

            // Check if guru can manage this test
            if (!auth()->user()->canManageCustomTest($answer->customTest)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mengoreksi jawaban ini", type: "error");
                return;
            }

            $answer->update(['is_correct' => true]);
            $this->dispatch("alert", message: "Jawaban di setujui", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }
    
    public function rejectAnswer($answerId)
    {
        try {
            $answer = CustomTestAnswer::with('customTest')->findOrFail($answerId);

            // Check if guru can manage this test
            if (!auth()->user()->canManageCustomTest($answer->customTest)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mengoreksi jawaban ini", type: "error");
                return;
            }

            $answer->update(['is_correct' => false]);
            $this->dispatch("alert", message: "Jawaban ditolak", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }
    
    public function approveAllEssayForUser()
    {
        try {
            // Check if guru can manage this test
            $test = CustomTest::findOrFail($this->selectedTestId);
            if (!auth()->user()->canManageCustomTest($test)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mengoreksi jawaban test ini", type: "error");
                return;
            }

            $updated = CustomTestAnswer::where('user_id', $this->selectedUserId)
                ->where('custom_test_id', $this->selectedTestId)
                ->whereHas('customTestQuestion', function($query) {
                    $query->where('tipe_soal', 'text');
                })
                ->where('is_correct', null)
                ->update(['is_correct' => true]);
                
            if ($updated > 0) {
                $this->dispatch("alert", message: "Semua jawaban essay disetujui", type: "success");
            } else {
                $this->dispatch('info', message: 'Tidak ada jawaban essay yang perlu disetujui');
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }
    
    public function rejectAllEssayForUser()
    {
        try {
            // Check if guru can manage this test
            $test = CustomTest::findOrFail($this->selectedTestId);
            if (!auth()->user()->canManageCustomTest($test)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mengoreksi jawaban test ini", type: "error");
                return;
            }

            $updated = CustomTestAnswer::where('user_id', $this->selectedUserId)
                ->where('custom_test_id', $this->selectedTestId)
                ->whereHas('customTestQuestion', function($query) {
                    $query->where('tipe_soal', 'text');
                })
                ->where('is_correct', null)
                ->update(['is_correct' => false]);
                
            if ($updated > 0) {
                $this->dispatch("alert", message: "Semua jawaban essay ditolak", type: "success");
            } else {
                $this->dispatch('info', message: 'Tidak ada jawaban essay yang perlu ditolak');
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }
    
    // Reset Test for User - FITUR BARU
    public function resetTestForUser()
    {
        try {
            // Check if guru can manage this test
            $test = CustomTest::findOrFail($this->selectedTestId);
            if (!auth()->user()->canManageCustomTest($test)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mereset test ini", type: "error");
                return;
            }

            $deleted = CustomTestAnswer::where('user_id', $this->selectedUserId)
                ->where('custom_test_id', $this->selectedTestId)
                ->delete();
                
            if ($deleted > 0) {
                $this->dispatch("alert", message: "Test berhasil direset", type: "success");
                
                // Refresh data
                $this->currentView = 'users';
                $this->selectedUserId = null;
                $this->selectedUser = null;
            } else {
                $this->dispatch('info', message: 'Tidak ada data test yang perlu direset');
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }
    
    // Reset Test untuk User dari users view
    public function resetTestForUserFromList($userId)
    {
        try {
            // Check if guru can manage this test
            $test = CustomTest::findOrFail($this->selectedTestId);
            if (!auth()->user()->canManageCustomTest($test)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mereset test ini", type: "error");
                return;
            }

            $user = User::findOrFail($userId);

            $deleted = CustomTestAnswer::where('user_id', $userId)
                ->where('custom_test_id', $this->selectedTestId)
                ->delete();
                
            if ($deleted > 0) {
                $this->dispatch("alert", message: "Test berhasil di reset", type: "success");
            } else {
                $this->dispatch('info', message: 'Tidak ada data test yang perlu direset');
            }
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat mereset", type: "error");
        }
    }
    
    // Data Methods
    private function getTestsWithStats()
    {
        return CustomTest::withCount([
            'answers as total_participants' => function($query) {
                $query->selectRaw('COUNT(DISTINCT user_id)');
            },
            'answers as essay_pending' => function($query) {
                $query->whereHas('customTestQuestion', function($q) {
                    $q->where('tipe_soal', 'text');
                })->whereNull('is_correct');
            },
            'answers as essay_reviewed' => function($query) {
                $query->whereHas('customTestQuestion', function($q) {
                    $q->where('tipe_soal', 'text');
                })->whereNotNull('is_correct');
            }
        ])
        // Filter by mapel_id for guru
        ->when(auth()->user()->isGuru(), function ($query) {
            $query->where('mapel_id', auth()->user()->mapel_id);
        })
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
                          $q->where('tipe_soal', 'text');
                      })
                      ->whereNull('is_correct');
            },
            'customTestAnswers as essay_reviewed' => function($query) {
                $query->where('custom_test_id', $this->selectedTestId)
                      ->whereHas('customTestQuestion', function($q) {
                          $q->where('tipe_soal', 'text');
                      })
                      ->whereNotNull('is_correct');
            },
            'customTestAnswers as essay_approved' => function($query) {
                $query->where('custom_test_id', $this->selectedTestId)
                      ->whereHas('customTestQuestion', function($q) {
                          $q->where('tipe_soal', 'text');
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
        
        return [
            'radio_total' => $radioAnswers->count(),
            'radio_correct' => $radioAnswers->where('is_correct', true)->count(),
            'essay_total' => $essayAnswers->count(),
            'essay_pending' => $essayAnswers->whereNull('is_correct')->count(),
            'essay_approved' => $essayAnswers->where('is_correct', true)->count(),
            'essay_rejected' => $essayAnswers->where('is_correct', false)->count(),
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
            
            return view('livewire.guru.pendaftaran.review-answers-page', $data);
                
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat memuat data.", type: "error");
            
            return view('livewire.guru.pendaftaran.review-answers-page', [
                'tests' => collect(),
                'users' => collect(),
                'userAnswers' => collect(),
                'userStats' => []
            ]);
        }
    }
}