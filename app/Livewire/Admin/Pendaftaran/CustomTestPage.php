<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestQuestion;
use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Kustom Test")]
class CustomTestPage extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $statusFilter = '';
    public $editMode = false;
    public $selectedId = null;
    public $modalOpen = false;
    public $nama_test = '';
    public $deskripsi = '';
    public $is_active = true;
    public $mapel_id = null;
    public $category = null;
    public $questions = [];
    public $questionImages = [];
    public $mapelList = [];
    public $isLoading = false;
    public $isSaving = false;

    public function mount()
    {
        $this->loadMapelList();
    }

    public function loadMapelList()
    {
        $this->mapelList = Mapel::orderBy('mapel_name')->get()->toArray();
    }

    protected function rules()
    {
        $rules = [
            'nama_test' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'is_active' => 'required|boolean',
            'mapel_id' => 'nullable|exists:mapels,id',
            'category' => 'nullable'
        ];

        foreach ($this->questions as $index => $question) {
            $rules["questions.{$index}.pertanyaan"] = 'required|string|max:500';
            $rules["questions.{$index}.tipe_soal"] = 'required|in:radio,text,checkbox';
            
            if (isset($this->questionImages[$index])) {
                $rules["questionImages.{$index}"] = 'image|max:2048|mimes:jpeg,png,jpg,gif,webp';
            }
            
            if (isset($question['tipe_soal']) && in_array($question['tipe_soal'], ['radio', 'checkbox'])) {
                $rules["questions.{$index}.options"] = 'required|array|min:2';
                $rules["questions.{$index}.options.*"] = 'required|string|max:200';
                
                if ($question['tipe_soal'] === 'radio') {
                    $rules["questions.{$index}.jawaban_benar"] = 'required|string|size:1';
                }
            }
        }

        return $rules;
    }

    protected $messages = [
        'nama_test.required' => 'Nama test wajib diisi',
        'questions.*.pertanyaan.required' => 'Pertanyaan wajib diisi',
        'questions.*.tipe_soal.required' => 'Tipe soal wajib dipilih',
        'questions.*.options.required' => 'Pilihan jawaban wajib diisi',
        'questions.*.options.min' => 'Minimal 2 pilihan jawaban',
        'questions.*.jawaban_benar.required' => 'Jawaban benar wajib dipilih (untuk radio)',
        'questionImages.*.image' => 'File harus berupa gambar',
        'questionImages.*.max' => 'Ukuran gambar maksimal 2MB',
    ];

    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }

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
        $this->reset(['nama_test', 'deskripsi', 'mapel_id', 'questions', 'questionImages', 'editMode', 'selectedId', 'category']);
        $this->is_active = true;
        $this->resetErrorBag();
    }

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
            $test = CustomTest::with(['questions' => fn($q) => $q->orderBy('urutan')])->findOrFail($id);
            
            $this->selectedId = $id;
            $this->nama_test = $test->nama_test;
            $this->deskripsi = $test->deskripsi ?? '';
            $this->is_active = $test->is_active;
            $this->mapel_id = $test->mapel_id;
            $this->category = $test->category;

            $this->questions = [];
            $this->questionImages = [];
            foreach ($test->questions as $question) {
                $this->questions[] = [
                    'pertanyaan' => $question->pertanyaan,
                    'tipe_soal' => $question->tipe_soal,
                    'options' => $question->options ?? [],
                    'jawaban_benar' => $question->jawaban_benar ?? '',
                    'existing_image' => $question->image
                ];
                $this->questionImages[] = null;
            }
            
            $this->editMode = true;
            $this->openModal();
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal mengambil data.", type: "error");
        } finally {
            $this->isLoading = false;
        }
    }

    public function save()
    {
        try {
            $this->isSaving = true;
            
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
                'mapel_id' => $this->mapel_id,
                'category' => $this->category,
            ];

            if ($this->editMode) {
                $test = CustomTest::findOrFail($this->selectedId);
                $test->update($data);
                $oldQuestions = $test->questions;
                $test->questions()->delete();
                $message = 'Custom test berhasil diperbarui';
            } else {
                $test = CustomTest::create($data);
                $oldQuestions = collect();
                $message = 'Custom test berhasil ditambahkan';
            }

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
            $validOptions = array_filter($question['options'] ?? [], fn($opt) => !empty(trim($opt)));
            
            if (in_array($question['tipe_soal'], ['radio', 'checkbox']) && count($validOptions) < 2) {
                $this->addError("questions.{$index}.options", 'Minimal 2 opsi jawaban');
                continue;
            }
            
            if ($question['tipe_soal'] === 'radio') {
                if (empty($question['jawaban_benar'])) {
                    $this->addError("questions.{$index}.jawaban_benar", 'Jawaban benar harus dipilih');
                } else {
                    $answerIndex = ord($question['jawaban_benar']) - 65;
                    if ($answerIndex >= count($validOptions)) {
                        $this->addError("questions.{$index}.jawaban_benar", 'Jawaban benar tidak valid');
                    }
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
            
            if (isset($this->questionImages[$index]) && $this->questionImages[$index]) {
                $imagePath = $this->questionImages[$index]->store('question-images', 'public');
            } elseif (isset($question['existing_image'])) {
                $imagePath = $question['existing_image'];
            }
            
            if (in_array($question['tipe_soal'], ['radio', 'checkbox'])) {
                $options = array_values(array_filter($question['options'] ?? [], fn($opt) => !empty(trim($opt))));
                if ($question['tipe_soal'] === 'radio') {
                    $jawaban_benar = $question['jawaban_benar'];
                }
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
        
        if ($oldQuestions) {
            foreach ($oldQuestions as $oldQ) {
                if ($oldQ->image && !collect($this->questions)->pluck('existing_image')->contains($oldQ->image)) {
                    Storage::disk('public')->delete($oldQ->image);
                }
            }
        }
    }

    public function delete($id)
    {
        try {
            $test = CustomTest::with('questions')->findOrFail($id);
            if ($test->tesJalurs()->exists()) {
                $this->dispatch("alert", message: "Tidak dapat menghapus test yang sedang digunakan.", type: "warning");
                return;
            }
            
            foreach ($test->questions as $q) {
                if ($q->image) Storage::disk('public')->delete($q->image);
            }
            
            $test->delete();
            $this->dispatch("alert", message: "Berhasil menghapus custom test", type: "error");
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus custom test", type: "error");
        }
    }

    public function toggleStatus($id)
    {
        try {
            $test = CustomTest::findOrFail($id);
            $test->update(['is_active' => !$test->is_active]);
            $status = $test->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch("alert", message: "Custom test berhasil " . $status, type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal mengubah status", type: "error");
        }
    }

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
            $this->dispatch("alert", message: "Minimal harus ada 1 soal", type: "warning");
            return;
        }
        unset($this->questions[$index], $this->questionImages[$index]);
        $this->questions = array_values($this->questions);
        $this->questionImages = array_values($this->questionImages);
        $this->resetErrorBag();
    }

    public function removeQuestionImage($index)
    {
        $this->questions[$index]['existing_image'] = null;
        $this->questionImages[$index] = null;
        $this->resetErrorBag("questionImages.{$index}");
    }

    public function updateQuestionType($index, $type)
    {
        $this->questions[$index]['tipe_soal'] = $type;
        
        if (in_array($type, ['radio', 'checkbox'])) {
            if (empty($this->questions[$index]['options'])) {
                $this->questions[$index]['options'] = ['', ''];
            }
            if ($type === 'checkbox') {
                $this->questions[$index]['jawaban_benar'] = '';
            }
        } else {
            $this->questions[$index]['options'] = [];
            $this->questions[$index]['jawaban_benar'] = '';
        }
        
        $this->resetErrorBag("questions.{$index}");
    }

    public function addOption($qIndex)
    {
        if (!isset($this->questions[$qIndex]['options'])) {
            $this->questions[$qIndex]['options'] = [];
        }
        
        if (count($this->questions[$qIndex]['options']) < 10) {
            $this->questions[$qIndex]['options'][] = '';
        } else {
            $this->dispatch("alert", message: "Maksimal 10 opsi", type: "warning");
        }
    }

    public function removeOption($qIndex, $optIndex)
    {
        if (count($this->questions[$qIndex]['options']) <= 2) {
            $this->dispatch("alert", message: "Minimal 2 opsi", type: "warning");
            return;
        }
        
        unset($this->questions[$qIndex]['options'][$optIndex]);
        $this->questions[$qIndex]['options'] = array_values($this->questions[$qIndex]['options']);
        
        // Adjust jawaban_benar for radio
        if ($this->questions[$qIndex]['tipe_soal'] === 'radio' && 
            isset($this->questions[$qIndex]['jawaban_benar'])) {
            $currentAnswer = $this->questions[$qIndex]['jawaban_benar'];
            $answerIdx = ord($currentAnswer) - 65;
            
            if ($answerIdx == $optIndex) {
                $this->questions[$qIndex]['jawaban_benar'] = '';
            } elseif ($answerIdx > $optIndex) {
                $this->questions[$qIndex]['jawaban_benar'] = chr(64 + $answerIdx);
            }
        }
        
        $this->resetErrorBag("questions.{$qIndex}");
    }

    public function render()
    {
        $tests = CustomTest::query()
            ->with('mapel')
            ->when($this->search, fn($q) => $q->where('nama_test', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%'))
            ->when($this->statusFilter !== '', fn($q) => $q->where('is_active', $this->statusFilter))
            ->withCount('questions')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.pendaftaran.custom-test-page', ['tests' => $tests]);
    }
}