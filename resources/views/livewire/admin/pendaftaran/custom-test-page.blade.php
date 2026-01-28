<div x-data="{ 
    searchFocused: false,
    showQuestionHelper: {},
    dragOver: {},
    toggleQuestionHelper(index) {
        this.showQuestionHelper[index] = !this.showQuestionHelper[index];
    },
    handleDrop(event, index) {
        event.preventDefault();
        this.dragOver[index] = false;
        const files = event.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            $wire.set(`questionImages.${index}`, files[0]);
        }
    },
    handleDragOver(event, index) {
        event.preventDefault();
        this.dragOver[index] = true;
    },
    handleDragLeave(event, index) {
        event.preventDefault();
        this.dragOver[index] = false;
    }
}">
    <x-atoms.breadcrumb currentPath="Custom Test" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <x-atoms.title text="Custom Test" size="xl" />
                <x-atoms.description size="sm" color="gray-600">
                    Kelola custom test untuk jalur pendaftaran dengan dukungan radio, checkbox, dan textarea
                </x-atoms.description>
            </div>
            
            <x-atoms.button wire:click="create" variant="success" heroicon="plus" className="whitespace-nowrap">
                <span wire:loading.remove>Tambah Custom Test</span>
                <span wire:loading>Loading...</span>
            </x-atoms.button>
        </div>

        <!-- Search and Filter -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <x-atoms.input type="search" wire:model.live.debounce.300ms="search" 
                        placeholder="Cari nama test..." className="w-full" />
                </div>
                <div class="relative md:w-48">
                    <select wire:model.live="statusFilter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Test</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Soal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tests as $test)
                        <tr class="hover:bg-gray-50" wire:key="test-{{ $test->id }}">
                            <td class="px-6 py-4">
                                <div>
                                    <x-atoms.title text="{{ $test->nama_test }}" size="sm" className="mb-1" />
                                    @if($test->deskripsi)
                                    <x-atoms.description size="xs" color="gray-500">
                                        {{ Str::limit($test->deskripsi, 50) }}
                                    </x-atoms.description>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <x-atoms.badge text="{{ $test->questions_count }} soal" variant="sky" size="sm" />
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $test->id }})" 
                                    class="flex items-center gap-1 text-sm {{ $test->is_active ? 'text-green-600' : 'text-red-600' }}">
                                    @if($test->is_active)
                                        <x-heroicon-o-check-circle class="w-4 h-4" />
                                    @else
                                        <x-heroicon-o-x-circle class="w-4 h-4" />
                                    @endif
                                    {{ $test->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">
                                    {{ $test->category == 'custom_test' ? 'Test Murid' : ($test->category == 'kuesioner_ortu' ? 'Kuesioner Ortu' : '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <x-atoms.button wire:click="edit({{ $test->id }})" variant="primary" theme="dark" 
                                        size="sm" heroicon="pencil" className="!p-1 !min-h-[28px]" />
                                    <x-atoms.button wire:click="delete({{ $test->id }})" 
                                        wire:confirm="Yakin ingin menghapus test ini?"
                                        variant="danger" theme="dark" size="sm" heroicon="trash" 
                                        className="!p-1 !min-h-[28px]" />
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <x-heroicon-o-document-text class="w-12 h-12 text-gray-400" />
                                    <x-atoms.title text="Belum ada data custom test" size="md" className="text-gray-500" />
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($tests->hasPages())
                <div class="px-6 py-4 border-t">{{ $tests->links('vendor.pagination.tailwind') }}</div>
            @endif
        </div>
    </x-atoms.card>

    {{-- Modal Custom Test --}}
    <x-atoms.modal name="custom-test" maxWidth="6xl">
        <div class="p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-document-text class="w-6 h-6 text-indigo-600" />
                </div>
                <div>
                    <x-atoms.title :text="$editMode ? 'Edit Custom Test' : 'Tambah Custom Test'" size="lg" />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data custom test' : 'Buat custom test baru dengan soal radio, checkbox, atau textarea' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <x-atoms.title text="Informasi Dasar" size="md" />
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-molecules.input-field label="Nama Test" name="nama_test" 
                            wire:model.lazy="nama_test" placeholder="Masukan nama test" 
                            :required="true" :error="$errors->first('nama_test')" />

                        <div>
                            <x-atoms.label for="mapel_id">Mapel</x-atoms.label>
                            <select wire:model.lazy="mapel_id" id="mapel_id"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                                <option value="">Pilih Mapel (Opsional)</option>
                                @foreach($mapelList as $mapel)
                                    <option value="{{ $mapel['id'] }}">{{ $mapel['mapel_name'] }}</option>
                                @endforeach
                            </select>
                            @error('mapel_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <x-atoms.label for="category">Kategori</x-atoms.label>
                            <select wire:model.lazy="category" id="category"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                                <option value="">Pilih Kategori (Opsional)</option>
                                <option value="custom_test">Kustom Test</option>
                                <option value="kuesioner_ortu">Kuesioner Orang Tua</option>
                            </select>
                            @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <x-atoms.label for="status">Status <span class="text-red-500">*</span></x-atoms.label>
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" wire:model.lazy="is_active" value="1"
                                           class="text-lime-600 focus:ring-lime-500 mr-2">
                                    <span class="text-sm text-gray-700">Aktif</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" wire:model.lazy="is_active" value="0"
                                           class="text-lime-600 focus:ring-lime-500 mr-2">
                                    <span class="text-sm text-gray-700">Nonaktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <x-molecules.textarea-field label="Deskripsi" name="deskripsi" 
                        wire:model.lazy="deskripsi" placeholder="Masukan deskripsi test (opsional)" 
                        :rows="3" :error="$errors->first('deskripsi')" />
                </div>

                <!-- Questions Section -->
                <div class="border-t pt-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <x-atoms.title text="Soal-soal Test" size="lg" />
                            <x-atoms.description size="sm" color="gray-500">
                                Tambahkan soal dengan tipe Radio, Checkbox, atau Textarea
                            </x-atoms.description>
                        </div>
                        <x-atoms.button type="button" wire:click="addQuestion" variant="success" 
                            theme="light" size="sm" heroicon="plus">Tambah Soal</x-atoms.button>
                    </div>

                    @if(empty($questions))
                        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed">
                            <x-heroicon-o-question-mark-circle class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                            <x-atoms.title text="Belum ada soal" size="md" className="text-gray-500 mb-2" />
                            <x-atoms.button type="button" wire:click="addQuestion" variant="success" 
                                heroicon="plus" size="sm">Tambah Soal Pertama</x-atoms.button>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @foreach($questions as $index => $question)
                        <div class="border rounded-lg p-6 bg-white shadow-sm" wire:key="question-{{ $index }}">
                            <!-- Question Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-lime-100 to-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-semibold text-lime-600">{{ $index + 1 }}</span>
                                    </div>
                                    <x-atoms.title text="Soal {{ $index + 1 }}" size="md" />
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="toggleQuestionHelper({{ $index }})"
                                        class="text-gray-400 hover:text-gray-600">
                                        <x-heroicon-o-question-mark-circle class="w-5 h-5" />
                                    </button>
                                    @if(count($questions) > 1)
                                        <x-atoms.button type="button" wire:click="removeQuestion({{ $index }})"
                                            wire:confirm="Yakin ingin menghapus soal ini?"
                                            variant="danger" theme="light" size="sm" heroicon="trash" className="!p-2" />
                                    @endif
                                </div>
                            </div>

                            <!-- Helper Text -->
                            <div x-show="showQuestionHelper[{{ $index }}]" x-transition
                                 class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <x-atoms.description size="sm" color="blue-700">
                                    <strong>Textarea:</strong> Untuk jawaban essay/teks panjang.<br>
                                    <strong>Radio:</strong> Pilihan ganda (1 jawaban benar).<br>
                                    <strong>Checkbox:</strong> Pilihan ganda (bisa pilih lebih dari 1, tanpa jawaban benar otomatis).
                                </x-atoms.description>
                            </div>

                            <div class="space-y-6">
                                <!-- Question Text -->
                                <x-molecules.textarea-field label="Pertanyaan" 
                                    name="questions.{{ $index }}.pertanyaan"
                                    wire:model.lazy="questions.{{ $index }}.pertanyaan"
                                    placeholder="Masukan pertanyaan" :rows="3" :required="true"
                                    :error="$errors->first('questions.' . $index . '.pertanyaan')" />

                                <!-- Image Upload Section -->
                                <div>
                                    <x-atoms.label for="image-{{ $index }}">Gambar Soal (Opsional)</x-atoms.label>
                                    
                                    @php
                                        $hasExisting = isset($question['existing_image']) && $question['existing_image'];
                                        $hasUploaded = isset($questionImages[$index]) && $questionImages[$index];
                                    @endphp

                                    @if($hasExisting || $hasUploaded)
                                        <div class="mt-2 relative inline-block">
                                            <img src="{{ $hasUploaded ? $questionImages[$index]->temporaryUrl() : asset('storage/' . $question['existing_image']) }}" 
                                                 alt="Preview" class="max-w-xs max-h-48 rounded-lg border shadow-sm">
                                            <button type="button" wire:click="removeQuestionImage({{ $index }})"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                                <x-heroicon-o-x-mark class="w-4 h-4" />
                                            </button>
                                        </div>
                                    @else
                                        <div class="mt-2">
                                            <div @drop="handleDrop($event, {{ $index }})" 
                                                 @dragover="handleDragOver($event, {{ $index }})"
                                                 @dragleave="handleDragLeave($event, {{ $index }})"
                                                 :class="dragOver[{{ $index }}] ? 'border-lime-500 bg-lime-50' : ''"
                                                 class="border-2 border-dashed rounded-lg p-6 text-center hover:border-lime-400">
                                                <x-heroicon-o-photo class="w-12 h-12 text-gray-400 mx-auto mb-3" />
                                                <p class="text-sm text-gray-600 mb-2">
                                                    Drag & drop atau 
                                                    <label class="text-lime-600 cursor-pointer font-medium">
                                                        pilih file
                                                        <input type="file" wire:model="questionImages.{{ $index }}" 
                                                               accept="image/*" class="hidden">
                                                    </label>
                                                </p>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @error('questionImages.' . $index)
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Question Type -->
                                <div>
                                    <x-atoms.label>Tipe Soal <span class="text-red-500">*</span></x-atoms.label>
                                    <div class="flex flex-wrap gap-3 mt-2">
                                        <label class="flex items-center cursor-pointer p-3 border rounded-lg hover:bg-gray-50 {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'text' ? 'border-lime-500 bg-lime-50' : '' }}">
                                            <input type="radio" wire:click="updateQuestionType({{ $index }}, 'text')" 
                                                   value="text" {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'text' ? 'checked' : '' }}
                                                   class="text-lime-600 focus:ring-lime-500 mr-3">
                                            <div>
                                                <span class="text-sm font-medium">Textarea</span>
                                                <p class="text-xs text-gray-500">Jawaban panjang</p>
                                            </div>
                                        </label>
                                        <label class="flex items-center cursor-pointer p-3 border rounded-lg hover:bg-gray-50 {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'radio' ? 'border-lime-500 bg-lime-50' : '' }}">
                                            <input type="radio" wire:click="updateQuestionType({{ $index }}, 'radio')" 
                                                   value="radio" {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'radio' ? 'checked' : '' }}
                                                   class="text-lime-600 focus:ring-lime-500 mr-3">
                                            <div>
                                                <span class="text-sm font-medium">Radio</span>
                                                <p class="text-xs text-gray-500">1 jawaban</p>
                                            </div>
                                        </label>
                                        <label class="flex items-center cursor-pointer p-3 border rounded-lg hover:bg-gray-50 {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'checkbox' ? 'border-lime-500 bg-lime-50' : '' }}">
                                            <input type="radio" wire:click="updateQuestionType({{ $index }}, 'checkbox')" 
                                                   value="checkbox" {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'checkbox' ? 'checked' : '' }}
                                                   class="text-lime-600 focus:ring-lime-500 mr-3">
                                            <div>
                                                <span class="text-sm font-medium">Checkbox</span>
                                                <p class="text-xs text-gray-500">Banyak pilihan</p>
                                            </div>
                                        </label>
                                    </div>
                                    @error('questions.' . $index . '.tipe_soal')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Radio/Checkbox Options -->
                                @if(isset($question['tipe_soal']) && in_array($question['tipe_soal'], ['radio', 'checkbox']))
                                <div x-transition>
                                    <x-atoms.label>Pilihan Jawaban <span class="text-red-500">*</span></x-atoms.label>
                                    
                                    <div class="space-y-3 mt-2">
                                        @if(isset($question['options']) && is_array($question['options']))
                                        @foreach($question['options'] as $optIndex => $opt)
                                        <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg" 
                                             wire:key="opt-{{ $index }}-{{ $optIndex }}">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0 border">
                                                <span class="text-sm font-medium text-gray-600">{{ chr(65 + $optIndex) }}</span>
                                            </div>
                                            <x-atoms.input type="text" 
                                                wire:model.lazy="questions.{{ $index }}.options.{{ $optIndex }}"
                                                placeholder="Opsi {{ chr(65 + $optIndex) }}" className="flex-1" />
                                            @if(count($question['options']) > 2)
                                            <x-atoms.button type="button" 
                                                wire:click="removeOption({{ $index }}, {{ $optIndex }})"
                                                variant="danger" theme="light" size="sm" heroicon="trash" className="!p-2" />
                                            @endif
                                        </div>
                                        @endforeach
                                        @endif
                                        
                                        @if(!isset($question['options']) || count($question['options']) < 10)
                                        <x-atoms.button type="button" wire:click="addOption({{ $index }})"
                                            variant="ghost" theme="dark" size="sm" heroicon="plus"
                                            className="w-full border-2 border-dashed">Tambah Opsi</x-atoms.button>
                                        @endif
                                    </div>
                                    @error('questions.' . $index . '.options')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror

                                    <!-- Correct Answer (Radio Only) -->
                                    @if($question['tipe_soal'] === 'radio')
                                    <div class="mt-4">
                                        <x-atoms.label>Jawaban Benar <span class="text-red-500">*</span></x-atoms.label>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            @if(isset($question['options']))
                                            @foreach($question['options'] as $optIndex => $opt)
                                            @if(!empty(trim($opt)))
                                            <label class="flex items-center gap-2 cursor-pointer p-3 bg-white rounded-lg border hover:border-lime-300 {{ isset($question['jawaban_benar']) && $question['jawaban_benar'] === chr(65 + $optIndex) ? 'border-lime-500 bg-lime-50' : '' }}">
                                                <input type="radio" wire:model.lazy="questions.{{ $index }}.jawaban_benar" 
                                                       value="{{ chr(65 + $optIndex) }}" class="text-lime-600 focus:ring-lime-500">
                                                <span class="text-sm font-medium">{{ chr(65 + $optIndex) }}</span>
                                                <span class="text-xs text-gray-500 max-w-[100px] truncate">{{ $opt }}</span>
                                            </label>
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                        @error('questions.' . $index . '.jawaban_benar')
                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @else
                                    <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                        <x-atoms.description size="sm" color="amber-700">
                                            💡 <strong>Checkbox:</strong> Tidak ada jawaban benar otomatis. Pengguna bisa pilih lebih dari 1 opsi.
                                        </x-atoms.description>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="border-t pt-6 mt-6">
                    <div class="flex gap-3">
                        <x-atoms.button type="submit" variant="success" heroicon="check" className="flex-1">
                            <span wire:loading.remove wire:target="save">
                                {{ $editMode ? 'Perbarui' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="save">
                                {{ $editMode ? 'Memperbarui...' : 'Menyimpan...' }}
                            </span>
                        </x-atoms.button>
                        
                        <x-atoms.button type="button" wire:click="closeModal" variant="danger" 
                            theme="light" heroicon="x-mark" className="flex-1">Batal</x-atoms.button>
                    </div>
                </div>
            </form>
        </div>
    </x-atoms.modal>

    <!-- Loading Overlay -->
    <div wire:loading.flex wire:target="save" 
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3 shadow-xl">
            <div class="animate-spin rounded-full h-6 w-6 border-2 border-indigo-600 border-t-transparent"></div>
            <span>{{ $editMode ? 'Memperbarui...' : 'Menyimpan...' }}</span>
        </div>
    </div>
</div>