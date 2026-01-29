<div>
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2 mb-4">
            <i class="ri-check-line text-lg"></i>
            {{ session('message') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hero Beranda</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola tampilan hero section di halaman beranda</p>
        </div>
        <x-atoms.button wire:click="edit" variant="primary" size="md">
            <i class="ri-edit-line mr-2"></i> Edit
        </x-atoms.button>
    </div>

    {{-- Current Profile Display --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($profileSekolah)
            {{-- Image Previews Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
                {{-- Desktop Image Preview --}}
                <div class="relative">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="ri-computer-line text-gray-500"></i>
                        <span class="text-sm font-medium text-gray-700">Desktop View</span>
                    </div>
                    @if($profileSekolah->image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $profileSekolah->image) }}" alt="Hero Desktop" class="w-full h-48 object-cover rounded-lg border border-gray-200">
                            {{-- Badge overlay --}}
                            @if($profileSekolah->badge)
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-lime-500 text-white text-xs font-medium rounded-full">
                                        {{ $profileSekolah->badge }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                            <i class="ri-image-line text-3xl text-gray-400 mb-2"></i>
                            <span class="text-sm text-gray-500">Belum ada gambar desktop</span>
                        </div>
                    @endif
                </div>

                {{-- Mobile Image Preview --}}
                <div class="relative">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="ri-smartphone-line text-gray-500"></i>
                        <span class="text-sm font-medium text-gray-700">Mobile View</span>
                    </div>
                    @if($profileSekolah->mobile_image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $profileSekolah->mobile_image) }}" alt="Hero Mobile" class="w-full h-48 object-cover rounded-lg border border-gray-200">
                            {{-- Badge overlay --}}
                            @if($profileSekolah->badge)
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-lime-500 text-white text-xs font-medium rounded-full">
                                        {{ $profileSekolah->badge }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                            <i class="ri-smartphone-line text-3xl text-gray-400 mb-2"></i>
                            <span class="text-sm text-gray-500">Belum ada gambar mobile</span>
                            <span class="text-xs text-gray-400 mt-1">(Akan menggunakan gambar desktop)</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Content Section --}}
            <div class="p-6 border-t border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $profileSekolah->title }}</h2>
                <div class="text-gray-600 prose max-w-none">
                    {!! nl2br(e($profileSekolah->content)) !!}
                </div>
            </div>
        @else
            <div class="p-8 text-center">
                <i class="ri-file-info-line text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4">Belum ada data hero beranda</p>
                <x-atoms.button wire:click="edit" variant="primary" size="md">
                    <i class="ri-add-line mr-2"></i> Tambah Data
                </x-atoms.button>
            </div>
        @endif
    </div>

    {{-- Edit Modal --}}
    <x-atoms.modal name="profile-modal" maxWidth="2xl">
        <form wire:submit.prevent="save" class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Hero Beranda</h3>

            <div class="space-y-4">
                {{-- Badge --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                    <input type="text" wire:model="badge"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                           placeholder="Contoh: Pendaftaran Dibuka">
                    @error('badge') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="title"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                           placeholder="Judul hero section">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten <span class="text-red-500">*</span></label>
                    <textarea wire:model="content" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                              placeholder="Deskripsi untuk hero section"></textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Desktop Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Desktop</label>
                    @if($image)
                        <div class="mb-2 relative inline-block">
                            <img src="{{ asset('storage/' . $image) }}" alt="Current Image" class="h-32 rounded-lg object-cover">
                            <button type="button" wire:click="deleteImage" 
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    @endif
                    <input type="file" wire:model="new_image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500">
                    <p class="text-xs text-gray-500 mt-1">Ukuran maksimal 2MB. Format: JPG, PNG</p>
                    @error('new_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Mobile Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Mobile (Opsional)</label>
                    @if($mobile_image)
                        <div class="mb-2 relative inline-block">
                            <img src="{{ asset('storage/' . $mobile_image) }}" alt="Current Mobile Image" class="h-32 rounded-lg object-cover">
                            <button type="button" wire:click="deleteMobileImage" 
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    @endif
                    <input type="file" wire:model="new_mobile_image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500">
                    <p class="text-xs text-gray-500 mt-1">Tampilan untuk layar mobile. Ukuran maksimal 2MB</p>
                    @error('new_mobile_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                <x-atoms.button type="button" wire:click="closeModal" variant="secondary" size="md">
                    Batal
                </x-atoms.button>
                <x-atoms.button type="submit" variant="primary" size="md">
                    <i class="ri-save-line mr-2"></i> Simpan
                </x-atoms.button>
            </div>
        </form>
    </x-atoms.modal>
</div>