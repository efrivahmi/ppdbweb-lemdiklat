<div>
    <x-atoms.breadcrumb currentPath="Rekening Bank" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Rekening Bank" size="xl" />
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari rekening bank..."
                    className="md:w-64"
                />

                <x-atoms.button
                    wire:click="create"
                    variant="success"
                    heroicon="plus"
                    className="whitespace-nowrap"
                >
                    Tambah Rekening
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Bank</th>
                        <th scope="col" class="px-6 py-3">Nomor Rekening</th>
                        <th scope="col" class="px-6 py-3">Pemegang Rekening</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($bankAccounts->count() > 0)
                        @foreach ($bankAccounts as $index => $account)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ ($bankAccounts->currentPage() - 1) * $bankAccounts->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-lime-100 rounded-full flex items-center justify-center">
                                            <x-heroicon-o-building-library class="w-5 h-5 text-lime-600" />
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $account->bank_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-heroicon-o-credit-card class="w-4 h-4 text-gray-400" />
                                        <span class="font-mono text-gray-900">{{ $account->account_number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
                                        <span class="text-gray-900">{{ $account->account_holder }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <x-heroicon-o-calendar-days class="w-4 h-4 text-gray-400 mr-2" />
                                        {{ $account->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button
                                            wire:click="edit({{ $account->id }})"
                                            variant="primary"
                                            theme="dark"
                                            size="sm"
                                            heroicon="pencil"
                                        >
                                            Edit
                                        </x-atoms.button>
                                        
                                        <x-atoms.button
                                            wire:click="delete({{ $account->id }})"
                                            wire:confirm="Yakin ingin menghapus rekening bank ini?"
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
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-12 text-gray-500" colspan="6">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-building-library class="w-8 h-8 text-gray-400" />
                                    </div>
                                    <div class="text-center">
                                        <x-atoms.title text="Tidak ada rekening bank" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400">
                                            @if ($search)
                                                Tidak ditemukan rekening bank sesuai pencarian "{{ $search }}"
                                            @else
                                                Belum ada data rekening bank
                                            @endif
                                        </x-atoms.description>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($bankAccounts->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $bankAccounts->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="bank-account" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-building-library class="w-6 h-6 text-lime-600" />
                </div>
                <div>
                    <x-atoms.title 
                        :text="$editMode ? 'Edit Rekening Bank' : 'Tambah Rekening Bank'" 
                        size="lg" 
                    />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data rekening bank' : 'Lengkapi form dibawah untuk menambahkan rekening bank baru' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-5">
                <x-molecules.input-field
                    label="Nama Bank"
                    name="bank_name"
                    wire:model="bank_name"
                    placeholder="Contoh: BCA, BNI, Mandiri, BRI"
                    :required="true"
                    :error="$errors->first('bank_name')"
                />

                <x-molecules.input-field
                    label="Nomor Rekening"
                    name="account_number"
                    wire:model="account_number"
                    placeholder="Masukkan nomor rekening"
                    :required="true"
                    :error="$errors->first('account_number')"
                />

                <x-molecules.input-field
                    label="Nama Pemegang Rekening"
                    name="account_holder"
                    wire:model="account_holder"
                    placeholder="Masukkan nama pemegang rekening"
                    :required="true"
                    :error="$errors->first('account_holder')"
                />

                <div class="border-t pt-6 mt-6">
                    <div class="flex gap-3">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >
                            <span wire:loading.remove wire:target="save">
                                {{ $editMode ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="save">
                                {{ $editMode ? 'Mengupdate...' : 'Menyimpan...' }}
                            </span>
                        </x-atoms.button>
                        
                        <x-atoms.button
                            type="button"
                            wire:click="closeModal"
                            variant="danger"
                            theme="light"
                            heroicon="x-mark"
                            className="flex-1"
                        >
                            Batal
                        </x-atoms.button>
                    </div>
                </div>
            </form>
        </div>
    </x-atoms.modal>

    <div wire:loading.flex wire:target="save" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">
                {{ $editMode ? 'Mengupdate rekening bank...' : 'Menyimpan rekening bank...' }}
            </span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('success', event => {
        console.log('Success:', event.detail.message);
    });
    
    window.addEventListener('error', event => {
        console.log('Error:', event.detail.message);
    });
</script>
@endpush