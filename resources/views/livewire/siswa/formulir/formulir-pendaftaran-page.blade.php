<div class="px-4 sm:px-0">
    <x-atoms.breadcrumb current-path="Pilihan Program Studi" />

    <!-- Info Jalur yang Sudah Dipilih -->
    @if($selectedJalur)
    <x-atoms.card className="mt-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <x-heroicon-o-academic-cap class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" />
                </div>
                <div>
                    <x-atoms.title text="Jalur Pendaftaran Terpilih" size="lg" className="text-blue-900 text-base sm:text-lg" />
                    <x-atoms.title text="{{ $selectedJalur->nama }}" size="md" className="text-blue-800 mt-1 text-sm sm:text-base" />
                </div>
            </div>
            <x-atoms.badge text="LOCKED" variant="sky" size="sm" />
        </div>
    </x-atoms.card>
    @endif

    <!-- Form Program Studi -->
    @if(!$selectedJalur || count($pendaftaranList) < 1 || $editingId)
        @if ($gelombangActive && $gelombangActive->isPendaftaranAktif())
        <x-atoms.card className="mt-4">
            <x-atoms.title
                :text="$editingId ? 'Edit Program Studi' : ($selectedJalur ? 'Tambah Program Studi' : 'Pilihan Pendaftaran')"
                size="xl"
                class="mb-4 sm:mb-6 text-xl sm:text-2xl" />

            @if(!$editingId && $selectedJalur && count($pendaftaranList) >= 1)
            <div class="mb-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-md flex items-start gap-2">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <span class="text-sm">Anda sudah memilih 1 program studi. Hanya dapat memilih 1 program studi saja.</span>
            </div>
            @endif

            <!-- Warning untuk pemilihan jalur -->
            @if(!$selectedJalur)
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start gap-2 sm:gap-3">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 mt-0.5 flex-shrink-0" />
                    <div>
                        <x-atoms.title text="PERINGATAN PENTING!" size="sm" className="text-red-800 mb-2 font-bold text-sm sm:text-base" />
                        <div class="text-xs sm:text-sm text-red-700 space-y-1">
                            <p>• Pilih jalur pendaftaran dengan hati-hati - tidak dapat diubah setelah ada program studi terpilih</p>
                            <p>• Anda hanya dapat memilih 1 (satu) program studi saja</p>
                            <p>• Pastikan jalur dan program studi sesuai dengan minat dan kemampuan Anda</p>
                            <p>• Keputusan ini bersifat FINAL</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-4 sm:space-y-6">
                <!-- Jalur Pendaftaran -->
                <x-molecules.select-field
                    label="Jalur Pendaftaran"
                    name="jalur_pendaftaran_id"
                    wire:model.live="jalur_pendaftaran_id"
                    :options="collect($jalurs)->map(fn($jalur) => [
                        'value' => $jalur->id,
                        'label' => $jalur->nama,
                    ])
                    ->prepend([
                        'value' => '',
                        'label' => 'Pilih Jalur',
                    ])
                    ->toArray()"
                    placeholder="Pilih Jalur Pendaftaran (TIDAK DAPAT DIUBAH)"
                    :error="$errors->first('jalur_pendaftaran_id')"
                    :disabled="$selectedJalur && !$editingId"
                    required />

                @if($selectedJalur && !$editingId)
                <div class="text-xs sm:text-sm text-gray-600 bg-gray-50 p-3 rounded-lg flex items-start gap-2">
                    <x-heroicon-o-information-circle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                    <span>Jalur pendaftaran sudah terpilih dan tidak dapat diubah. Silakan pilih program studi dibawah ini.</span>
                </div>
                @endif

                <!-- Tipe Sekolah -->
                @php
                $tipeOptions = [];
                if($jalur_pendaftaran_id && $tipes->count() > 0) {
                $tipeOptions = collect($tipes)->map(fn($tipe) => [
                'value' => $tipe->id,
                'label' => $tipe->nama
                ])->prepend([
                'value' => '',
                'label' => 'Pilih Jenjang Sekolah',
                ])->toArray();
                }
                @endphp

                <x-molecules.select-field
                    label="Jenjang Sekolah"
                    name="tipe_sekolah_id"
                    wire:model.live="tipe_sekolah_id"
                    :options="$tipeOptions"
                    :placeholder="!$jalur_pendaftaran_id ? 'Pilih jalur pendaftaran terlebih dahulu' : 'Pilih Jenjang Sekolah'"
                    :error="$errors->first('tipe_sekolah_id')"
                    :disabled="!$jalur_pendaftaran_id"
                    required />

                <!-- Jurusan -->
                @php
                $jurusanOptions = [];
                if($tipe_sekolah_id && $jurusans->count() > 0) {
                $jurusanOptions = collect($jurusans)->map(fn($jurusan) => [
                'value' => $jurusan->id,
                'label' => $jurusan->nama
                ])->prepend([
                'value' => '',
                'label' => 'Pilih Jurusan',])
                ->toArray();
                }

                $jurusanPlaceholder = !$tipe_sekolah_id
                ? 'Pilih jenjang sekolah terlebih dahulu'
                : ($jurusanOptions ? 'Pilih Program Studi / Jurusan' : 'Tidak ada jurusan tersedia');
                @endphp

                <x-molecules.select-field
                    label="Program Studi / Jurusan"
                    name="jurusan_id"
                    wire:model.live="jurusan_id"
                    :options="$jurusanOptions"
                    :placeholder="$jurusanPlaceholder"
                    :error="$errors->first('jurusan_id')"
                    :disabled="!$tipe_sekolah_id"
                    required />

                <!-- Upload Bukti Prestasi - Hanya untuk Jalur Prestasi -->
                @if($isJalurPrestasi)
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-lg p-4 sm:p-6 border-2 border-yellow-300">
                    <div class="mb-4 sm:mb-5">
                        <div class="flex items-start gap-2 sm:gap-3 mb-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <x-heroicon-o-trophy class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-900" />
                            </div>
                            <div class="flex-1">
                                <x-atoms.title text="Upload Bukti Prestasi" size="lg" className="text-yellow-900 text-base sm:text-lg" />
                                <x-atoms.description size="sm" color="yellow-700" class="text-xs sm:text-sm">
                                    Upload maksimal 3 file bukti prestasi Anda (Opsional)
                                </x-atoms.description>
                            </div>
                        </div>
                        <div class="p-3 bg-yellow-100 border border-yellow-300 rounded-lg">
                            <div class="flex items-start gap-2">
                                <x-heroicon-o-information-circle class="w-4 h-4 text-yellow-700 mt-0.5 flex-shrink-0" />
                                <div class="text-xs text-yellow-700">
                                    <p class="font-medium mb-1">Format file yang diterima:</p>
                                    <ul class="list-disc ml-4 space-y-0.5">
                                        <li>PDF, JPG, JPEG, atau PNG</li>
                                        <li>Maksimal 2MB per file</li>
                                        <li>Berisi sertifikat atau penghargaan prestasi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Files when editing -->
                    @if($editingId && count($existing_bukti_prestasi) > 0)
                    <div class="mb-4 p-3 bg-white rounded-lg border border-yellow-200">
                        <div class="flex items-center gap-2 mb-2">
                            <x-heroicon-o-document-text class="w-4 h-4 text-yellow-700" />
                            <span class="text-xs font-medium text-yellow-900">File Yang Sudah Diupload</span>
                        </div>
                        <div class="space-y-2">
                            @foreach($existing_bukti_prestasi as $bukti)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 p-2 bg-yellow-50 rounded border border-yellow-200">
                                <div class="flex items-center gap-2 flex-1 min-w-0 w-full sm:w-auto">
                                    @if(in_array($bukti->file_type, ['jpg', 'jpeg', 'png']))
                                    <x-heroicon-o-photo class="w-4 h-4 text-blue-600 flex-shrink-0" />
                                    @else
                                    <x-heroicon-o-document-text class="w-4 h-4 text-red-600 flex-shrink-0" />
                                    @endif
                                    <a href="{{ Storage::url($bukti->file_path) }}"
                                        target="_blank"
                                        class="text-xs text-blue-700 hover:text-blue-900 hover:underline truncate flex-1">
                                        {{ $bukti->file_name }}
                                    </a>
                                    <span class="text-xs text-gray-500 flex-shrink-0">{{ number_format($bukti->file_size / 1024, 1) }} KB</span>
                                </div>
                                <button type="button"
                                    wire:click="removeExistingFile({{ $bukti->id }})"
                                    class="text-red-600 hover:text-red-800 p-1 flex-shrink-0">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- File Upload Slots -->
                    <div class="space-y-3">
                        <!-- File 1 -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-yellow-900 mb-1.5">
                                Bukti Prestasi 1 (Opsional)
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="file"
                                    wire:model="bukti_prestasi_1"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="flex-1 text-xs sm:text-sm text-gray-700 file:mr-3 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4
                                        file:rounded-md file:border-0 file:text-xs sm:file:text-sm file:font-medium
                                        file:bg-yellow-600 file:text-white hover:file:bg-yellow-700
                                        file:cursor-pointer border border-yellow-300 rounded-md
                                        focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                                @if($bukti_prestasi_1)
                                <button type="button"
                                    wire:click="removeBuktiFile(1)"
                                    class="px-3 py-1.5 sm:py-2 text-xs sm:text-sm bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center gap-1.5 flex-shrink-0 w-full sm:w-auto">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    <span>Hapus</span>
                                </button>
                                @endif
                            </div>
                            @error('bukti_prestasi_1')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                            @if($bukti_prestasi_1)
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-yellow-700">
                                <x-heroicon-o-check-circle class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>{{ $bukti_prestasi_1->getClientOriginalName() }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- File 2 -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-yellow-900 mb-1.5">
                                Bukti Prestasi 2 (Opsional)
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="file"
                                    wire:model="bukti_prestasi_2"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="flex-1 text-xs sm:text-sm text-gray-700 file:mr-3 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4
                                        file:rounded-md file:border-0 file:text-xs sm:file:text-sm file:font-medium
                                        file:bg-yellow-600 file:text-white hover:file:bg-yellow-700
                                        file:cursor-pointer border border-yellow-300 rounded-md
                                        focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                                @if($bukti_prestasi_2)
                                <button type="button"
                                    wire:click="removeBuktiFile(2)"
                                    class="px-3 py-1.5 sm:py-2 text-xs sm:text-sm bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center gap-1.5 flex-shrink-0 w-full sm:w-auto">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    <span>Hapus</span>
                                </button>
                                @endif
                            </div>
                            @error('bukti_prestasi_2')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                            @if($bukti_prestasi_2)
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-yellow-700">
                                <x-heroicon-o-check-circle class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>{{ $bukti_prestasi_2->getClientOriginalName() }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- File 3 -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-yellow-900 mb-1.5">
                                Bukti Prestasi 3 (Opsional)
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="file"
                                    wire:model="bukti_prestasi_3"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="flex-1 text-xs sm:text-sm text-gray-700 file:mr-3 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4
                                        file:rounded-md file:border-0 file:text-xs sm:file:text-sm file:font-medium
                                        file:bg-yellow-600 file:text-white hover:file:bg-yellow-700
                                        file:cursor-pointer border border-yellow-300 rounded-md
                                        focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                                @if($bukti_prestasi_3)
                                <button type="button"
                                    wire:click="removeBuktiFile(3)"
                                    class="px-3 py-1.5 sm:py-2 text-xs sm:text-sm bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center gap-1.5 flex-shrink-0 w-full sm:w-auto">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    <span>Hapus</span>
                                </button>
                                @endif
                            </div>
                            @error('bukti_prestasi_3')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                            @if($bukti_prestasi_3)
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-yellow-700">
                                <x-heroicon-o-check-circle class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>{{ $bukti_prestasi_3->getClientOriginalName() }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div wire:loading wire:target="bukti_prestasi_1,bukti_prestasi_2,bukti_prestasi_3" class="mt-3 flex items-center gap-2 text-xs text-yellow-700">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Mengupload file...</span>
                    </div>
                </div>
                @endif

                <!-- Upload Bukti Tahfidz - Hanya untuk Jalur Tahfidz Quran -->
                @if($isJalurTahfidz)
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 sm:p-6 border-2 border-green-300">
                    <div class="mb-4 sm:mb-5">
                        <div class="flex items-start gap-2 sm:gap-3 mb-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <x-heroicon-o-book-open class="w-5 h-5 sm:w-6 sm:h-6 text-green-900" />
                            </div>
                            <div class="flex-1">
                                <x-atoms.title text="Upload Bukti Tahfidz" size="lg" className="text-green-900 text-base sm:text-lg" />
                                <x-atoms.description size="sm" color="green-700" class="text-xs sm:text-sm">
                                    Upload maksimal 3 file bukti tahfidz Qur'an Anda (Opsional)
                                </x-atoms.description>
                            </div>
                        </div>
                        <div class="p-3 bg-green-100 border border-green-300 rounded-lg">
                            <div class="flex items-start gap-2">
                                <x-heroicon-o-information-circle class="w-4 h-4 text-green-700 mt-0.5 flex-shrink-0" />
                                <div class="text-xs text-green-700">
                                    <p class="font-medium mb-1">Format file yang diterima:</p>
                                    <ul class="list-disc ml-4 space-y-0.5">
                                        <li>PDF, JPG, JPEG, atau PNG</li>
                                        <li>Maksimal 2MB per file</li>
                                        <li>Berisi sertifikat atau syahadah tahfidz</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Files when editing -->
                    @if($editingId && count($existing_bukti_tahfidz) > 0)
                    <div class="mb-4 p-3 bg-white rounded-lg border border-green-200">
                        <div class="flex items-center gap-2 mb-2">
                            <x-heroicon-o-document-text class="w-4 h-4 text-green-700" />
                            <span class="text-xs font-medium text-green-900">File Yang Sudah Diupload</span>
                        </div>
                        <div class="space-y-2">
                            @foreach($existing_bukti_tahfidz as $bukti)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 p-2 bg-green-50 rounded border border-green-200">
                                <div class="flex items-center gap-2 flex-1 min-w-0 w-full sm:w-auto">
                                    @if(in_array($bukti->file_type, ['jpg', 'jpeg', 'png']))
                                    <x-heroicon-o-photo class="w-4 h-4 text-blue-600 flex-shrink-0" />
                                    @else
                                    <x-heroicon-o-document-text class="w-4 h-4 text-red-600 flex-shrink-0" />
                                    @endif
                                    <a href="{{ Storage::url($bukti->file_path) }}"
                                        target="_blank"
                                        class="text-xs text-blue-700 hover:text-blue-900 hover:underline truncate flex-1">
                                        {{ $bukti->file_name }}
                                    </a>
                                    <span class="text-xs text-gray-500 flex-shrink-0">{{ number_format($bukti->file_size / 1024, 1) }} KB</span>
                                </div>
                                <button type="button"
                                    wire:click="removeExistingFileTahfidz({{ $bukti->id }})"
                                    class="text-red-600 hover:text-red-800 p-1 flex-shrink-0">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- File Upload Slots -->
                    <div class="space-y-3">
                        <!-- File 1 -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-green-900 mb-1.5">
                                Bukti Tahfidz 1 (Opsional)
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="file"
                                    wire:model="bukti_tahfidz_1"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="flex-1 text-xs sm:text-sm text-gray-700 file:mr-3 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4
                                        file:rounded-md file:border-0 file:text-xs sm:file:text-sm file:font-medium
                                        file:bg-green-600 file:text-white hover:file:bg-green-700
                                        file:cursor-pointer border border-green-300 rounded-md
                                        focus:outline-none focus:ring-2 focus:ring-green-500" />
                                @if($bukti_tahfidz_1)
                                <button type="button"
                                    wire:click="removeBuktiFileTahfidz(1)"
                                    class="px-3 py-1.5 sm:py-2 text-xs sm:text-sm bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center gap-1.5 flex-shrink-0 w-full sm:w-auto">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    <span>Hapus</span>
                                </button>
                                @endif
                            </div>
                            @error('bukti_tahfidz_1')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                            @if($bukti_tahfidz_1)
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-green-700">
                                <x-heroicon-o-check-circle class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>{{ $bukti_tahfidz_1->getClientOriginalName() }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- File 2 -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-green-900 mb-1.5">
                                Bukti Tahfidz 2 (Opsional)
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="file"
                                    wire:model="bukti_tahfidz_2"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="flex-1 text-xs sm:text-sm text-gray-700 file:mr-3 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4
                                        file:rounded-md file:border-0 file:text-xs sm:file:text-sm file:font-medium
                                        file:bg-green-600 file:text-white hover:file:bg-green-700
                                        file:cursor-pointer border border-green-300 rounded-md
                                        focus:outline-none focus:ring-2 focus:ring-green-500" />
                                @if($bukti_tahfidz_2)
                                <button type="button"
                                    wire:click="removeBuktiFileTahfidz(2)"
                                    class="px-3 py-1.5 sm:py-2 text-xs sm:text-sm bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center gap-1.5 flex-shrink-0 w-full sm:w-auto">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    <span>Hapus</span>
                                </button>
                                @endif
                            </div>
                            @error('bukti_tahfidz_2')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                            @if($bukti_tahfidz_2)
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-green-700">
                                <x-heroicon-o-check-circle class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>{{ $bukti_tahfidz_2->getClientOriginalName() }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- File 3 -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-green-900 mb-1.5">
                                Bukti Tahfidz 3 (Opsional)
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="file"
                                    wire:model="bukti_tahfidz_3"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="flex-1 text-xs sm:text-sm text-gray-700 file:mr-3 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4
                                        file:rounded-md file:border-0 file:text-xs sm:file:text-sm file:font-medium
                                        file:bg-green-600 file:text-white hover:file:bg-green-700
                                        file:cursor-pointer border border-green-300 rounded-md
                                        focus:outline-none focus:ring-2 focus:ring-green-500" />
                                @if($bukti_tahfidz_3)
                                <button type="button"
                                    wire:click="removeBuktiFileTahfidz(3)"
                                    class="px-3 py-1.5 sm:py-2 text-xs sm:text-sm bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center gap-1.5 flex-shrink-0 w-full sm:w-auto">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    <span>Hapus</span>
                                </button>
                                @endif
                            </div>
                            @error('bukti_tahfidz_3')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                            @if($bukti_tahfidz_3)
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-green-700">
                                <x-heroicon-o-check-circle class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>{{ $bukti_tahfidz_3->getClientOriginalName() }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div wire:loading wire:target="bukti_tahfidz_1,bukti_tahfidz_2,bukti_tahfidz_3" class="mt-3 flex items-center gap-2 text-xs text-green-700">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Mengupload file...</span>
                    </div>
                </div>
                @endif

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-2">
                    <x-atoms.button
                        variant="primary"
                        type="submit"
                        heroicon="check"
                        className="w-full sm:w-auto">
                        {{ $editingId ? 'Update Program Studi' : 'Simpan Program Studi' }}
                    </x-atoms.button>

                    @if($editingId)
                    <x-atoms.button
                        variant="secondary"
                        type="button"
                        wire:click="resetForm"
                        heroicon="x-mark"
                        className="w-full sm:w-auto">
                        Batal Edit
                    </x-atoms.button>
                    @endif
                </div>
            </form>
        </x-atoms.card>
        @else
        <x-atoms.card className="mt-4">
            <div class="p-6 sm:p-8 text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-clock class="w-8 h-8 sm:w-10 sm:h-10 text-red-600" />
                </div>
                <x-atoms.title
                    text="Pendaftaran Ditutup"
                    size="xl"
                    align="center"
                    class="mb-3 text-gray-900 text-lg sm:text-xl" />
                <x-atoms.description align="center" color="gray-600" class="max-w-md mx-auto text-xs sm:text-sm">
                    Pendaftaran sudah ditutup atau belum dibuka. Silakan tunggu periode pendaftaran berikutnya.
                </x-atoms.description>
            </div>
        </x-atoms.card>
        @endif
    @endif

    <!-- Daftar Program Studi yang Sudah Dipilih -->
    @if($pendaftaranList->count() > 0)
    <x-atoms.card className="mt-4">
        <x-atoms.title text="Program Studi Terpilih" size="xl" className="mb-4 sm:mb-6 text-xl sm:text-2xl" />
        
        <div class="space-y-4">
            @foreach($pendaftaranList as $pendaftaran)
            <div class="border border-gray-200 rounded-lg p-4 sm:p-5 bg-white hover:shadow-md transition-shadow">
                <div class="flex flex-col lg:flex-row lg:items-start gap-4 lg:gap-6">
                    <div class="flex-1 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <x-heroicon-o-academic-cap class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" />
                                </div>
                                <div class="flex-1">
                                    <x-atoms.title text="{{ $pendaftaran->jurusan->nama }}" size="lg" className="text-gray-900 text-base sm:text-lg" />
                                    <x-atoms.description size="sm" color="gray-600" class="text-xs sm:text-sm">
                                        {{ $pendaftaran->tipeSekolah->nama }}
                                    </x-atoms.description>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm">
                            <div class="flex items-center gap-2">
                                <x-heroicon-o-clipboard-document-check class="w-4 h-4 text-gray-400 flex-shrink-0" />
                                <span class="text-gray-600">
                                    <span class="font-medium text-gray-700">Jalur:</span> {{ $pendaftaran->jalurPendaftaran->nama }}
                                </span>
                            </div>
                        </div>

                        <!-- Bukti Prestasi yang Sudah Diupload -->
                        @if($pendaftaran->buktiPrestasis && count($pendaftaran->buktiPrestasis) > 0)
                        <div class="pt-2 border-t border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <x-heroicon-o-trophy class="w-4 h-4 text-yellow-600" />
                                <span class="text-xs font-medium text-gray-700">Bukti Prestasi Terlampir:</span>
                            </div>
                            <div class="space-y-1.5">
                                @foreach($pendaftaran->buktiPrestasis as $bukti)
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 p-2 bg-yellow-50 rounded border border-yellow-100">
                                    <div class="flex items-center gap-2 flex-1 min-w-0 w-full sm:w-auto">
                                        @if(in_array($bukti->file_type, ['jpg', 'jpeg', 'png']))
                                        <x-heroicon-o-photo class="w-4 h-4 text-blue-600 flex-shrink-0" />
                                        @else
                                        <x-heroicon-o-document-text class="w-4 h-4 text-red-600 flex-shrink-0" />
                                        @endif
                                        <a href="{{ Storage::url($bukti->file_path) }}"
                                            target="_blank"
                                            class="text-xs text-blue-700 hover:text-blue-900 hover:underline truncate flex-1">
                                            {{ $bukti->file_name }}
                                        </a>
                                    </div>
                                    <span class="text-xs text-gray-500 flex-shrink-0">{{ number_format($bukti->file_size / 1024, 1) }} KB</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Bukti Tahfidz yang Sudah Diupload -->
                        @if($pendaftaran->buktiTahfidzs && count($pendaftaran->buktiTahfidzs) > 0)
                        <div class="pt-2 border-t border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <x-heroicon-o-book-open class="w-4 h-4 text-green-600" />
                                <span class="text-xs font-medium text-gray-700">Bukti Tahfidz Terlampir:</span>
                            </div>
                            <div class="space-y-1.5">
                                @foreach($pendaftaran->buktiTahfidzs as $bukti)
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 p-2 bg-green-50 rounded border border-green-100">
                                    <div class="flex items-center gap-2 flex-1 min-w-0 w-full sm:w-auto">
                                        @if(in_array($bukti->file_type, ['jpg', 'jpeg', 'png']))
                                        <x-heroicon-o-photo class="w-4 h-4 text-blue-600 flex-shrink-0" />
                                        @else
                                        <x-heroicon-o-document-text class="w-4 h-4 text-red-600 flex-shrink-0" />
                                        @endif
                                        <a href="{{ Storage::url($bukti->file_path) }}"
                                            target="_blank"
                                            class="text-xs text-blue-700 hover:text-blue-900 hover:underline truncate flex-1">
                                            {{ $bukti->file_name }}
                                        </a>
                                    </div>
                                    <span class="text-xs text-gray-500 flex-shrink-0">{{ number_format($bukti->file_size / 1024, 1) }} KB</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 mt-3">
                            @if($pendaftaran->status == 'pending')
                            <x-atoms.badge text="Pending" variant="gold" size="sm" />
                            @elseif($pendaftaran->status == 'diterima')
                            <x-atoms.badge text="Diterima" variant="emerald" size="sm" />
                            @else
                            <x-atoms.badge text="Ditolak" variant="danger" size="sm" />
                            @endif

                            <x-atoms.description size="xs" color="gray-500" class="text-xs">
                                Daftar: {{ $pendaftaran->created_at->format('d M Y') }}
                            </x-atoms.description>
                        </div>
                    </div>

                    @if($pendaftaran->status == 'pending' && $gelombangActive && $gelombangActive->isPendaftaranAktif())
                    <div class="flex gap-2 w-full lg:w-auto lg:flex-shrink-0">
                        <x-atoms.button
                            variant="primary"
                            theme="light"
                            size="sm"
                            wire:click="edit({{ $pendaftaran->id }})"
                            heroicon="pencil"
                            className="flex-1 lg:flex-none">
                            Edit
                        </x-atoms.button>
                        <x-atoms.button
                            variant="danger"
                            theme="light"
                            size="sm"
                            wire:click="delete({{ $pendaftaran->id }})"
                            onclick="return confirm('Yakin ingin menghapus program studi ini?')"
                            heroicon="trash"
                            className="flex-1 lg:flex-none">
                            Hapus
                        </x-atoms.button>
                    </div>
                    @else
                    <x-atoms.description size="xs" color="gray-400" class="text-xs">
                        Tidak dapat diedit
                    </x-atoms.description>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-8 sm:p-12 text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 bg-indigo-100 rounded-full flex items-center justify-center">
                <x-heroicon-o-academic-cap class="w-8 h-8 sm:w-10 sm:h-10 text-indigo-600" />
            </div>
            <x-atoms.title
                text="Belum Ada Program Studi"
                size="xl"
                align="center"
                class="mb-3 text-gray-900 text-lg sm:text-xl" />
            <x-atoms.description align="center" color="gray-600" class="mb-4 sm:mb-6 max-w-md mx-auto text-xs sm:text-sm">
                Pilih jalur pendaftaran terlebih dahulu, kemudian pilih 1 program studi sesuai minat Anda.
            </x-atoms.description>

            <!-- Step Indicator -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center">
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500">
                    <span class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center text-xs font-medium text-indigo-600">1</span>
                    <span>Pilih Jalur</span>
                </div>
                <x-heroicon-o-arrow-right class="w-4 h-4 text-gray-400 hidden sm:block rotate-90 sm:rotate-0" />
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500">
                    <span class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs font-medium text-gray-400">2</span>
                    <span>Pilih Jenjang Sekolah</span>
                </div>
                <x-heroicon-o-arrow-right class="w-4 h-4 text-gray-400 hidden sm:block rotate-90 sm:rotate-0" />
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500">
                    <span class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs font-medium text-gray-400">3</span>
                    <span>Pilih Jurusan</span>
                </div>
            </div>
        </div>
        @endif
    </x-atoms.card>

    <!-- Info Panel -->
    @if($selectedJalur)
    <x-atoms.card className="mt-4 bg-blue-50 border border-blue-200">
        <div class="flex items-start gap-2 sm:gap-3">
            <x-heroicon-o-information-circle class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 mt-0.5 flex-shrink-0" />
            <div>
                <x-atoms.title text="Catatan Penting" size="sm" className="text-blue-900 mb-2 text-sm sm:text-base" />
                <div class="space-y-1 text-xs sm:text-sm text-blue-800">
                    <x-atoms.description size="sm" color="blue-800">
                        • Anda hanya dapat memilih 1 program studi dalam 1 jalur pendaftaran
                    </x-atoms.description>
                    <x-atoms.description size="sm" color="blue-800">
                        • Jalur pendaftaran tidak dapat diubah setelah ada program studi yang dipilih
                    </x-atoms.description>
                    <x-atoms.description size="sm" color="blue-800">
                        • Program studi dengan status selain "Pending" tidak dapat diedit atau dihapus
                    </x-atoms.description>
                    @if($isJalurPrestasi)
                    <x-atoms.description size="sm" color="blue-800">
                        • Upload bukti prestasi untuk memperkuat pendaftaran Anda (maksimal 3 file, opsional)
                    </x-atoms.description>
                    @endif
                    @if($isJalurTahfidz)
                    <x-atoms.description size="sm" color="blue-800">
                        • Upload bukti tahfidz untuk memperkuat pendaftaran Anda (maksimal 3 file, opsional)
                    </x-atoms.description>
                    @endif
                    <x-atoms.description size="sm" color="blue-800">
                        • Pastikan pilihan Anda sudah tepat karena keputusan bersifat FINAL
                    </x-atoms.description>
                </div>
            </div>
        </div>
    </x-atoms.card>
    @endif
</div>

@push('styles')
<style>
    /* Smooth transitions */
    .transition-colors {
        transition-property: color, background-color, border-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    
    /* Custom file input styling for mobile */
    @media (max-width: 640px) {
        input[type="file"]::file-selector-button {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }
    }
</style>
@endpush