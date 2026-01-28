<div>
    <x-atoms.breadcrumb currentPath="Hero Profile" />

    <x-atoms.card className="mt-3">
        <div class="flex justify-between items-center mb-6">
            <x-atoms.title
                text="Hero Profile"
                size="xl"
                class="text-gray-900" />
            <x-atoms.button
                wire:click="edit"
                variant="success"
                theme="light"
                heroicon="pencil">
                {{ $heroProfile ? 'Edit Gambar' : 'Upload Gambar' }}
            </x-atoms.button>
        </div>

        @if($heroProfile && $heroProfile->image)
        <div class="space-y-6">
            {{-- Gambar --}}
            <div class="relative">
                <img src="{{ asset('storage/' . $heroProfile->image) }}"
                    alt="Hero Profile"
                    class="w-full h-96 object-cover rounded-lg border border-gray-200 shadow-md">
                <div class="absolute top-4 right-4">
                    <x-atoms.button
                        wire:click="deleteImage"
                        onclick="return confirm('Yakin ingin menghapus gambar?')"
                        variant="danger"
                        size="sm"
                        rounded="full"
                        heroicon="trash"
                        class="shadow-lg" />
                </div>
            </div>

            {{-- Info waktu --}}
            <div class="flex items-center justify-between text-sm text-gray-500 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-4">
                    <span class="flex items-center">
                        <x-heroicon-o-calendar class="w-4 h-4 mr-1" />
                        Dibuat: {{ $heroProfile->created_at->format('d M Y H:i') }}
                    </span>
                    @if($heroProfile->updated_at != $heroProfile->created_at)
                    <span class="flex items-center">
                        <x-heroicon-o-arrow-path class="w-4 h-4 mr-1" />
                        Diperbarui: {{ $heroProfile->updated_at->format('d M Y H:i') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @else
        {{-- Jika belum ada data --}}
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <x-heroicon-o-photo class="w-12 h-12 text-gray-400" />
            </div>
            <x-atoms.title text="Belum Ada Gambar Hero Profile" size="lg" class="text-gray-900 mb-2" align="center" />
            <x-atoms.description class="text-gray-600 mb-6">
                Upload gambar untuk ditampilkan di halaman Hero Profile.
            </x-atoms.description>
            <center>
                <x-atoms.button
                    wire:click="edit"
                    variant="success"
                    theme="light"
                    size="lg"
                    heroicon="plus">
                    Upload Gambar
                </x-atoms.button>
            </center>
        </div>
        @endif
    </x-atoms.card>

    {{-- Modal --}}
    <x-atoms.modal name="hero-Profile-modal" maxWidth="lg" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title
                :text="$heroProfile ? 'Edit Gambar Hero Profile' : 'Upload Gambar Hero Profile'"
                size="lg"
                class="text-gray-900" />
        </div>

        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- Upload gambar --}}
                <div class="space-y-3">
                    <x-atoms.label for="new_image">Gambar Hero Profile</x-atoms.label>

                    @if($image)
                    <div class="mb-3">
                        <x-atoms.description size="sm" class="text-gray-600 mb-2">
                            Gambar saat ini:
                        </x-atoms.description>
                        <img src="{{ asset('storage/' . $image) }}"
                            alt="Current Image"
                            class="w-full h-48 object-cover rounded-lg border border-gray-200">
                    </div>
                    @endif

                    <x-molecules.file-field
                        name="new_image"
                        accept="image/*"
                        maxSize="2MB"
                        wire:model="new_image"
                        :error="$errors->first('new_image')"
                        className="mb-0" />

                    @if($new_image)
                    <div class="mt-3">
                        <x-atoms.description size="sm" class="text-gray-600 mb-2">
                            Preview gambar baru:
                        </x-atoms.description>
                        <img src="{{ $new_image->temporaryUrl() }}"
                            alt="Preview"
                            class="w-full h-48 object-cover rounded-lg border border-gray-200">
                    </div>
                    @endif

                    <x-atoms.description size="xs" class="text-gray-500">
                        Format: JPG, PNG, JPEG. Maksimal 2MB. Rekomendasi ukuran: 1920x1080px
                    </x-atoms.description>
                </div>
            </form>
        </div>

        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button
                wire:click="save"
                variant="success"
                theme="dark"
                heroicon="check"
                isFullWidth>
                {{ $heroProfile ? 'Update Gambar' : 'Simpan Gambar' }}
            </x-atoms.button>
            <x-atoms.button
                wire:click="cancel"
                variant="secondary"
                theme="dark"
                heroicon="x-mark"
                isFullWidth>
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>