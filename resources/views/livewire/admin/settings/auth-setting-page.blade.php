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
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Halaman Auth</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola gambar latar dan teks pada halaman Login & Register</p>
        </div>
        <x-atoms.button wire:click="edit" variant="primary" size="md">
            <i class="ri-edit-line mr-2"></i> Edit
        </x-atoms.button>
    </div>

    {{-- Current Auth Setting Display --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($authSetting)
            {{-- Image Previews Grid --}}
            <div class="grid grid-cols-1 gap-4 p-4">
                {{-- Desktop Image Preview --}}
                <div class="relative">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="ri-image-line text-gray-500"></i>
                        <span class="text-sm font-medium text-gray-700">Gambar Background</span>
                    </div>
                    @if($authSetting->image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $authSetting->image) }}" alt="Hero Background" class="w-full h-64 object-cover rounded-lg border border-gray-200">
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                            <i class="ri-image-line text-3xl text-gray-400 mb-2"></i>
                            <span class="text-sm text-gray-500">Belum ada gambar background</span>
                            <span class="text-xs text-gray-400 mt-1">(Akan menggunakan gambar bawaan)</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Content Section --}}
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Judul Utama</h3>
                        <p class="text-lg font-bold text-gray-900">{{ $authSetting->title ?: '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sub Judul (Tahun Ajaran)</h3>
                        <p class="text-lg font-bold text-lime-600">{{ $authSetting->subtitle ?: '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Deskripsi</h3>
                        <p class="text-md font-medium text-gray-700">{{ $authSetting->description ?: '-' }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="p-8 text-center">
                <i class="ri-settings-4-line text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4">Belum ada pengaturan custom untuk Halaman Auth</p>
                <x-atoms.button wire:click="edit" variant="primary" size="md">
                    <i class="ri-add-line mr-2"></i> Buat Pengaturan
                </x-atoms.button>
            </div>
        @endif
    </div>

    {{-- Edit Modal --}}
    <x-atoms.modal name="auth-setting-modal" maxWidth="2xl">
        <form wire:submit.prevent="save" class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Pengaturan Auth</h3>

            <div class="space-y-4">
                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama</label>
                    <input type="text" wire:model="title"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                           placeholder="Contoh: Selamat Datang di SPMB">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Subtitle --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub Judul (Tahun Ajaran)</label>
                    <input type="text" wire:model="subtitle"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                           placeholder="Contoh: 2026/2027">
                    @error('subtitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" wire:model="description"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                           placeholder="Contoh: Sistem Penerimaan Murid Baru">
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Background Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Background</label>
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
                    <p class="text-xs text-gray-500 mt-1">Ukuran maksimal 5MB. Format: JPG, PNG</p>
                    @error('new_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
