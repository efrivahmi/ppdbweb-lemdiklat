<?php

namespace App\Livewire\Guru\Pendaftaran;

use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestQuestion;
use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Debounce;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.guru")]
#[Title("Kustom Test")]
class CustomTestPage extends Component
{
    use WithPagination, WithFileUploads;
    
    // Search & Filter
    public $search = '';
    public $statusFilter = '';
    
    // Modal State
    public $editMode = false;
    public $selectedId = null;
    public $modalOpen = false;

    // Form Data
    public $nama_test = '';
    public $deskripsi = '';
    public $is_active = true;
    public $mapel_id = null;
    public $questions = [];

    // File uploads - untuk temporary storage saat editing
    public $questionImages = [];

    // Mapel info
    public $mapelName = '';
    
    // UI State
    public $isLoading = false;
    public $isSaving = false;

    public function mount()
    {
        // Set mapel_id dan nama untuk guru
        if (auth()->user()->isGuru() && auth()->user()->mapel_id) {
            $this->mapel_id = auth()->user()->mapel_id;
            $mapel = Mapel::find($this->mapel_id);
            $this->mapelName = $mapel ? $mapel->mapel_name : 'Tidak ada mapel';
        }
    }

    protected function rules()
    {
        $rules = [
            'nama_test' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'is_active' => 'required|boolean',
        ];

        // Dynamic rules untuk questions
        foreach ($this->questions as $index => $question) {
            $rules["questions.{$index}.pertanyaan"] = 'required|string|max:500';
            $rules["questions.{$index}.tipe_soal"] = 'required|in:radio,text';
            
            // Image validation
            if (isset($this->questionImages[$index])) {
                $rules["questionImages.{$index}"] = 'image|max:2048|mimes:jpeg,png,jpg,gif,webp';
            }
            
            if (isset($question['tipe_soal']) && $question['tipe_soal'] === 'radio') {
                $rules["questions.{$index}.options"] = 'required|array|min:2';
                $rules["questions.{$index}.options.*"] = 'required|string|max:200';
                $rules["questions.{$index}.jawaban_benar"] = 'required|string|size:1';
            }
        }

        return $rules;
    }

    protected $messages = [
        'nama_test.required' => 'Nama test wajib diisi',
        'nama_test.max' => 'Nama test maksimal 255 karakter',
        'questions.*.pertanyaan.required' => 'Pertanyaan wajib diisi',
        'questions.*.tipe_soal.required' => 'Tipe soal wajib dipilih',
        'questions.*.options.required' => 'Pilihan jawaban wajib diisi untuk soal radio',
        'questions.*.options.min' => 'Minimal 2 pilihan jawaban untuk soal radio',
        'questions.*.jawaban_benar.required' => 'Jawaban benar wajib dipilih',
        'questionImages.*.image' => 'File harus berupa gambar',
        'questionImages.*.max' => 'Ukuran gambar maksimal 2MB',
        'questionImages.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
    ];

    // Search dengan debouncing
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    // Modal Management
    public function openModal()
    {
        $this->modalOpen = true;
        $this->dispatch('open-modal', name: 'custom-test');
    }
    
    public function closeModal()
    {
        $this->modalOpen = false;
        $this->dispatch('close-modal', name: 'custom-test');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nama_test = '';
        $this->deskripsi = '';
        $this->is_active = true;
        // Don't reset mapel_id for guru, it should remain the same
        $this->questions = [];
        $this->questionImages = [];
        $this->editMode = false;
        $this->selectedId = null;
        $this->resetErrorBag();
    }

    // CRUD Operations
    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal();
    }

    public function edit($id)
    {
        try {
            $this->isLoading = true;

            $test = CustomTest::with(['questions' => function($query) {
                $query->orderBy('urutan');
            }])->findOrFail($id);

            // Check if guru can manage this test
            if (!auth()->user()->canManageCustomTest($test)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mengelola test ini", type: "error");
                return;
            }

            $this->selectedId = $id;
            $this->nama_test = $test->nama_test;
            $this->deskripsi = $test->deskripsi ?? '';
            $this->is_active = $test->is_active;
            
            // Load questions
            $this->questions = [];
            $this->questionImages = [];
            foreach ($test->questions as $question) {
                $this->questions[] = [
                    'pertanyaan' => $question->pertanyaan,
                    'tipe_soal' => $question->tipe_soal,
                    'options' => $question->options ?? [],
                    'jawaban_benar' => $question->jawaban_benar ?? '',
                    'existing_image' => $question->image // Store existing image path
                ];
                $this->questionImages[] = null; // No new upload yet
            }
            
            $this->editMode = true;
            $this->openModal();
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal memuat data test", type: "error");
        } finally {
            $this->isLoading = false;
        }
    }

    public function save()
    {
        try {
            $this->isSaving = true;
            
            // Validate basic fields first
            $this->validateOnly('nama_test');
            $this->validateOnly('deskripsi');
            $this->validateOnly('is_active');
            
            // Validate questions
            if (empty($this->questions)) {
                $this->addError('questions', 'Minimal harus ada 1 soal');
                return;
            }

            $this->validateQuestions();
            $this->validate();

            $data = [
                'nama_test' => trim($this->nama_test),
                'deskripsi' => trim($this->deskripsi) ?: null,
                'is_active' => $this->is_active,
                'mapel_id' => auth()->user()->isGuru() ? auth()->user()->mapel_id : null,
            ];

            if ($this->editMode) {
                $test = CustomTest::findOrFail($this->selectedId);

                // Check if guru can manage this test
                if (!auth()->user()->canManageCustomTest($test)) {
                    $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mengelola test ini", type: "error");
                    return;
                }

                $test->update($data);
                
                // Delete old questions (images will be handled in saveQuestions)
                $oldQuestions = $test->questions;
                $test->questions()->delete();
                
                $message = 'Custom test berhasil diperbarui';
            } else {
                $test = CustomTest::create($data);
                $oldQuestions = collect();
                $message = 'Custom test berhasil ditambahkan';
            }

            // Save questions with image handling
            $this->saveQuestions($test, $oldQuestions);

            $this->closeModal();
            $this->dispatch("alert", message: $message, type: "success");
            $this->resetPage();
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan saat menyimpan data", type: "error");
        } finally {
            $this->isSaving = false;
        }
    }

    private function validateQuestions()
    {
        foreach ($this->questions as $index => $question) {
            if ($question['tipe_soal'] === 'radio') {
                $validOptions = array_filter($question['options'] ?? [], function($option) {
                    return !empty(trim($option));
                });
                
                if (count($validOptions) < 2) {
                    $this->addError("questions.{$index}.options", 'Soal radio harus memiliki minimal 2 opsi jawaban');
                    continue;
                }
                
                if (empty($question['jawaban_benar'])) {
                    $this->addError("questions.{$index}.jawaban_benar", 'Jawaban benar harus dipilih');
                    continue;
                }
                
                $answerIndex = ord($question['jawaban_benar']) - 65;
                if ($answerIndex >= count($validOptions)) {
                    $this->addError("questions.{$index}.jawaban_benar", 'Jawaban benar tidak sesuai dengan opsi yang tersedia');
                }
            }
        }
    }

    private function saveQuestions($test, $oldQuestions = null)
    {
        foreach ($this->questions as $index => $question) {
            $options = null;
            $jawaban_benar = null;
            $imagePath = null;
            
            // Handle image upload
            if (isset($this->questionImages[$index]) && $this->questionImages[$index]) {
                // New image uploaded
                $imagePath = $this->questionImages[$index]->store('question-images', 'public');
            } elseif (isset($question['existing_image']) && $question['existing_image']) {
                // Keep existing image
                $imagePath = $question['existing_image'];
            }
            
            // Handle radio options
            if ($question['tipe_soal'] === 'radio') {
                $options = array_values(array_filter(
                    $question['options'] ?? [], 
                    fn($option) => !empty(trim($option))
                ));
                $jawaban_benar = $question['jawaban_benar'];
            }
            
            CustomTestQuestion::create([
                'custom_test_id' => $test->id,
                'pertanyaan' => trim($question['pertanyaan']),
                'tipe_soal' => $question['tipe_soal'],
                'image' => $imagePath,
                'options' => $options,
                'jawaban_benar' => $jawaban_benar,
                'urutan' => $index + 1
            ]);
        }
        
        // Clean up old images that are no longer used
        if ($oldQuestions) {
            foreach ($oldQuestions as $oldQuestion) {
                if ($oldQuestion->image && 
                    !collect($this->questions)->pluck('existing_image')->contains($oldQuestion->image)) {
                    Storage::disk('public')->delete($oldQuestion->image);
                }
            }
        }
    }

    public function delete($id)
    {
        try {
            $test = CustomTest::with('questions')->findOrFail($id);

            // Check if guru can manage this test
            if (!auth()->user()->canManageCustomTest($test)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk menghapus test ini", type: "error");
                return;
            }

            // Check if test is being used
            if ($test->tesJalurs()->exists()) {
                $this->dispatch("alert", message: "Tidak dapat menghapus custom test, sedang digunakan.", type: "warning");
                return;
            }
            
            // Delete question images
            foreach ($test->questions as $question) {
                if ($question->image) {
                    Storage::disk('public')->delete($question->image);
                }
            }
            
            $test->delete();
            $this->dispatch("alert", message: "Custom test berhasil di hapus", type: "success");
            $this->resetPage();
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal mengahpus custom test", type: "error");
        }
    }

    public function toggleStatus($id)
    {
        try {
            $test = CustomTest::findOrFail($id);

            // Check if guru can manage this test
            if (!auth()->user()->canManageCustomTest($test)) {
                $this->dispatch("alert", message: "Anda tidak memiliki akses untuk mengubah status test ini", type: "error");
                return;
            }

            $test->update(['is_active' => !$test->is_active]);
            
            $status = $test->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch("alert", message: "status test berhasil " . $status, type: "success");
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal mengubah status test", type: "error");
        }
    }

    // Question Management
    public function addQuestion()
    {
        $this->questions[] = [
            'pertanyaan' => '',
            'tipe_soal' => 'text',
            'options' => [],
            'jawaban_benar' => '',
            'existing_image' => null
        ];
        $this->questionImages[] = null;
    }

    public function removeQuestion($index)
    {
        if (count($this->questions) <= 1) {
            $this->dispatch('error', message: 'Minimal harus ada 1 soal');
            return;
        }
        
        // Clean up uploaded image if exists
        if (isset($this->questionImages[$index])) {
            unset($this->questionImages[$index]);
        }
        
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
        $this->questionImages = array_values($this->questionImages);
        $this->resetErrorBag();
    }

    public function removeQuestionImage($index)
    {
        // Remove existing image
        if (isset($this->questions[$index]['existing_image'])) {
            $this->questions[$index]['existing_image'] = null;
        }
        
        // Remove uploaded image
        if (isset($this->questionImages[$index])) {
            $this->questionImages[$index] = null;
        }
        
        $this->resetErrorBag("questionImages.{$index}");
    }

    public function updateQuestionType($index, $type)
    {
        $this->questions[$index]['tipe_soal'] = $type;
        
        if ($type === 'radio') {
            if (empty($this->questions[$index]['options'])) {
                $this->questions[$index]['options'] = ['', ''];
            }
        } else {
            $this->questions[$index]['options'] = [];
            $this->questions[$index]['jawaban_benar'] = '';
        }
        
        $this->resetErrorBag("questions.{$index}");
    }

    // Option Management
    public function addOption($questionIndex)
    {
        if (!isset($this->questions[$questionIndex]['options'])) {
            $this->questions[$questionIndex]['options'] = [];
        }
        
        if (count($this->questions[$questionIndex]['options']) < 5) {
            $this->questions[$questionIndex]['options'][] = '';
        } else {
            $this->dispatch('error', message: 'Maksimal 5 opsi jawaban');
        }
    }

    public function removeOption($questionIndex, $optionIndex)
    {
        if (count($this->questions[$questionIndex]['options']) <= 2) {
            $this->dispatch('error', message: 'Minimal 2 opsi jawaban');
            return;
        }
        
        unset($this->questions[$questionIndex]['options'][$optionIndex]);
        $this->questions[$questionIndex]['options'] = array_values($this->questions[$questionIndex]['options']);
        
        // Adjust jawaban_benar if needed
        if (isset($this->questions[$questionIndex]['jawaban_benar'])) {
            $currentAnswer = $this->questions[$questionIndex]['jawaban_benar'];
            $answerIndex = ord($currentAnswer) - 65;
            
            if ($answerIndex == $optionIndex) {
                $this->questions[$questionIndex]['jawaban_benar'] = '';
            } elseif ($answerIndex > $optionIndex) {
                $newAnswerIndex = $answerIndex - 1;
                $this->questions[$questionIndex]['jawaban_benar'] = chr(65 + $newAnswerIndex);
            }
        }
        
        $this->resetErrorBag("questions.{$questionIndex}");
    }

    public function render()
    {
        $tests = CustomTest::query()
            ->with('mapel')
            // Filter by mapel_id for guru
            ->when(auth()->user()->isGuru(), function ($query) {
                $query->where('mapel_id', auth()->user()->mapel_id);
            })
            ->when($this->search, function ($query) {
                $query->where('nama_test', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->withCount('questions')
            ->latest()
            ->paginate(10);

        return view('livewire.guru.pendaftaran.custom-test-page', [
            'tests' => $tests
        ]);
    }
}