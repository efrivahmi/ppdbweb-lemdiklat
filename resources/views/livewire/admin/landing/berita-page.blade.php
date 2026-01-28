<div>
    <x-atoms.breadcrumb currentPath="Berita" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Berita" size="xl" />

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari berita..." className="md:w-48" />

                <div class="relative">
                    <select wire:model.live="kategoriFilter"
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>

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
                    Tambah Berita
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Thumbnail</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Penulis</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($beritas->count() > 0)
                        @foreach ($beritas as $berita)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if ($berita->thumbnail)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="Thumbnail"
                                                class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-lg transition-opacity">
                                                <x-atoms.button wire:click="deleteThumbnail({{ $berita->id }})"
                                                    onclick="return confirm('Yakin ingin menghapus thumbnail?')"
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
                                    <div class="max-w-xs">
                                        <x-atoms.title text="{{ $berita->title }}" size="sm"
                                            class="text-gray-900 mb-1" />
                                        <x-atoms.description size="sm" class="text-gray-600">
                                            {{ Str::limit(strip_tags($berita->content), 80) }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.badge text="{{ $berita->kategori->name }}" variant="light" size="sm"
                                        class="inline-flex items-center">
                                        <x-heroicon-o-folder class="w-3 h-3 mr-1" />
                                        {{ $berita->kategori->name }}
                                    </x-atoms.badge>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-lime-100 rounded-full flex items-center justify-center">
                                            @if ($berita->creator->foto_profile)
                                                <img src="{{ asset('storage/' . $berita->creator->foto_profile) }}"
                                                    class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <x-heroicon-o-user class="w-4 h-4 text-lime-600" />
                                            @endif
                                        </div>
                                        <div>
                                            <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                                {{ $berita->creator->name }}
                                            </x-atoms.description>
                                            <x-atoms.description size="xs" class="text-gray-500">
                                                {{ $berita->creator->role }}
                                            </x-atoms.description>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleStatus({{ $berita->id }})"
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold transition cursor-pointer
                                            {{ $berita->is_active
                                                ? 'bg-lime-100 text-lime-800 hover:bg-lime-200'
                                                : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        @if ($berita->is_active)
                                            <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                                        @else
                                            <x-heroicon-o-x-circle class="w-3 h-3 mr-1" />
                                        @endif
                                        {{ $berita->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $berita->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $berita->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button wire:click="edit({{ $berita->id }})" variant="outline"
                                            theme="primary" size="sm" heroicon="pencil">
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button wire:click="delete({{ $berita->id }})"
                                            onclick="return confirm('Yakin ingin menghapus berita ini?')"
                                            variant="danger" theme="dark" size="sm" heroicon="trash">
                                            Hapus
                                        </x-atoms.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-8 text-gray-500" colspan="7">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-newspaper class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2" :text="($search || $kategoriFilter || $statusFilter !== '') ? 'Tidak ditemukan berita sesuai filter' : 'Belum ada berita'" />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search || $kategoriFilter || $statusFilter !== '')
                                            Coba ubah kata kunci atau filter yang digunakan
                                        @else
                                            Mulai dengan menambahkan berita pertama
                                        @endif
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($beritas->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $beritas->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="berita-modal" maxWidth="4xl" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title :text="$editMode ? 'Edit Berita' : 'Tambah Berita'" size="lg" class="text-gray-900" />
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-molecules.input-field label="Judul Berita" name="title" placeholder="Masukan judul berita"
                        wire:model="title" :error="$errors->first('title')" required />

                    <x-molecules.select-field label="Kategori" name="kategori_id" wire:model="kategori_id"
                        :options="collect([['value' => '', 'label' => '-- Pilih Kategori --']])
                            ->concat($allKategoris->map(fn($k) => ['value' => $k->id, 'label' => $k->name]))
                            ->toArray()" :error="$errors->first('kategori_id')" required />
                </div>

                <x-molecules.textarea-field label="Konten Berita" name="content"
                    placeholder="Masukan konten berita..." :rows="8" wire:model="content" :error="$errors->first('content')"
                    required />

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <x-atoms.label for="new_thumbnail">
                            Thumbnail
                        </x-atoms.label>

                        @if ($editMode && $thumbnail)
                            <div class="mb-3">
                                <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                    Thumbnail saat ini:
                                </x-atoms.description>
                                <img src="{{ asset('storage/' . $thumbnail) }}" alt="Current Thumbnail"
                                    class="w-32 h-24 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif

                        <x-molecules.file-field name="new_thumbnail" accept="image/*" maxSize="2MB"
                            wire:model="new_thumbnail" :error="$errors->first('new_thumbnail')" className="mb-0" />

                        @if ($new_thumbnail)
                            <div class="mt-2">
                                <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                    Preview thumbnail baru:
                                </x-atoms.description>
                                <img src="{{ $new_thumbnail->temporaryUrl() }}" alt="Preview"
                                    class="w-32 h-24 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif

                        <x-atoms.description size="xs" class="text-gray-500">
                            Format: JPG, PNG. Maksimal 2MB.
                        </x-atoms.description>
                    </div>

                    <div class="space-y-3">
                        <x-atoms.label>
                            Status <span class="text-red-500">*</span>
                        </x-atoms.label>
                        <div class="flex items-center gap-6 mt-8">
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
