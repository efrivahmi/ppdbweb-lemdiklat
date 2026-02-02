<div class="px-4 sm:px-0">
    <x-atoms.breadcrumb current-path="Berkas Siswa" />

    <x-atoms.card className="mt-4">
        <x-atoms.title
            text="Formulir Berkas Siswa"
            size="xl"
            class="mb-4 sm:mb-6 text-xl sm:text-2xl" />

        <!-- Progress bar -->
        <div class="w-full bg-gray-200 rounded-full h-2 sm:h-2.5 mb-3 sm:mb-4">
            <div class="bg-lime-600 h-2 sm:h-2.5 rounded-full transition-all duration-300"
                 style="width: {{ $this->progress }}%">
            </div>
        </div>
        <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-6">
            Progress: <span class="font-semibold">{{ $this->progress }}%</span>
        </p>

        <form wire:submit.prevent="update" enctype="multipart/form-data">
            @php
                $fields = [
                    ['label' => 'Kartu Keluarga (KK)', 'name' => 'kk', 'heroicon' => 'identification'],
                    ['label' => 'KTP Orang Tua', 'name' => 'ktp_ortu', 'heroicon' => 'identification'],
                    ['label' => 'Akte Kelahiran', 'name' => 'akte', 'heroicon' => 'document-text'],
                    ['label' => 'Surat Sehat', 'name' => 'surat_sehat', 'heroicon' => 'heart'],
                    ['label' => 'Pas Foto 3x4 (Latar Biru)', 'name' => 'pas_foto', 'heroicon' => 'camera'],
                ];
            @endphp

            <!-- Grid responsif untuk file fields -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                @foreach ($fields as $input)
                    @php
                        $file = optional(App\Models\Siswa\BerkasMurid::where('user_id', auth()->id())->first())
                            ->{$input['name']};
                    @endphp

                    <div class="w-full">
                        <x-molecules.file-field
                            :name="$input['name']"
                            :id="$input['name']"
                            :accept="$input['name'] === 'pas_foto' ? 'image/*' : '.pdf,.jpg,.jpeg,.png'"
                            maxSize="2MB"
                            wire:model.live="{{ $input['name'] }}"
                            :currentFile="${$input['name']}"
                            :required="!$file"
                            :error="$errors->first($input['name'])">
                            <x-slot name="label">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full gap-2 sm:gap-0">
                                    <!-- Label dengan icon -->
                                    <div class="flex items-center">
                                        <x-dynamic-component
                                            :component="'heroicon-o-' . $input['heroicon']"
                                            class="w-4 h-4 mr-1.5 sm:mr-2 text-lime-600 flex-shrink-0" />
                                        <span class="text-sm sm:text-base font-medium">{{ $input['label'] }}</span>
                                    </div>

                                    <!-- Status dan aksi -->
                                    @if ($file)
                                        <div class="flex items-center gap-2 ml-5 sm:ml-0">
                                            <!-- Status badge -->
                                            <div class="flex items-center gap-1 text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                                <x-heroicon-o-document-check class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                                <span class="font-medium">Uploaded</span>
                                            </div>
                                            
                                            <!-- Action buttons -->
                                            <div class="flex gap-1">
                                                <a href="{{ asset('storage/' . $file) }}"
                                                    target="_blank"
                                                    title="Lihat file"
                                                    class="text-lime-600 hover:text-lime-800 flex items-center text-xs p-1.5 sm:p-2 hover:bg-lime-50 rounded transition-colors">
                                                    <x-heroicon-o-eye class="w-4 h-4" />
                                                </a>
                                                <button type="button"
                                                    wire:click="deleteFile('{{ $input['name'] }}')"
                                                    onclick="return confirm('Yakin ingin menghapus file ini?')"
                                                    title="Hapus file"
                                                    class="text-red-600 hover:text-red-800 flex items-center text-xs p-1.5 sm:p-2 hover:bg-red-50 rounded transition-colors">
                                                    <x-heroicon-o-trash class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </x-slot>
                        </x-molecules.file-field>

                        <!-- Preview upload status di mobile -->
                        <div wire:loading wire:target="{{ $input['name'] }}" class="mt-2">
                            <div class="flex items-center gap-2 text-xs text-blue-600 bg-blue-50 px-3 py-2 rounded-lg">
                                <div class="animate-spin rounded-full h-3 w-3 border-b-2 border-blue-600"></div>
                                <span>Mengupload file...</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Informasi format file -->
            <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-2">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" />
                    <div class="text-xs sm:text-sm text-blue-800">
                        <p class="font-semibold mb-1">Informasi Penting:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Format file yang diterima: PDF, JPG, JPEG, PNG</li>
                            <li>Ukuran maksimal: 2MB per file</li>
                            <li>Untuk Pas Foto: gunakan latar belakang biru</li>
                            <li>Pastikan file terlihat jelas dan mudah dibaca</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tombol submit -->
            <div class="mt-4 sm:mt-6">
                <x-atoms.button
                    type="submit"
                    variant="success"
                    size="md"
                    class="w-full py-2.5 sm:py-3 text-sm sm:text-base"
                    heroicon="document-check"
                    iconPosition="left"
                    wire:loading.attr="disabled"
                    wire:target="update"
                    :disabled="!$this->isComplete">
                    <span wire:loading.remove wire:target="update" class="flex items-center justify-center gap-2">
                        <span>Simpan Berkas</span>
                    </span>
                    <span wire:loading wire:target="update" class="flex items-center justify-center gap-2">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        <span>Menyimpan...</span>
                    </span>
                </x-atoms.button>

                <!-- Pesan jika belum lengkap -->
                @if(!$this->isComplete)
                <p class="mt-2 text-xs sm:text-sm text-center text-amber-600">
                    <x-heroicon-o-exclamation-triangle class="w-4 h-4 inline mr-1" />
                    Lengkapi semua berkas untuk melanjutkan
                </p>
                @endif
            </div>
        </form>

        <!-- Daftar berkas yang diperlukan (mobile helper) -->
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg lg:hidden">
            <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <x-heroicon-o-clipboard-document-list class="w-5 h-5 text-gray-600" />
                Checklist Berkas
            </h3>
            <div class="space-y-2">
                @foreach ($fields as $field)
                    @php
                        $file = optional(App\Models\Siswa\BerkasMurid::where('user_id', auth()->id())->first())
                            ->{$field['name']};
                    @endphp
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-0">
                        <span class="text-xs text-gray-700">{{ $field['label'] }}</span>
                        @if($file)
                            <x-heroicon-o-check-circle class="w-5 h-5 text-green-600" />
                        @else
                            <x-heroicon-o-x-circle class="w-5 h-5 text-gray-400" />
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </x-atoms.card>
</div>

@push('styles')
<style>
    /* Custom styling untuk file input di mobile */
    @media (max-width: 640px) {
        input[type="file"]::file-selector-button {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }
    }
    
    /* Smooth transitions */
    .transition-colors {
        transition-property: color, background-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
@endpush