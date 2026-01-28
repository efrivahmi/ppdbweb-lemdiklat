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
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                $wire.set(`questionImages.${index}`, file);
            } else {
                alert('Hanya file gambar yang diperbolehkan');
            }
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
                    Kelola custom test untuk jalur pendaftaran dengan dukungan gambar
                </x-atoms.description>
            </div>
            
            <x-atoms.button
                wire:click="create"
                variant="success"
                heroicon="plus"
                className="whitespace-nowrap"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Tambah Custom Test</span>
                <span wire:loading>Loading...</span>
            </x-atoms.button>
        </div>

        <!-- Search and Filter -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6 transition-all duration-200" 
             :class="searchFocused ? 'ring-2 ring-lime-200' : ''">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <x-atoms.input
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari nama test..."
                        className="w-full transition-all duration-200"
                        x-on:focus="searchFocused = true"
                        x-on:blur="searchFocused = false"
                    />
                    <div wire:loading.flex wire:target="updatedSearch" 
                         class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <div class="animate-spin rounded-full h-4 w-4 border-2 border-lime-500 border-t-transparent"></div>
                    </div>
                </div>
                <div class="relative md:w-48">
                    <select wire:model.live="statusFilter" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Test</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Soal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tests as $test)
                        <tr class="hover:bg-gray-50 transition-colors duration-150" 
                            wire:key="test-{{ $test->id }}">
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
                                <x-atoms.badge 
                                    text="{{ $test->questions_count }} soal"
                                    variant="sky" 
                                    size="sm"
                                />
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $test->id }})" 
                                        class="flex items-center gap-1 text-sm transition-colors duration-150 {{ $test->is_active ? 'text-green-600 hover:text-green-700' : 'text-red-600 hover:text-red-700' }}"
                                        wire:loading.attr="disabled"
                                        wire:target="toggleStatus({{ $test->id }})">
                                    <div wire:loading.remove wire:target="toggleStatus({{ $test->id }})">
                                        @if($test->is_active)
                                            <x-heroicon-o-check-circle class="w-4 h-4" />
                                        @else
                                            <x-heroicon-o-x-circle class="w-4 h-4" />
                                        @endif
                                        {{ $test->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </div>
                                    <div wire:loading wire:target="toggleStatus({{ $test->id }})" class="flex items-center gap-1">
                                        <div class="animate-spin rounded-full h-4 w-4 border-2 border-current border-t-transparent"></div>
                                        <span>Updating...</span>
                                    </div>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1 text-sm text-gray-500">
                                    <x-heroicon-o-calendar-days class="w-4 h-4" />
                                    <span>{{ $test->created_at->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <x-atoms.button
                                        wire:click="edit({{ $test->id }})"
                                        variant="primary"
                                        theme="dark"
                                        size="sm"
                                        heroicon="pencil"
                                        className="!p-1 !min-h-[28px] transition-all duration-150"
                                        wire:loading.attr="disabled"
                                        wire:target="edit({{ $test->id }})"
                                    />
                                    <x-atoms.button
                                        wire:click="delete({{ $test->id }})"
                                        wire:confirm="Yakin ingin menghapus test ini? Semua gambar soal akan ikut terhapus."
                                        variant="danger"
                                        theme="dark"
                                        size="sm"
                                        heroicon="trash"
                                        className="!p-1 !min-h-[28px] transition-all duration-150"
                                        wire:loading.attr="disabled"
                                        wire:target="delete({{ $test->id }})"
                                    />
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-document-text class="w-8 h-8 text-gray-400" />
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <x-atoms.title text="Belum ada data custom test" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400" class="mb-4">
                                            @if ($search || $statusFilter !== '')
                                                Tidak ditemukan data sesuai filter yang dipilih
                                            @else
                                                Mulai dengan menambahkan custom test untuk keperluan evaluasi
                                            @endif
                                        </x-atoms.description>
                                        @if (!$search && $statusFilter === '')
                                            <x-atoms.button
                                                wire:click="create"
                                                variant="success"
                                                heroicon="plus"
                                                size="sm"
                                            >
                                                Tambah Custom Test Pertama
                                            </x-atoms.button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($tests->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $tests->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </x-atoms.card>

    {{-- Modal Custom Test --}}
    <x-atoms.modal name="custom-test" maxWidth="6xl">
        <div class="p-6 max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-document-text class="w-6 h-6 text-indigo-600" />
                </div>
                <div>
                    <x-atoms.title 
                        :text="$editMode ? 'Edit Custom Test' : 'Tambah Custom Test'" 
                        size="lg" 
                    />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data custom test' : 'Buat custom test baru dengan soal-soal evaluasi dan gambar' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <x-atoms.title text="Informasi Dasar" size="md" />
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-molecules.input-field
                            label="Nama Test"
                            name="nama_test"
                            wire:model.lazy="nama_test"
                            placeholder="Masukan nama test"
                            :required="true"
                            :error="$errors->first('nama_test')"
                        />

                        <div>
                            <x-atoms.label for="mapel">
                                Mapel
                            </x-atoms.label>
                            <input type="text" id="mapel" value="{{ $mapelName }}" readonly
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-500">Mapel otomatis sesuai dengan badge Anda</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <x-atoms.label for="status">
                                Status
                                <span class="text-red-500">*</span>
                            </x-atoms.label>
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

                    <x-molecules.textarea-field
                        label="Deskripsi"
                        name="deskripsi"
                        wire:model.lazy="deskripsi"
                        placeholder="Masukan deskripsi test (opsional)"
                        :rows="3"
                        :error="$errors->first('deskripsi')"
                    />
                </div>

                <!-- Questions Section -->
                <div class="border-t pt-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <x-atoms.title text="Soal-soal Test" size="lg" />
                            <x-atoms.description size="sm" color="gray-500">
                                Tambahkan minimal 1 soal untuk test ini. Soal dapat dilengkapi dengan gambar.
                            </x-atoms.description>
                        </div>
                        <x-atoms.button
                            type="button"
                            wire:click="addQuestion"
                            variant="success"
                            theme="light"
                            size="sm"
                            heroicon="plus"
                            wire:loading.attr="disabled"
                        >
                            Tambah Soal
                        </x-atoms.button>
                    </div>

                    @if(empty($questions))
                        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                                    <x-heroicon-o-question-mark-circle class="w-6 h-6 text-gray-400" />
                                </div>
                                <x-atoms.title text="Belum ada soal" size="md" className="text-gray-500 mb-2" />
                                <x-atoms.description color="gray-400" class="mb-4">
                                    Klik "Tambah Soal" untuk menambahkan soal pertama
                                </x-atoms.description>
                                <x-atoms.button
                                    type="button"
                                    wire:click="addQuestion"
                                    variant="success"
                                    heroicon="plus"
                                    size="sm"
                                >
                                    Tambah Soal Pertama
                                </x-atoms.button>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @foreach($questions as $index => $question)
                        <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm transition-all duration-200 hover:shadow-md" 
                             wire:key="question-{{ $index }}">
                            <!-- Question Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-lime-100 to-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-semibold text-lime-600">{{ $index + 1 }}</span>
                                    </div>
                                    <x-atoms.title text="Soal {{ $index + 1 }}" size="md" />
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            @click="toggleQuestionHelper({{ $index }})"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <x-heroicon-o-question-mark-circle class="w-5 h-5" />
                                    </button>
                                    @if(count($questions) > 1)
                                        <x-atoms.button
                                            type="button"
                                            wire:click="removeQuestion({{ $index }})"
                                            wire:confirm="Yakin ingin menghapus soal ini?"
                                            variant="danger"
                                            theme="light"
                                            size="sm"
                                            heroicon="trash"
                                            className="!p-2"
                                        />
                                    @endif
                                </div>
                            </div>

                            <!-- Helper Text -->
                            <div x-show="showQuestionHelper[{{ $index }}]" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <x-atoms.description size="sm" color="blue-700">
                                    <strong>Text Area:</strong> Untuk jawaban essay yang perlu direview manual oleh admin.<br>
                                    <strong>Radio Button:</strong> Untuk pilihan ganda dengan jawaban pasti benar/salah.<br>
                                    <strong>Gambar:</strong> Opsional, dapat menambahkan gambar untuk memperjelas soal (max 2MB).
                                </x-atoms.description>
                            </div>

                            <div class="space-y-6">
                                <!-- Question Text -->
                                <x-molecules.textarea-field
                                    label="Pertanyaan"
                                    name="questions.{{ $index }}.pertanyaan"
                                    wire:model.lazy="questions.{{ $index }}.pertanyaan"
                                    placeholder="Masukan pertanyaan"
                                    :rows="3"
                                    :required="true"
                                    :error="$errors->first('questions.' . $index . '.pertanyaan')"
                                />

                                <!-- Image Upload Section -->
                                <div>
                                    <x-atoms.label for="image-{{ $index }}">
                                        Gambar Soal (Opsional)
                                    </x-atoms.label>
                                    
                                    @php
                                        $hasExistingImage = isset($question['existing_image']) && $question['existing_image'];
                                        $hasUploadedImage = isset($questionImages[$index]) && $questionImages[$index];
                                    @endphp

                                    @if($hasExistingImage || $hasUploadedImage)
                                        <!-- Image Preview -->
                                        <div class="mt-2 relative">
                                            @if($hasUploadedImage)
                                                <!-- New uploaded image -->
                                                <div class="relative inline-block">
                                                    <img src="{{ $questionImages[$index]->temporaryUrl() }}" 
                                                         alt="Preview" 
                                                         class="max-w-xs max-h-48 rounded-lg border border-gray-200 shadow-sm">
                                                    <button type="button"
                                                            wire:click="removeQuestionImage({{ $index }})"
                                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors">
                                                        <x-heroicon-o-x-mark class="w-4 h-4" />
                                                    </button>
                                                </div>
                                                <p class="text-sm text-green-600 mt-1">✓ Gambar baru akan diupload</p>
                                            @elseif($hasExistingImage)
                                                <!-- Existing image -->
                                                <div class="relative inline-block">
                                                    <img src="{{ asset('storage/' . $question['existing_image']) }}" 
                                                         alt="Existing image" 
                                                         class="max-w-xs max-h-48 rounded-lg border border-gray-200 shadow-sm">
                                                    <button type="button"
                                                            wire:click="removeQuestionImage({{ $index }})"
                                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors">
                                                        <x-heroicon-o-x-mark class="w-4 h-4" />
                                                    </button>
                                                </div>
                                                <p class="text-sm text-blue-600 mt-1">📷 Gambar saat ini</p>
                                            @endif
                                        </div>
                                    @else
                                        <!-- Upload Area -->
                                        <div class="mt-2">
                                            <div 
                                                @drop="handleDrop($event, {{ $index }})"
                                                @dragover="handleDragOver($event, {{ $index }})"
                                                @dragleave="handleDragLeave($event, {{ $index }})"
                                                :class="dragOver[{{ $index }}] ? 'border-lime-500 bg-lime-50' : 'border-gray-300'"
                                                class="border-2 border-dashed rounded-lg p-6 text-center transition-all duration-200 hover:border-lime-400 hover:bg-lime-50">
                                                <div class="flex flex-col items-center">
                                                    <x-heroicon-o-photo class="w-12 h-12 text-gray-400 mb-3" />
                                                    <p class="text-sm text-gray-600 mb-2">
                                                        Drag & drop gambar di sini atau 
                                                        <label class="text-lime-600 hover:text-lime-700 cursor-pointer font-medium">
                                                            pilih file
                                                            <input type="file" 
                                                                   wire:model="questionImages.{{ $index }}"
                                                                   accept="image/*"
                                                                   class="hidden">
                                                        </label>
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        PNG, JPG, GIF hingga 2MB
                                                    </p>
                                                </div>
                                                
                                                <!-- Upload Progress -->
                                                <div wire:loading wire:target="questionImages.{{ $index }}" class="mt-3">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <div class="animate-spin rounded-full h-4 w-4 border-2 border-lime-500 border-t-transparent"></div>
                                                        <span class="text-sm text-lime-600">Mengupload...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @error('questionImages.' . $index)
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Question Type -->
                                <div>
                                    <x-atoms.label for="tipe-soal-{{ $index }}">
                                        Tipe Soal
                                        <span class="text-red-500">*</span>
                                    </x-atoms.label>
                                    <div class="flex items-center gap-6 mt-2">
                                        <label class="flex items-center cursor-pointer p-3 border rounded-lg hover:bg-gray-50 transition-colors {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'text' ? 'border-lime-500 bg-lime-50' : 'border-gray-200' }}">
                                            <input type="radio" 
                                                   wire:click="updateQuestionType({{ $index }}, 'text')"
                                                   value="text" 
                                                   {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'text' ? 'checked' : '' }}
                                                   class="text-lime-600 focus:ring-lime-500 mr-3">
                                            <div>
                                                <span class="text-sm font-medium">Text Area</span>
                                                <p class="text-xs text-gray-500">Jawaban essay</p>
                                            </div>
                                        </label>
                                        <label class="flex items-center cursor-pointer p-3 border rounded-lg hover:bg-gray-50 transition-colors {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'radio' ? 'border-lime-500 bg-lime-50' : 'border-gray-200' }}">
                                            <input type="radio" 
                                                   wire:click="updateQuestionType({{ $index }}, 'radio')"
                                                   value="radio" 
                                                   {{ isset($question['tipe_soal']) && $question['tipe_soal'] === 'radio' ? 'checked' : '' }}
                                                   class="text-lime-600 focus:ring-lime-500 mr-3">
                                            <div>
                                                <span class="text-sm font-medium">Radio Button</span>
                                                <p class="text-xs text-gray-500">Pilihan ganda</p>
                                            </div>
                                        </label>
                                    </div>
                                    @error('questions.' . $index . '.tipe_soal')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Radio Options -->
                                @if(isset($question['tipe_soal']) && $question['tipe_soal'] === 'radio')
                                <div x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100">
                                    <x-atoms.label for="options-{{ $index }}">
                                        Pilihan Jawaban
                                        <span class="text-red-500">*</span>
                                    </x-atoms.label>
                                    
                                    <div class="space-y-3 mt-2">
                                        @if(isset($question['options']) && is_array($question['options']))
                                        @foreach($question['options'] as $optionIndex => $option)
                                        <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border transition-all duration-150 hover:bg-gray-100"
                                             wire:key="option-{{ $index }}-{{ $optionIndex }}">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0 border">
                                                <span class="text-sm font-medium text-gray-600">{{ chr(65 + $optionIndex) }}</span>
                                            </div>
                                            <x-atoms.input
                                                type="text"
                                                wire:model.lazy="questions.{{ $index }}.options.{{ $optionIndex }}"
                                                placeholder="Opsi {{ chr(65 + $optionIndex) }}"
                                                className="flex-1"
                                            />
                                            @if(count($question['options']) > 2)
                                            <x-atoms.button
                                                type="button"
                                                wire:click="removeOption({{ $index }}, {{ $optionIndex }})"
                                                variant="danger"
                                                theme="light"
                                                size="sm"
                                                heroicon="trash"
                                                className="!p-2"
                                            />
                                            @endif
                                        </div>
                                        @endforeach
                                        @endif
                                        
                                        @if(!isset($question['options']) || count($question['options']) < 5)
                                        <x-atoms.button
                                            type="button"
                                            wire:click="addOption({{ $index }})"
                                            variant="ghost"
                                            theme="dark"
                                            size="sm"
                                            heroicon="plus"
                                            className="w-full border-2 border-dashed border-gray-300 hover:border-lime-400 transition-colors"
                                        >
                                            Tambah Opsi
                                        </x-atoms.button>
                                        @endif
                                    </div>
                                    @error('questions.' . $index . '.options')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror

                                    <!-- Correct Answer Selection -->
                                    <div class="mt-4">
                                        <x-atoms.label for="jawaban-benar-{{ $index }}">
                                            Jawaban Benar
                                            <span class="text-red-500">*</span>
                                        </x-atoms.label>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            @if(isset($question['options']) && is_array($question['options']))
                                            @foreach($question['options'] as $optionIndex => $option)
                                            @if(!empty(trim($option)))
                                            <label class="flex items-center gap-2 cursor-pointer p-3 bg-white rounded-lg border hover:border-lime-300 transition-all duration-150 {{ isset($question['jawaban_benar']) && $question['jawaban_benar'] === chr(65 + $optionIndex) ? 'border-lime-500 bg-lime-50' : '' }}">
                                                <input type="radio" 
                                                       wire:model.lazy="questions.{{ $index }}.jawaban_benar" 
                                                       value="{{ chr(65 + $optionIndex) }}" 
                                                       class="text-lime-600 focus:ring-lime-500">
                                                <span class="text-sm font-medium">{{ chr(65 + $optionIndex) }}</span>
                                                <span class="text-xs text-gray-500 max-w-[100px] truncate">{{ $option }}</span>
                                            </label>
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                        @if(isset($question['jawaban_benar']) && $question['jawaban_benar'])
                                        <div class="mt-2 p-2 bg-lime-50 rounded-lg border border-lime-200">
                                            <x-atoms.description size="sm" color="lime-700">
                                                ✓ Jawaban yang dipilih: <span class="font-medium">{{ $question['jawaban_benar'] }}</span>
                                            </x-atoms.description>
                                        </div>
                                        @endif
                                        @error('questions.' . $index . '.jawaban_benar')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
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
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >
                            <span wire:loading.remove wire:target="save">
                                {{ $editMode ? 'Perbarui Test' : 'Simpan Test' }}
                            </span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                                {{ $editMode ? 'Memperbarui...' : 'Menyimpan...' }}
                            </span>
                        </x-atoms.button>
                        
                        <x-atoms.button
                            type="button"
                            wire:click="closeModal"
                            variant="ghost"
                            theme="dark"
                            heroicon="x-mark"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >
                            Batal
                        </x-atoms.button>
                    </div>
                </div>
            </form>
        </div>
    </x-atoms.modal>

    <!-- Loading Overlay -->
    <div wire:loading.flex wire:target="save" 
         class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3 shadow-xl">
            <div class="animate-spin rounded-full h-6 w-6 border-2 border-indigo-600 border-t-transparent"></div>
            <span class="text-gray-700">
                {{ $editMode ? 'Memperbarui custom test...' : 'Menyimpan custom test...' }}
            </span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toast notifications
    window.addEventListener('success', event => {
        console.log('Success:', event.detail.message);
    });
    
    window.addEventListener('error', event => {
        console.log('Error:', event.detail.message);
    });

    // Prevent default drag behaviors
    document.addEventListener('dragover', (e) => e.preventDefault());
    document.addEventListener('drop', (e) => e.preventDefault());
</script>
@endpush