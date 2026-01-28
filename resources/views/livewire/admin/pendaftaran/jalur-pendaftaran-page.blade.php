<div>
    <x-atoms.breadcrumb currentPath="Jalur Pendaftaran" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Jalur Pendaftaran" size="xl" />
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari jalur pendaftaran..."
                    className="md:w-64"
                />

                <x-atoms.button
                    wire:click="create"
                    variant="success"
                    heroicon="plus"
                    className="whitespace-nowrap"
                >
                    Tambah Jalur
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama Jalur</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($jalurs->count() > 0)
                        @foreach ($jalurs as $index => $jalur)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ ($jalurs->currentPage() - 1) * $jalurs->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($jalur->img)
                                            <img src="{{ Storage::url($jalur->img) }}" 
                                                 alt="{{ $jalur->nama }}" 
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-lime-200">
                                        @else
                                            <div class="w-10 h-10 bg-lime-100 rounded-full flex items-center justify-center">
                                                <x-heroicon-o-academic-cap class="w-5 h-5 text-lime-600" />
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $jalur->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <x-atoms.description class="line-clamp-2">
                                            {{ $jalur->deskripsi ?: '-' }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <x-heroicon-o-calendar-days class="w-4 h-4 text-gray-400 mr-2" />
                                        {{ $jalur->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button
                                            wire:click="edit({{ $jalur->id }})"
                                            variant="primary"
                                            theme="dark"
                                            size="sm"
                                            heroicon="pencil"
                                        >
                                            Edit
                                        </x-atoms.button>
                                        
                                        <x-atoms.button
                                            wire:click="delete({{ $jalur->id }})"
                                            wire:confirm="Yakin ingin menghapus jalur pendaftaran ini?"
                                            variant="danger"
                                            theme="dark"
                                            size="sm"
                                            heroicon="trash"
                                        >
                                            Hapus
                                        </x-atoms.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-12 text-gray-500" colspan="6">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-academic-cap class="w-8 h-8 text-gray-400" />
                                    </div>
                                    <div class="text-center">
                                        <x-atoms.title text="Tidak ada jalur pendaftaran" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400">
                                            @if ($search)
                                                Tidak ditemukan jalur pendaftaran sesuai pencarian "{{ $search }}"
                                            @else
                                                Belum ada data jalur pendaftaran
                                            @endif
                                        </x-atoms.description>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($jalurs->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $jalurs->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="jalur-pendaftaran" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-academic-cap class="w-6 h-6 text-lime-600" />
                </div>
                <div>
                    <x-atoms.title 
                        :text="$editMode ? 'Edit Jalur Pendaftaran' : 'Tambah Jalur Pendaftaran'" 
                        size="lg" 
                    />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data jalur pendaftaran' : 'Lengkapi form dibawah untuk menambahkan jalur pendaftaran baru' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-5">
                <x-molecules.input-field
                    label="Nama Jalur"
                    name="nama"
                    wire:model="nama"
                    placeholder="Masukkan nama jalur pendaftaran"
                    :required="true"
                    :error="$errors->first('nama')"
                />

                <!-- Upload Gambar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Jalur
                    </label>
                    
                    @if ($img)
                        <div class="mb-3">
                            <img src="{{ $img->temporaryUrl() }}" 
                                 alt="Preview" 
                                 class="w-32 h-32 rounded-lg object-cover border-2 border-lime-300">
                            <x-atoms.button
                                type="button"
                                wire:click="$set('img', null)"
                                variant="danger"
                                size="sm"
                                heroicon="x-mark"
                                className="mt-2"
                            >
                                Hapus Gambar
                            </x-atoms.button>
                        </div>
                    @elseif ($editMode && $oldImg)
                        <div class="mb-3">
                            <img src="{{ Storage::url($oldImg) }}" 
                                 alt="Current Image" 
                                 class="w-32 h-32 rounded-lg object-cover border-2 border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                        </div>
                    @endif

                    <input 
                        type="file" 
                        wire:model="img" 
                        accept="image/*"
                        class="block w-full text-sm text-gray-500
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:text-sm file:font-semibold
                               file:bg-lime-50 file:text-lime-700
                               hover:file:bg-lime-100
                               cursor-pointer"
                    >
                    
                    @error('img')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <p class="mt-1 text-xs text-gray-500">
                        Format: JPG, PNG, GIF. Maksimal 2MB
                    </p>
                    
                    <div wire:loading wire:target="img" class="mt-2">
                        <span class="text-sm text-lime-600">Mengupload gambar...</span>
                    </div>
                </div>

                <x-molecules.textarea-field
                    label="Deskripsi"
                    name="deskripsi"
                    wire:model="deskripsi"
                    placeholder="Deskripsi jalur pendaftaran (opsional)"
                    :rows="4"
                    :error="$errors->first('deskripsi')"
                />

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
                                {{ $editMode ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="save">
                                {{ $editMode ? 'Mengupdate...' : 'Menyimpan...' }}
                            </span>
                        </x-atoms.button>
                        
                        <x-atoms.button
                            type="button"
                            wire:click="closeModal"
                            variant="danger"
                            theme="light"
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

    <div wire:loading.flex wire:target="save" class="fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">
                {{ $editMode ? 'Mengupdate jalur pendaftaran...' : 'Menyimpan jalur pendaftaran...' }}
            </span>
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