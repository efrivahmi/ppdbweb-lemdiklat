<div>
    <x-atoms.breadcrumb currentPath="Alur Pendaftaran" />

    <div class="mb-6 flex justify-between items-center">
        <x-atoms.title text="Kelola Alur Pendaftaran" size="xl" />
        <x-atoms.button 
            type="button" 
            variant="primary" 
            heroicon="plus" 
            wire:click="create"
        >
            Tambah Langkah
        </x-atoms.button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Table Header & Search -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="w-full sm:w-96 relative">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Cari alur pendaftaran..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 w-16">Urutan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 w-24">Ikon</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Judul</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Deskripsi</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($alurPendaftarans as $alur)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium text-center">
                                {{ $alur->order_num }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <x-dynamic-component :component="'heroicon-o-' . $alur->icon" class="w-6 h-6" />
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $alur->title }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 line-clamp-2">
                                {{ $alur->description }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="edit({{ $alur->id }})" 
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click="delete({{ $alur->id }})"
                                            wire:confirm="Yakin ingin menghapus langkah ini?"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="ri-route-line text-2xl text-gray-400"></i>
                                    </div>
                                    <x-atoms.title text="Tidak ada data alur pendaftaran" size="md" className="text-gray-500 mb-2" />
                                    <p class="text-sm text-gray-400">
                                        @if($search)
                                            Tidak ditemukan data sesuai pencarian "{{ $search }}"
                                        @else
                                            Belum ada data alur pendaftaran
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($alurPendaftarans->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $alurPendaftarans->links('vendor.livewire.tailwind') }}
            </div>
        @endif
    </div>

    <!-- Modal Form -->
    <x-atoms.modal name="alur-pendaftaran-modal" maxWidth="lg">
        <form wire:submit="save">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $editMode ? 'Edit Langkah' : 'Tambah Langkah' }}
                </h3>
                <button type="button" wire:click="cancel" class="text-gray-400 hover:text-gray-500 transition-colors">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-5">
                <!-- Urutan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Urutan
                    </label>
                    <input type="number" wire:model="order_num" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('order_num') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Judul Langkah
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="title" 
                           placeholder="Contoh: Daftar Akun"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('title') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Ikon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Ikon (Heroicon)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-3">
                        @if($icon)
                            <div class="w-10 h-10 shrink-0 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                                <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6" />
                            </div>
                        @endif
                        <select wire:model.live="icon" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">-- Pilih Ikon --</option>
                            @foreach($availableIcons as $availableIcon)
                                <option value="{{ $availableIcon }}">{{ $availableIcon }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('icon') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="description" rows="4"
                              placeholder="Deskripsi langkah pendaftaran..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none"></textarea>
                    @error('description') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" wire:click="cancel"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-lg hover:bg-emerald-700 transition-colors flex items-center gap-2">
                    <div wire:loading wire:target="save" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    Simpan
                </button>
            </div>
        </form>
    </x-atoms.modal>
</div>
