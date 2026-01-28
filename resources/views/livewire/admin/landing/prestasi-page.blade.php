<div>
    <x-atoms.breadcrumb currentPath="Prestasi" />
    
    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title 
                text="Tabel Prestasi" 
                size="xl" 
                class="text-gray-900"
            />
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari prestasi"
                    className="md:w-64"
                />
                
                <x-atoms.button
                    wire:click="create"
                    variant="success"
                    theme="light"
                    heroicon="plus"
                >
                    Tambah Prestasi
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Gambar</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($prestasis->count() > 0)
                        @foreach ($prestasis as $prestasi)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if($prestasi->image)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $prestasi->image) }}" 
                                                 alt="Prestasi Image" 
                                                 class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <x-heroicon-o-photo class="w-6 h-6 text-gray-400" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.title 
                                        text="{{ $prestasi->title }}" 
                                        size="sm" 
                                        class="text-gray-900"
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <x-atoms.description size="sm" class="text-gray-600">
                                            {{ Str::limit($prestasi->description, 100) }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $prestasi->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $prestasi->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button
                                            wire:click="edit({{ $prestasi->id }})"
                                            variant="primary"
                                            theme="dark"
                                            size="sm"
                                            heroicon="pencil"
                                        >
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button
                                            wire:click="delete({{ $prestasi->id }})"
                                            onclick="return confirm('Yakin ingin menghapus prestasi ini?')"
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
                            <td class="text-center px-6 py-8 text-gray-500" colspan="5">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-trophy class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title 
                                        size="md" 
                                        class="text-gray-700 mb-2"
                                        :text="$search ? 'Tidak ditemukan prestasi sesuai pencarian' : 'Belum ada data prestasi'"
                                    />
                                    <x-atoms.description class="text-gray-500">
                                        @if($search)
                                            Coba ubah kata kunci pencarian
                                        @else
                                            Mulai dengan menambahkan prestasi sekolah
                                        @endif
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($prestasis->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $prestasis->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal 
        name="prestasi-modal" 
        maxWidth="2xl"
        :closeable="true"
    >
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title 
                :text="$editMode ? 'Edit Prestasi' : 'Tambah Prestasi'"
                size="lg" 
                class="text-gray-900"
            />
        </div>

        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                <x-molecules.input-field
                    label="Judul Prestasi"
                    name="title"
                    placeholder="Masukan judul prestasi"
                    wire:model="title"
                    :error="$errors->first('title')"
                    required
                />

                <x-molecules.textarea-field
                    label="Deskripsi Prestasi"
                    name="description"
                    placeholder="Masukan deskripsi prestasi..."
                    :rows="6"
                    wire:model="description"
                    :error="$errors->first('description')"
                    required
                />

                <div class="space-y-3">
                    <x-atoms.label for="new_image">
                        Gambar Prestasi
                    </x-atoms.label>
                    
                    @if($editMode && $image)
                        <div class="mb-3">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                Gambar saat ini:
                            </x-atoms.description>
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="Current Image" 
                                 class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif
                    
                    <x-molecules.file-field
                        name="new_image"
                        accept="image/*"
                        maxSize="2MB"
                        wire:model="new_image"
                        :error="$errors->first('new_image')"
                        className="mb-0"
                    />
                    
                    @if($new_image)
                        <div class="mt-2">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                Preview gambar baru:
                            </x-atoms.description>
                            <img src="{{ $new_image->temporaryUrl() }}" 
                                 alt="Preview" 
                                 class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif
                    
                    <x-atoms.description size="xs" class="text-gray-500">
                        Format: JPG, PNG. Maksimal 2MB. (Opsional)
                    </x-atoms.description>
                </div>
            </form>
        </div>

        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button
                wire:click="save"
                variant="primary"
                theme="dark"
                heroicon="check"
                isFullWidth
                class="bg-lime-600 hover:bg-lime-700"
            >
                {{ $editMode ? 'Update' : 'Simpan' }}
            </x-atoms.button>
            <x-atoms.button
                wire:click="cancel"
                variant="secondary"
                theme="dark"
                heroicon="x-mark"
                isFullWidth
                class="bg-gray-500 hover:bg-gray-600"
            >
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>