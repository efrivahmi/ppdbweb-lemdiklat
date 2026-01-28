<div>
    {{-- Breadcrumb --}}
    <x-atoms.breadcrumb currentPath="Fasilitas" />

    {{-- Main Card Container --}}
    <x-atoms.card className="mt-3">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Fasilitas" size="xl" />

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari fasilitas..."
                    className="md:w-48" />

                <div class="relative">
                    <select wire:model.live="statusFilter"
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>

                <x-atoms.button wire:click="create" variant="success" heroicon="plus" className="whitespace-nowrap">
                    Tambah Fasilitas
                </x-atoms.button>
            </div>
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Gambar</th>
                        <th scope="col" class="px-6 py-3">Nama Fasilitas</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($fasilitas->count() > 0)
                        @foreach ($fasilitas as $item)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if ($item->image)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Fasilitas Image"
                                                class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-lg transition-opacity">
                                                <x-atoms.button wire:click="deleteImage({{ $item->id }})"
                                                    onclick="return confirm('Yakin ingin menghapus gambar?')"
                                                    variant="ghost" size="sm" heroicon="trash"
                                                    class="text-white hover:text-red-300" />
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <x-heroicon-o-photo class="w-6 h-6 text-gray-400" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.title text="{{ $item->name }}" size="sm" class="text-gray-900" />
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <x-atoms.description size="sm" class="text-gray-600">
                                            {{ Str::limit($item->description, 100) }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleStatus({{ $item->id }})"
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold transition cursor-pointer
                                            {{ $item->is_active
                                                ? 'bg-lime-100 text-lime-800 hover:bg-lime-200'
                                                : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        @if ($item->is_active)
                                            <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                                        @else
                                            <x-heroicon-o-x-circle class="w-3 h-3 mr-1" />
                                        @endif
                                        {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $item->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $item->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button wire:click="edit({{ $item->id }})" variant="outline"
                                            theme="dark" size="sm" heroicon="pencil"
                                            class="text-lime-600 border-lime-600 hover:bg-lime-600 hover:text-white">
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button wire:click="delete({{ $item->id }})"
                                            onclick="return confirm('Yakin ingin menghapus fasilitas ini?')"
                                            variant="outline" theme="dark" size="sm" heroicon="trash"
                                            class="text-red-600 border-red-600 hover:bg-red-600 hover:text-white">
                                            Hapus
                                        </x-atoms.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-8 text-gray-500" colspan="6">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-building-office-2 class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2" :text="($search || $statusFilter !== '') ? 'Tidak ditemukan fasilitas sesuai filter' : 'Belum ada data fasilitas'" />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search || $statusFilter !== '')
                                            Coba ubah kata kunci atau filter yang digunakan
                                        @else
                                            Mulai dengan menambahkan fasilitas sekolah
                                        @endif
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($fasilitas->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $fasilitas->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal --}}
    <x-atoms.modal name="fasilitas-modal" maxWidth="2xl" :closeable="true">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title :text="$editMode ? 'Edit Fasilitas' : 'Tambah Fasilitas'" size="lg" class="text-gray-900" />
        </div>

        {{-- Modal Content --}}
        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- Name Field --}}
                <x-molecules.input-field label="Nama Fasilitas" name="name" placeholder="Masukan nama fasilitas"
                    wire:model="name" :error="$errors->first('name')" required />

                {{-- Description Field --}}
                <x-molecules.textarea-field label="Deskripsi Fasilitas" name="description"
                    placeholder="Masukan deskripsi fasilitas..." :rows="6" wire:model="description"
                    :error="$errors->first('description')" required />

                {{-- Status Selection --}}
                <div class="space-y-3">
                    <x-atoms.label>
                        Status <span class="text-red-500">*</span>
                    </x-atoms.label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="is_active" value="1"
                                class="text-lime-600 focus:ring-lime-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <x-heroicon-o-check-circle class="w-4 h-4 text-lime-600 mr-1" />
                                Aktif
                            </span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="is_active" value="0"
                                class="text-lime-600 focus:ring-lime-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <x-heroicon-o-x-circle class="w-4 h-4 text-red-600 mr-1" />
                                Tidak Aktif
                            </span>
                        </label>
                    </div>
                    @error('is_active')
                        <x-atoms.description size="xs" class="text-red-500">
                            {{ $message }}
                        </x-atoms.description>
                    @enderror
                </div>

                {{-- Image Field --}}
                <div class="space-y-3">
                    <x-atoms.label for="new_image">
                        Gambar Fasilitas
                    </x-atoms.label>

                    {{-- Current Image Preview --}}
                    @if ($editMode && $image)
                        <div class="mb-3">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                Gambar saat ini:
                            </x-atoms.description>
                            <img src="{{ asset('storage/' . $image) }}" alt="Current Image"
                                class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <x-molecules.file-field name="new_image" accept="image/*" maxSize="2MB" wire:model="new_image"
                        :error="$errors->first('new_image')" className="mb-0" />

                    {{-- New Image Preview --}}
                    @if ($new_image)
                        <div class="mt-2">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                Preview gambar baru:
                            </x-atoms.description>
                            <img src="{{ $new_image->temporaryUrl() }}" alt="Preview"
                                class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <x-atoms.description size="xs" class="text-gray-500">
                        Format: JPG, PNG. Maksimal 2MB. (Opsional)
                    </x-atoms.description>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button wire:click="save" variant="primary" theme="dark" heroicon="check" isFullWidth
                class="bg-lime-600 hover:bg-lime-700">
                {{ $editMode ? 'Update' : 'Simpan' }}
            </x-atoms.button>
            <x-atoms.button wire:click="cancel" variant="secondary" theme="dark" heroicon="x-mark" isFullWidth
                class="bg-gray-500 hover:bg-gray-600">
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>
