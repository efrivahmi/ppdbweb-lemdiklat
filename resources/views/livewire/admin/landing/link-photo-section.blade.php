<div>
    {{-- Breadcrumb --}}
    <x-atoms.breadcrumb currentPath="Link Photo" />

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-lime-100 border border-lime-400 text-lime-700 rounded-lg flex items-center">
            <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
            <x-heroicon-o-x-circle class="w-5 h-5 mr-2" />
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Card Container --}}
    <x-atoms.card className="mt-3">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <x-atoms.title text="Tabel Link Photo" size="xl" />
                <x-atoms.description size="sm" class="text-gray-600 mt-1">
                    Kelola foto dan tautan untuk ditampilkan di halaman landing
                </x-atoms.description>
            </div>

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input 
                    type="search" 
                    wire:model.live="search" 
                    placeholder="Cari link photo..."
                    className="md:w-64" 
                />

                <x-atoms.button 
                    wire:click="create" 
                    variant="success" 
                    heroicon="plus" 
                    className="whitespace-nowrap"
                >
                    Tambah Link Photo
                </x-atoms.button>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start gap-3">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" />
                <div>
                    <x-atoms.title text="Informasi" size="sm" class="text-blue-900 mb-1" />
                    <x-atoms.description size="xs" class="text-blue-800">
                        Link Photo akan ditampilkan maksimal 4 item di halaman landing. Pastikan gambar berkualitas baik dan URL valid.
                    </x-atoms.description>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Gambar</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">URL</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($linkPhotos->count() > 0)
                        @foreach ($linkPhotos as $linkPhoto)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if ($linkPhoto->image)
                                        <div class="relative group">
                                            <img 
                                                src="{{ asset('storage/' . $linkPhoto->image) }}" 
                                                alt="{{ $linkPhoto->title }}"
                                                class="w-20 h-20 object-cover rounded-lg border border-gray-200"
                                            >
                                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-lg transition-opacity">
                                                <x-atoms.button 
                                                    wire:click="deleteImage({{ $linkPhoto->id }})"
                                                    onclick="return confirm('Yakin ingin menghapus gambar?')"
                                                    variant="ghost" 
                                                    size="sm" 
                                                    heroicon="trash"
                                                    class="text-white hover:text-red-300" 
                                                />
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <x-heroicon-o-photo class="w-8 h-8 text-gray-400" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.title 
                                        text="{{ $linkPhoto->title }}" 
                                        size="sm" 
                                        class="text-gray-900" 
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <a 
                                            href="{{ $linkPhoto->url }}" 
                                            target="_blank" 
                                            rel="noopener noreferrer"
                                            class="text-blue-600 hover:text-blue-800 hover:underline text-sm break-all flex items-center gap-1"
                                        >
                                            <x-heroicon-o-link class="w-4 h-4 flex-shrink-0" />
                                            <span class="line-clamp-2">{{ $linkPhoto->url }}</span>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $linkPhoto->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $linkPhoto->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button 
                                            wire:click="edit({{ $linkPhoto->id }})" 
                                            variant="outline"
                                            theme="dark" 
                                            size="sm" 
                                            heroicon="pencil"
                                            class="text-lime-600 border-lime-600 hover:bg-lime-600 hover:text-white"
                                        >
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button 
                                            wire:click="delete({{ $linkPhoto->id }})"
                                            onclick="return confirm('Yakin ingin menghapus link photo ini?')"
                                            variant="outline" 
                                            theme="dark" 
                                            size="sm" 
                                            heroicon="trash"
                                            class="text-red-600 border-red-600 hover:bg-red-600 hover:text-white"
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
                                    <x-heroicon-o-photo class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title 
                                        size="md" 
                                        class="text-gray-700 mb-2" 
                                        :text="$search ? 'Tidak ditemukan link photo sesuai pencarian' : 'Belum ada data link photo'" 
                                    />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search)
                                            Coba ubah kata kunci pencarian
                                        @else
                                            Mulai dengan menambahkan link photo baru
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
        @if ($linkPhotos->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $linkPhotos->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal --}}
    <x-atoms.modal name="link-photo-modal" maxWidth="2xl" :closeable="true">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title 
                :text="$editMode ? 'Edit Link Photo' : 'Tambah Link Photo'" 
                size="lg" 
                class="text-gray-900" 
            />
        </div>

        {{-- Modal Content --}}
        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- Title Field --}}
                <x-molecules.input-field 
                    label="Judul" 
                    name="title" 
                    placeholder="Masukan judul link photo"
                    wire:model="title" 
                    :error="$errors->first('title')" 
                    required 
                />

                {{-- URL Field --}}
                <x-molecules.input-field 
                    label="URL" 
                    inputType="url"
                    name="url" 
                    placeholder="https://example.com"
                    wire:model="url" 
                    :error="$errors->first('url')" 
                    required 
                />

                {{-- Image Field --}}
                <div class="space-y-3">
                    <x-atoms.label for="new_image">
                        Gambar
                    </x-atoms.label>

                    {{-- Current Image Preview --}}
                    @if ($editMode && $image)
                        <div class="mb-3">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                Gambar saat ini:
                            </x-atoms.description>
                            <img 
                                src="{{ asset('storage/' . $image) }}" 
                                alt="Current Image"
                                class="w-64 h-48 object-cover rounded-lg border border-gray-200"
                            >
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

                    {{-- New Image Preview --}}
                    @if ($new_image)
                        <div class="mt-2">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                Preview gambar baru:
                            </x-atoms.description>
                            <img 
                                src="{{ $new_image->temporaryUrl() }}" 
                                alt="Preview"
                                class="w-64 h-48 object-cover rounded-lg border border-gray-200"
                            >
                        </div>
                    @endif

                    <x-atoms.description size="xs" class="text-gray-500">
                        Format: JPG, JPEG, PNG. Maksimal 2MB. Rekomendasi ukuran: 800x600px (Opsional)
                    </x-atoms.description>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
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