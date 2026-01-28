<div>
    <x-atoms.breadcrumb currentPath="Tes Jalur" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <x-atoms.title text="Tes Jalur" size="xl" />
                <x-atoms.description size="sm" color="gray-600">
                    Kelola tes untuk setiap jalur pendaftaran
                </x-atoms.description>
            </div>
            
            
        </div>

        <!-- Search and Filter -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <x-atoms.input
                        type="search"
                        wire:model.live="search"
                        placeholder="Cari tes jalur..."
                        className="w-full"
                    />
                </div>
                <div class="relative md:w-64">
                    <select wire:model.live="jalurFilter" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Jalur</option>
                        @foreach($jalurPendaftarans as $jalur)
                        <option value="{{ $jalur->id }}">{{ $jalur->nama }}</option>
                        @endforeach
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalur Pendaftaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custom Tests</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tesJalurs as $tes)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <x-atoms.title text="{{ $tes->nama_tes }}" size="sm" className="mb-1" />
                                    @if($tes->deskripsi)
                                    <x-atoms.description size="xs" color="gray-500">
                                        {{ Str::limit($tes->deskripsi, 50) }}
                                    </x-atoms.description>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <x-atoms.badge 
                                    text="{{ $tes->jalurPendaftaran->nama }}"
                                    variant="sky" 
                                    size="sm"
                                />
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <x-atoms.badge 
                                        text="{{ $tes->customTests->count() }} test"
                                        variant="emerald" 
                                        size="sm"
                                    />
                                    <x-atoms.button
                                        wire:click="manageCustomTests({{ $tes->id }})"
                                        variant="ghost"
                                        theme="dark"
                                        size="sm"
                                        heroicon="cog-6-tooth"
                                        className="!p-1 !min-h-[28px]"
                                    />
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1 text-sm text-gray-500">
                                    <x-heroicon-o-calendar-days class="w-4 h-4" />
                                    <span>{{ $tes->created_at->format('d M Y') }}</span>
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
                                        <x-atoms.title text="Belum ada data tes jalur" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400" class="mb-4">
                                            @if ($search || $jalurFilter)
                                                Tidak ditemukan data sesuai filter yang dipilih
                                            @else
                                                Mulai dengan menambahkan tes jalur untuk jalur pendaftaran
                                            @endif
                                        </x-atoms.description>
                                        @if (!$search && !$jalurFilter)
                                            <x-atoms.button
                                                wire:click="create"
                                                variant="success"
                                                heroicon="plus"
                                                size="sm"
                                            >
                                                Tambah Tes Jalur Pertama
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
            
            @if ($tesJalurs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $tesJalurs->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </x-atoms.card>

    {{-- Modal Form Tes Jalur --}}
    <x-atoms.modal name="tes-jalur" maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-document-text class="w-6 h-6 text-indigo-600" />
                </div>
                <div>
                    <x-atoms.title 
                        :text="$editMode ? 'Edit Tes Jalur' : 'Tambah Tes Jalur'" 
                        size="lg" 
                    />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data tes jalur' : 'Tambahkan tes jalur baru untuk jalur pendaftaran' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-5">
                <x-molecules.select-field
                    label="Jalur Pendaftaran"
                    name="jalur_pendaftaran_id"
                    wire:model="jalur_pendaftaran_id"
                    :options="collect($jalurPendaftarans)->map(fn($jalur) => ['value' => $jalur->id, 'label' => $jalur->nama])->toArray()"
                    placeholder="-- Pilih Jalur Pendaftaran --"
                    :required="true"
                    :error="$errors->first('jalur_pendaftaran_id')"
                />

                <x-molecules.input-field
                    label="Nama Tes"
                    name="nama_tes"
                    wire:model="nama_tes"
                    placeholder="Masukan nama tes"
                    :required="true"
                    :error="$errors->first('nama_tes')"
                />

                <x-molecules.textarea-field
                    label="Deskripsi"
                    name="deskripsi"
                    wire:model="deskripsi"
                    placeholder="Masukan deskripsi tes (opsional)"
                    :rows="3"
                    :error="$errors->first('deskripsi')"
                />

                <div>
                    <x-atoms.label for="custom-tests">
                        Custom Tests
                    </x-atoms.label>
                    <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg p-4 space-y-3 bg-gray-50">
                        @if($customTests->isEmpty())
                            <div class="text-center py-8">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <x-heroicon-o-document-text class="w-6 h-6 text-gray-400" />
                                </div>
                                <x-atoms.description color="gray-500">
                                    Belum ada custom test yang tersedia
                                </x-atoms.description>
                            </div>
                        @else
                            @foreach($customTests as $customTest)
                            <label class="flex items-start gap-3 cursor-pointer p-3 bg-white rounded-lg border border-gray-200 hover:border-lime-300 transition-colors">
                                <input type="checkbox" wire:model="selectedCustomTests" value="{{ $customTest->id }}" 
                                       class="mt-1 text-lime-600 focus:ring-lime-500 rounded">
                                <div class="flex-1">
                                    <x-atoms.title text="{{ $customTest->nama_test }}" size="sm" className="mb-1" />
                                    @if($customTest->deskripsi)
                                    <x-atoms.description size="xs" color="gray-600" className="mb-2">
                                        {{ Str::limit($customTest->deskripsi, 80) }}
                                    </x-atoms.description>
                                    @endif
                                    <div class="flex items-center gap-1">
                                        <x-atoms.badge 
                                            text="{{ $customTest->questions()->count() }} soal"
                                            variant="sky" 
                                            size="sm"
                                        />
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        @endif
                    </div>
                </div>

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
                                {{ $editMode ? 'Perbarui Tes' : 'Simpan Tes' }}
                            </span>
                            <span wire:loading wire:target="save">
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
                        >
                            Batal
                        </x-atoms.button>
                    </div>
                </div>
            </form>
        </div>
    </x-atoms.modal>

    {{-- Modal Custom Tests Management --}}
    <x-atoms.modal name="custom-tests" maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-cog-6-tooth class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <x-atoms.title text="Kelola Custom Tests" size="lg" />
                    <x-atoms.description size="sm" color="gray-500">
                        Pilih custom tests yang akan digunakan untuk tes jalur ini
                    </x-atoms.description>
                </div>
            </div>

            <div class="max-h-96 overflow-y-auto space-y-3">
                @if($customTests->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-heroicon-o-document-text class="w-8 h-8 text-gray-400" />
                        </div>
                        <x-atoms.title text="Belum ada custom test" size="md" className="text-gray-500 mb-2" />
                        <x-atoms.description color="gray-400">
                            Belum ada custom test yang tersedia di sistem
                        </x-atoms.description>
                    </div>
                @else
                    @foreach($customTests as $customTest)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-lime-300 transition-colors">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="selectedCustomTests" value="{{ $customTest->id }}" 
                                   class="mt-1 text-lime-600 focus:ring-lime-500 rounded">
                            <div class="flex-1">
                                <x-atoms.title text="{{ $customTest->nama_test }}" size="md" className="mb-2" />
                                @if($customTest->deskripsi)
                                <x-atoms.description size="sm" color="gray-600" className="mb-3">
                                    {{ $customTest->deskripsi }}
                                </x-atoms.description>
                                @endif
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1 text-sm text-gray-500">
                                        <x-heroicon-o-question-mark-circle class="w-4 h-4" />
                                        <span>{{ $customTest->questions()->count() }} soal</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-sm">
                                        @if($customTest->is_active)
                                            <x-heroicon-o-check-circle class="w-4 h-4 text-green-500" />
                                            <span class="text-green-600">Aktif</span>
                                        @else
                                            <x-heroicon-o-x-circle class="w-4 h-4 text-red-500" />
                                            <span class="text-red-600">Nonaktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                @endif
            </div>

            <div class="border-t pt-6 mt-6">
                <div class="flex gap-3">
                    <x-atoms.button
                        wire:click="saveCustomTests"
                        variant="success"
                        heroicon="check"
                        className="flex-1"
                        wire:loading.attr="disabled"
                        wire:target="saveCustomTests"
                    >
                        <span wire:loading.remove wire:target="saveCustomTests">
                            Simpan Perubahan
                        </span>
                        <span wire:loading wire:target="saveCustomTests">
                            Menyimpan...
                        </span>
                    </x-atoms.button>
                    
                    <x-atoms.button
                        wire:click="closeCustomTestModal"
                        variant="ghost"
                        theme="dark"
                        heroicon="x-mark"
                        className="flex-1"
                    >
                        Batal
                    </x-atoms.button>
                </div>
            </div>
        </div>
    </x-atoms.modal>

    {{-- Loading overlays --}}
    <div wire:loading.flex wire:target="save" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
            <span class="text-gray-700">
                {{ $editMode ? 'Memperbarui tes jalur...' : 'Menyimpan tes jalur...' }}
            </span>
        </div>
    </div>

    <div wire:loading.flex wire:target="saveCustomTests" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-emerald-600"></div>
            <span class="text-gray-700">Menyimpan custom tests...</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('success', event => {
        console.log('Success:', event.detail.message);
    });
    
    window.addEventListener('error', event => {
        console.log('Error:', event.detail.message);
    });
</script>
@endpush