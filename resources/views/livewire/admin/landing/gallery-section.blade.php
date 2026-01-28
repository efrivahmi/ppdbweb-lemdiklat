<div>
    {{-- Breadcrumb --}}
    <x-atoms.breadcrumb currentPath="Gallery" />

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
                <x-atoms.title text="Galeri Sekolah" size="xl" />
                <x-atoms.description size="sm" class="text-gray-600 mt-1">
                    Kelola foto galeri untuk ditampilkan di halaman landing
                </x-atoms.description>
            </div>

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input 
                    type="search" 
                    wire:model.live="search" 
                    placeholder="Cari galeri..."
                    className="md:w-64" 
                />

                <x-atoms.button 
                    wire:click="create" 
                    variant="success" 
                    heroicon="plus" 
                    className="whitespace-nowrap"
                >
                    Tambah Galeri
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
                        Foto galeri akan ditampilkan dalam carousel di halaman landing. Gunakan gambar berkualitas baik dengan resolusi minimal 1200x800px untuk hasil terbaik.
                    </x-atoms.description>
                </div>
            </div>
        </div>

        {{-- Gallery Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @if ($galleries->count() > 0)
                @foreach ($galleries as $gallery)
                    <div class="group relative bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                        {{-- Image --}}
                        <div class="relative aspect-square">
                            @if ($gallery->image)
                                <img 
                                    src="{{ asset('storage/' . $gallery->image) }}" 
                                    alt="{{ $gallery->title }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                    <x-heroicon-o-photo class="w-12 h-12 text-gray-400" />
                                </div>
                            @endif

                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                                <button 
                                    wire:click="edit({{ $gallery->id }})"
                                    class="p-2 bg-lime-600 hover:bg-lime-700 text-white rounded-lg transition-colors"
                                    title="Edit"
                                >
                                    <x-heroicon-o-pencil class="w-5 h-5" />
                                </button>
                                <button 
                                    wire:click="delete({{ $gallery->id }})"
                                    onclick="return confirm('Yakin ingin menghapus galeri ini?')"
                                    class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors"
                                    title="Hapus"
                                >
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        {{-- Title --}}
                        <div class="p-3 bg-white">
                            <x-atoms.title 
                                text="{{ $gallery->title }}" 
                                size="xs" 
                                class="text-gray-900 line-clamp-2" 
                            />
                            <x-atoms.description size="xs" class="text-gray-500 mt-1">
                                {{ $gallery->created_at->format('d M Y') }}
                            </x-atoms.description>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-12">
                    <div class="flex flex-col items-center">
                        <x-heroicon-o-photo class="w-16 h-16 text-gray-300 mb-4" />
                        <x-atoms.title 
                            size="md" 
                            class="text-gray-700 mb-2" 
                            :text="$search ? 'Tidak ditemukan galeri sesuai pencarian' : 'Belum ada data galeri'" 
                        />
                        <x-atoms.description class="text-gray-500">
                            @if ($search)
                                Coba ubah kata kunci pencarian
                            @else
                                Mulai dengan menambahkan foto galeri baru
                            @endif
                        </x-atoms.description>
                    </div>
                </div>
            @endif
        </div>

        {{-- Pagination --}}
        @if ($galleries->hasPages())
            <div class="mt-6 w-full flex justify-center items-center">
                {{ $galleries->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal --}}
    <x-atoms.modal name="gallery-modal" maxWidth="2xl" :closeable="true">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title 
                :text="$editMode ? 'Edit Galeri' : 'Tambah Galeri'" 
                size="lg" 
                class="text-gray-900" 
            />
        </div>

        {{-- Modal Content --}}
        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- Title Field --}}
                <x-molecules.input-field 
                    label="Judul Foto" 
                    name="title" 
                    placeholder="Masukan judul foto"
                    wire:model="title" 
                    :error="$errors->first('title')" 
                    required 
                />

                {{-- Image Field --}}
                <div class="space-y-3">
                    <x-atoms.label for="new_image">
                        Gambar <span class="text-red-500">*</span>
                    </x-atoms.label>

                    {{-- Current Image Preview --}}
                    @if ($editMode && $image)
                        <div class="mb-3">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                Gambar saat ini:
                            </x-atoms.description>
                            <div class="relative inline-block">
                                <img 
                                    src="{{ asset('storage/' . $image) }}" 
                                    alt="Current Image"
                                    class="w-full max-w-md h-64 object-cover rounded-lg border border-gray-200"
                                >
                                <button
                                    type="button"
                                    wire:click="deleteImage({{ $galleryId }})"
                                    onclick="return confirm('Yakin ingin menghapus gambar?')"
                                    class="absolute top-2 right-2 p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors"
                                >
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    @endif

                    <x-molecules.file-field 
                        name="new_image" 
                        accept="image/*" 
                        maxSize="2MB" 
                        wire:model="new_image"
                        :error="$errors->first('new_image')" 
                        :required="!$editMode"
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
                                class="w-full max-w-md h-64 object-cover rounded-lg border border-gray-200"
                            >
                        </div>
                    @endif

                    <x-atoms.description size="xs" class="text-gray-500">
                        Format: JPG, JPEG, PNG. Maksimal 2MB. Rekomendasi ukuran: 1200x800px {{ !$editMode ? '(Wajib)' : '(Opsional)' }}
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