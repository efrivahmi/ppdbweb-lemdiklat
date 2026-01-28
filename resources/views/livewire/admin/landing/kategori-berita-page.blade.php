<div>
    <x-atoms.breadcrumb currentPath="Kategori Berita" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Kategori Berita" size="xl" />

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari kategori berita..."
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
                    Tambah Kategori
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Kategori</th>
                        <th scope="col" class="px-6 py-3">Jumlah Berita</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($kategoris->count() > 0)
                        @foreach ($kategoris as $kategori)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-heroicon-o-folder class="w-5 h-5 text-lime-600" />
                                        <span class="font-medium text-gray-900">{{ $kategori->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.badge text="{{ $kategori->beritas_count }} Berita" variant="sky"
                                        size="sm" />
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleStatus({{ $kategori->id }})"
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold transition cursor-pointer
                                            {{ $kategori->is_active
                                                ? 'bg-lime-100 text-lime-800 hover:bg-lime-200'
                                                : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        @if ($kategori->is_active)
                                            <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                                        @else
                                            <x-heroicon-o-x-circle class="w-3 h-3 mr-1" />
                                        @endif
                                        {{ $kategori->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                        {{ $kategori->created_at->format('d M Y') }}
                                    </x-atoms.description>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button wire:click="edit({{ $kategori->id }})" variant="primary"
                                            theme="dark" size="sm" heroicon="pencil">
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button wire:click="delete({{ $kategori->id }})"
                                            onclick="return confirm('Yakin ingin menghapus kategori ini? Pastikan tidak ada berita yang menggunakan kategori ini.')"
                                            variant="danger" theme="dark" size="sm" heroicon="trash"
                                            :disabled="$kategori->beritas_count > 0"
                                            title="{{ $kategori->beritas_count > 0 ? 'Tidak dapat menghapus kategori yang memiliki berita' : '' }}">
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
                                    <x-heroicon-o-folder class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2" :text="($search || $statusFilter !== '') ? 'Tidak ditemukan kategori sesuai filter' : 'Belum ada kategori berita'" />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search || $statusFilter !== '')
                                            Coba ubah kata kunci atau filter yang digunakan
                                        @else
                                            Mulai dengan menambahkan kategori berita
                                        @endif
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($kategoris->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $kategoris->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="kategori-berita-modal" maxWidth="md" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title :text="$editMode ? 'Edit Kategori Berita' : 'Tambah Kategori Berita'" size="lg" class="text-gray-900" />
        </div>

        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <x-molecules.input-field label="Nama Kategori" name="name" placeholder="Masukan nama kategori berita"
                    wire:model="name" :error="$errors->first('name')" required />

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
            </form>
        </div>

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
