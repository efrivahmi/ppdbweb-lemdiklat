<div>
    {{-- Breadcrumb --}}
    <x-atoms.breadcrumb currentPath="Kurikulum" />

    {{-- Loading --}}
    @if($isLoading)
        <x-atoms.card className="mt-3">
            <div class="animate-pulse space-y-6">
                <div class="h-8 bg-gray-200 rounded w-1/3"></div>
                <div class="space-y-4">
                    <div class="h-4 bg-gray-200 rounded"></div>
                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                    <div class="h-4 bg-gray-200 rounded w-4/6"></div>
                </div>
                <div class="h-32 bg-gray-200 rounded"></div>
            </div>
        </x-atoms.card>
    @else
        <x-atoms.card className="mt-3 space-y-8">
            <form wire:submit.prevent="save" class="space-y-10">
                {{-- Informasi Umum --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Informasi Umum" size="lg" />
                    <x-molecules.input-field label="Badge Text" wire:model="badge_text" placeholder="Kurikulum" />
                    <x-molecules.input-field label="Title Text" wire:model="title_text" placeholder="Struktur Kurikulum" />
                    <x-molecules.input-field label="Title Highlight" wire:model="title_highlight" placeholder="Terpadu" />
                    <x-molecules.textarea-field label="Deskripsi" wire:model="descriptions" :rows="4" />
                </div>

                {{-- Gambar Utama --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Gambar Utama" size="lg" />
                    <input type="file" wire:model="image" class="w-full border-gray-300 rounded-md" />
                    @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

                    <x-molecules.input-field label="Judul Gambar" wire:model="image_title" />
                    <x-molecules.textarea-field label="Deskripsi Gambar" wire:model="image_description" :rows="2" />

                    @if($image)
                        <img src="{{ $image->temporaryUrl() }}" class="w-64 h-40 object-cover rounded-lg border mt-3">
                    @elseif($image_url)
                        <img src="{{ asset('storage/' . $image_url) }}" class="w-64 h-40 object-cover rounded-lg border mt-3">
                    @endif
                </div>

                {{-- Empat Foto Wajib --}}
                <div class="space-y-6 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Empat Foto Kurikulum" size="lg" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Foto 1 --}}
                        <div>
                            <x-molecules.input-field label="Judul Foto 1" wire:model="photo_1_title" />
                            <input type="file" wire:model="photo_1" class="w-full mt-2 border-gray-300 rounded-md" />
                            @if($photo_1)
                                <img src="{{ $photo_1->temporaryUrl() }}" class="w-full h-40 object-cover rounded-lg mt-3 border">
                            @elseif($photo_1_url)
                                <img src="{{ asset('storage/' . $photo_1_url) }}" class="w-full h-40 object-cover rounded-lg mt-3 border">
                            @endif
                        </div>

                        {{-- Foto 2 --}}
                        <div>
                            <x-molecules.input-field label="Judul Foto 2" wire:model="photo_2_title" />
                            <input type="file" wire:model="photo_2" class="w-full mt-2 border-gray-300 rounded-md" />
                            @if($photo_2)
                                <img src="{{ $photo_2->temporaryUrl() }}" class="w-full h-40 object-cover rounded-lg mt-3 border">
                            @elseif($photo_2_url)
                                <img src="{{ asset('storage/' . $photo_2_url) }}" class="w-full h-40 object-cover rounded-lg mt-3 border">
                            @endif
                        </div>

                        {{-- Foto 3 --}}
                        <div>
                            <x-molecules.input-field label="Judul Foto 3" wire:model="photo_3_title" />
                            <input type="file" wire:model="photo_3" class="w-full mt-2 border-gray-300 rounded-md" />
                            @if($photo_3)
                                <img src="{{ $photo_3->temporaryUrl() }}" class="w-full h-40 object-cover rounded-lg mt-3 border">
                            @elseif($photo_3_url)
                                <img src="{{ asset('storage/' . $photo_3_url) }}" class="w-full h-40 object-cover rounded-lg mt-3 border">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-4">
                    <x-atoms.button type="submit" theme="dark" heroicon="check" :isLoading="$isSaving" class="bg-lime-600 hover:bg-lime-700 flex-1">
                        Simpan Perubahan
                    </x-atoms.button>

                    <x-atoms.button type="button" wire:click="loadData" variant="outline" theme="dark" heroicon="arrow-path">
                        Batal
                    </x-atoms.button>
                </div>
            </form>
        </x-atoms.card>
    @endif

    {{-- Overlay loading --}}
    <div wire:loading wire:target="save,loadData" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-xl flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">Memproses...</span>
        </div>
    </div>
</div>
