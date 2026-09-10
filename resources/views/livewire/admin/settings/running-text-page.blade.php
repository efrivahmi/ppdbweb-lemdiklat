<div>
    <x-atoms.breadcrumb current-path="Running Text" />
    <div class="mt-4 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Manajemen Running Text</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola teks berjalan yang akan ditampilkan di halaman Login</p>
            </div>
            <x-atoms.button wire:click="openModal" variant="primary" heroicon="plus" shadow="sm">
                Tambah Teks
            </x-atoms.button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm">
                        <th class="p-4 font-semibold text-gray-600 w-16">No</th>
                        <th class="p-4 font-semibold text-gray-600">Teks</th>
                        <th class="p-4 font-semibold text-gray-600 w-32">Status</th>
                        <th class="p-4 font-semibold text-gray-600 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($texts as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 text-gray-900">{{ $index + 1 }}</td>
                            <td class="p-4 text-gray-600">{{ $item->text }}</td>
                            <td class="p-4">
                                <button wire:click="toggleActive({{ $item->id }})" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-green-500' : 'bg-gray-500' }} mr-1.5"></span>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="openModal({{ $item->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus teks ini?" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ri-message-3-line text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-sm">Belum ada running text yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl transform transition-all">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $isEdit ? 'Edit Running Text' : 'Tambah Running Text' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500 focus:outline-none p-1 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
                
                <form wire:submit.prevent="save">
                    <div class="p-6 space-y-4">
                        <x-molecules.input-field 
                            label="Teks Berjalan" 
                            inputType="text" 
                            name="text" 
                            id="text"
                            placeholder="Masukkan pesan yang ingin ditampilkan..." 
                            wire:model.defer="text" 
                            :error="$errors->first('text')" 
                            required />
                            
                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" id="is_active" wire:model.defer="is_active" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                            <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">Aktifkan teks ini</label>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl border-t border-gray-100">
                        <x-atoms.button type="button" wire:click="closeModal" variant="secondary">
                            Batal
                        </x-atoms.button>
                        <x-atoms.button type="submit" variant="primary">
                            Simpan
                        </x-atoms.button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
