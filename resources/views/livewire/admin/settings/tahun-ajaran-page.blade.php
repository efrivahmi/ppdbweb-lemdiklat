<div>
    <x-atoms.breadcrumb currentPath="Tahun Ajaran" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Master Data Tahun Ajaran" size="xl" />

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari tahun ajaran..."
                    className="md:w-64" />

                <x-atoms.button
                    wire:click="create"
                    variant="success"
                    heroicon="plus"
                    className="whitespace-nowrap">
                    Tambah Tahun Ajaran
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-16">No</th>
                        <th scope="col" class="px-6 py-3">Nama Tahun Ajaran</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($tahunAjarans->count() > 0)
                    @foreach ($tahunAjarans as $index => $ta)
                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ ($tahunAjarans->currentPage() - 1) * $tahunAjarans->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $ta->nama_tahun }}
                        </td>
                        <td class="px-6 py-4">
                            @if($ta->is_active)
                                <x-atoms.badge text="Aktif" variant="success" size="sm" />
                            @else
                                <x-atoms.badge text="Tidak Aktif" variant="gray" size="sm" />
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-center">
                                <x-atoms.button
                                    wire:click="edit({{ $ta->id }})"
                                    variant="primary"
                                    theme="dark"
                                    size="sm"
                                    heroicon="pencil">
                                    Edit
                                </x-atoms.button>

                                <x-atoms.button
                                    wire:click="delete({{ $ta->id }})"
                                    wire:confirm="Yakin ingin menghapus Tahun Ajaran ini?"
                                    variant="danger"
                                    theme="dark"
                                    size="sm"
                                    heroicon="trash">
                                    Hapus
                                </x-atoms.button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="bg-white border-b border-gray-200">
                        <td class="text-center px-6 py-12 text-gray-500" colspan="4">
                            Tidak ada data Tahun Ajaran
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($tahunAjarans->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $tahunAjarans->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="tahun-ajaran-modal" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div>
                    <x-atoms.title
                        :text="$editMode ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran'"
                        size="lg" />
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-5">
                <x-molecules.input-field
                    label="Nama Tahun Ajaran"
                    name="nama_tahun"
                    wire:model="nama_tahun"
                    placeholder="Contoh: 2025/2026"
                    :required="true"
                    :error="$errors->first('nama_tahun')" />

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_active" wire:model="is_active" class="rounded border-gray-300 text-lime-600 focus:ring-lime-500">
                    <label for="is_active" class="text-sm text-gray-700">Aktif</label>
                </div>

                <div class="border-t pt-6 mt-6">
                    <div class="flex gap-3">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="save">
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
                            className="flex-1">
                            Batal
                        </x-atoms.button>
                    </div>
                </div>
            </form>
        </div>
    </x-atoms.modal>
</div>
