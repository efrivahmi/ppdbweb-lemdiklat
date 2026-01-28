<div>
    <x-atoms.breadcrumb currentPath="Informasi Sekolah" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Informasi Sekolah" size="xl" class="text-gray-900" />

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari informasi..."
                    className="md:w-64"
                />

                <x-atoms.button
                    wire:click="create"
                    variant="success"
                    theme="light"
                    heroicon="plus"
                >
                    Tambah Informasi
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th class="px-6 py-3 w-16">Urutan</th>
                        <th class="px-6 py-3 w-20">Icon</th>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">URL</th>
                        <th class="px-6 py-3 w-24 text-center">Status</th>
                        <th class="px-6 py-3 w-48 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($informations->count())
                        @foreach ($informations as $item)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <x-atoms.badge 
                                        :text="$item->order" 
                                        variant="light" 
                                        size="sm"
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-10 h-10 bg-lime-50 rounded-lg flex items-center justify-center border border-lime-200">
                                        <x-dynamic-component 
                                            :component="'heroicon-o-' . $item->icon" 
                                            class="w-6 h-6 text-lime-600" 
                                        />
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.title text="{{ $item->title }}" size="sm" class="text-gray-900 mb-1" />
                                    <x-atoms.description size="xs" class="text-gray-500">
                                        <span class="font-mono">{{ $item->icon }}</span>
                                    </x-atoms.description>
                                </td>
                                <td class="px-6 py-4 max-w-md">
                                    <x-atoms.description size="sm" class="text-gray-600">
                                        {{ Str::limit($item->description, 100) }}
                                    </x-atoms.description>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->url)
                                        <a href="{{ $item->url }}" target="_blank" class="inline-flex items-center gap-1 text-lime-600 hover:text-lime-700 text-sm">
                                            <x-heroicon-o-link class="w-4 h-4" />
                                            <span>Lihat</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button 
                                        wire:click="toggleStatus({{ $item->id }})"
                                        class="inline-flex items-center gap-1"
                                    >
                                        @if($item->is_active)
                                            <x-atoms.badge text="Aktif" variant="emerald" size="sm" />
                                        @else
                                            <x-atoms.badge text="Nonaktif" variant="danger" size="sm" />
                                        @endif
                                    </button>
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
                                            onclick="return confirm('Yakin ingin menghapus informasi ini?')"
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
                            <td colspan="7" class="text-center px-6 py-8 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-information-circle class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2"
                                        :text="$search ? 'Tidak ditemukan informasi' : 'Belum ada data'" />
                                    <x-atoms.description class="text-gray-500">
                                        {{ $search ? 'Coba ubah kata kunci pencarian' : 'Mulai dengan menambahkan informasi sekolah' }}
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($informations->hasPages())
            <div class="mt-4 w-full flex justify-center">
                {{ $informations->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal Form --}}
    <x-atoms.modal name="information-modal" maxWidth="2xl" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title :text="$editMode ? 'Edit Informasi' : 'Tambah Informasi'" size="lg" class="text-gray-900" />
        </div>

        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- Icon Selection --}}
                <div class="space-y-3">
                    <x-atoms.label for="icon">
                        Icon Informasi
                        <span class="text-red-500">*</span>
                    </x-atoms.label>
                    
                    <select 
                        wire:model.live="icon"
                        id="icon"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out @error('icon') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Icon --</option>
                        @foreach($this->availableIcons as $iconValue => $iconLabel)
                            <option value="{{ $iconValue }}">{{ $iconLabel }}</option>
                        @endforeach
                    </select>

                    @if($icon)
                        <div class="flex items-center gap-3 p-3 bg-lime-50 rounded-lg border border-lime-200">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                                <x-dynamic-component 
                                    :component="'heroicon-o-' . $icon" 
                                    class="w-6 h-6 text-lime-600" 
                                />
                            </div>
                            <div>
                                <x-atoms.description size="sm" class="text-gray-700 font-medium">
                                    Preview Icon
                                </x-atoms.description>
                                <x-atoms.description size="xs" class="text-gray-500 font-mono">
                                    {{ $icon }}
                                </x-atoms.description>
                            </div>
                        </div>
                    @endif

                    @error('icon')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Title --}}
                <x-molecules.input-field
                    label="Judul Informasi"
                    name="title"
                    placeholder="Contoh: Pengumuman Penerimaan Siswa Baru"
                    wire:model="title"
                    :error="$errors->first('title')"
                    required
                />

                {{-- URL --}}
                <x-molecules.input-field
                    label="URL / Link (Opsional)"
                    name="url"
                    placeholder="https://example.com atau #section-id"
                    wire:model="url"
                    :error="$errors->first('url')"
                />

                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-2">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" />
                        <div>
                            <x-atoms.description size="xs" class="text-blue-800">
                                <strong>Tips penggunaan URL:</strong><br>
                                • Kosongkan jika tidak ada link<br>
                                • Gunakan URL lengkap (https://...) untuk link eksternal<br>
                                • Gunakan #id untuk scroll ke section dalam halaman yang sama
                            </x-atoms.description>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <x-molecules.textarea-field
                    label="Deskripsi Informasi"
                    name="description"
                    placeholder="Jelaskan informasi secara detail..."
                    :rows="5"
                    wire:model="description"
                    :error="$errors->first('description')"
                    required
                />

                {{-- Order --}}
                <x-molecules.input-field
                    label="Urutan Tampilan"
                    inputType="number"
                    name="order"
                    placeholder="1"
                    wire:model="order"
                    :error="$errors->first('order')"
                    required
                />

                {{-- Status --}}
                <div class="space-y-3">
                    <x-atoms.label for="is_active">Status</x-atoms.label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model="is_active" 
                                value="1"
                                class="w-4 h-4 text-lime-600 focus:ring-lime-500"
                            >
                            <span class="text-sm text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model="is_active" 
                                value="0"
                                class="w-4 h-4 text-lime-600 focus:ring-lime-500"
                            >
                            <span class="text-sm text-gray-700">Nonaktif</span>
                        </label>
                    </div>
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