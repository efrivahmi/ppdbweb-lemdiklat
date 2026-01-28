<div>
    <x-atoms.breadcrumb currentPath="Ekstrakurikuler" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Ekstrakurikuler" size="xl" class="text-gray-900" />

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari ekstrakurikuler"
                    className="md:w-64"
                />

                <x-atoms.button
                    wire:click="create"
                    variant="success"
                    theme="light"
                    heroicon="plus"
                >
                    Tambah Ekstrakurikuler
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Dibuat</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ekstrakurikulers->count())
                        @foreach ($ekstrakurikulers as $item)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if($item->img)
                                        <img src="{{ asset('storage/'.$item->img) }}" 
                                             class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 flex items-center justify-center rounded-lg border">
                                            <x-heroicon-o-photo class="w-6 h-6 text-gray-400" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.title text="{{ $item->title }}" size="sm" class="text-gray-900" />
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <x-atoms.description size="sm" class="text-gray-600">
                                        {{ Str::limit($item->desc, 100) }}
                                    </x-atoms.description>
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                        {{ $item->created_at->format('d M Y') }}
                                    </x-atoms.description>
                                    <x-atoms.description size="xs" class="text-gray-500">
                                        {{ $item->created_at->format('H:i') }}
                                    </x-atoms.description>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button
                                            wire:click="edit({{ $item->id }})"
                                            variant="primary"
                                            theme="dark"
                                            size="sm"
                                            heroicon="pencil"
                                        >
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button
                                            wire:click="delete({{ $item->id }})"
                                            onclick="return confirm('Yakin ingin menghapus?')"
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
                        <tr>
                            <td colspan="5" class="text-center px-6 py-8 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-academic-cap class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2"
                                        :text="$search ? 'Tidak ditemukan ekstrakurikuler' : 'Belum ada data'" />
                                    <x-atoms.description class="text-gray-500">
                                        {{ $search ? 'Coba ubah kata kunci pencarian' : 'Mulai dengan menambahkan ekstrakurikuler' }}
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($ekstrakurikulers->hasPages())
            <div class="mt-4 w-full flex justify-center">
                {{ $ekstrakurikulers->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="ekstrakurikuler-modal" maxWidth="2xl" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title :text="$editMode ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler'" size="lg" class="text-gray-900" />
        </div>

        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                <x-molecules.input-field
                    label="Judul Ekstrakurikuler"
                    name="title"
                    placeholder="Masukan judul"
                    wire:model="title"
                    :error="$errors->first('title')"
                    required
                />

                <x-molecules.textarea-field
                    label="Deskripsi Ekstrakurikuler"
                    name="desc"
                    placeholder="Masukan deskripsi..."
                    :rows="6"
                    wire:model="desc"
                    :error="$errors->first('desc')"
                    required
                />

                <div class="space-y-3">
                    <x-atoms.label for="new_img">Gambar Ekstrakurikuler</x-atoms.label>

                    @if($editMode && $img)
                        <div class="mb-3">
                            <x-atoms.description size="sm" class="mb-2">Gambar saat ini:</x-atoms.description>
                            <img src="{{ asset('storage/'.$img) }}" class="w-48 h-32 object-cover rounded-lg border">
                        </div>
                    @endif

                    <x-molecules.file-field
                        name="new_img"
                        accept="image/*"
                        maxSize="2MB"
                        wire:model="new_img"
                        :error="$errors->first('new_img')"
                    />

                    @if($new_img)
                        <div class="mt-2">
                            <x-atoms.description size="sm" class="mb-2">Preview gambar baru:</x-atoms.description>
                            <img src="{{ $new_img->temporaryUrl() }}" class="w-48 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                </div>
            </form>
        </div>

        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button wire:click="save" variant="primary" theme="dark" heroicon="check" isFullWidth>
                {{ $editMode ? 'Update' : 'Simpan' }}
            </x-atoms.button>
            <x-atoms.button wire:click="cancel" variant="secondary" theme="dark" heroicon="x-mark" isFullWidth>
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>
