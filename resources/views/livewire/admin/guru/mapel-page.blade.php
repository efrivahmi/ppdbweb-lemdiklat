<div>
    {{-- Breadcrumb --}}
    <x-atoms.breadcrumb currentPath="Mata Pelajaran" />

    {{-- Main Card Container --}}
    <x-atoms.card className="mt-3">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Mata Pelajaran" size="xl" />

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari mata pelajaran..."
                    className="md:w-48" />

                <x-atoms.button wire:click="create" variant="success" heroicon="plus" className="whitespace-nowrap">
                    Tambah Mata Pelajaran
                </x-atoms.button>
            </div>
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama Mata Pelajaran</th>
                        <th scope="col" class="px-6 py-3">Jumlah Guru</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($mapels->count() > 0)
                        @foreach ($mapels as $index => $mapel)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                        {{ ($mapels->currentPage() - 1) * $mapels->perPage() + $index + 1 }}
                                    </x-atoms.description>
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.title text="{{ $mapel->mapel_name }}" size="sm" class="text-gray-900" />
                                </td>
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        <x-heroicon-o-users class="w-3 h-3 mr-1" />
                                        {{ $mapel->users_count }} Guru
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $mapel->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $mapel->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button wire:click="edit({{ $mapel->id }})" variant="outline"
                                            theme="dark" size="sm" heroicon="pencil"
                                            class="text-lime-600 border-lime-600 hover:bg-lime-600 hover:text-white">
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button wire:click="delete({{ $mapel->id }})"
                                            onclick="return confirm('Yakin ingin menghapus mata pelajaran ini?')"
                                            variant="outline" theme="dark" size="sm" heroicon="trash"
                                            class="text-red-600 border-red-600 hover:bg-red-600 hover:text-white">
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
                                    <x-heroicon-o-academic-cap class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2" :text="$search ? 'Tidak ditemukan mata pelajaran sesuai pencarian' : 'Belum ada data mata pelajaran'" />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search)
                                            Coba ubah kata kunci pencarian yang digunakan
                                        @else
                                            Mulai dengan menambahkan mata pelajaran baru
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
        @if ($mapels->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $mapels->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal --}}
    <x-atoms.modal name="mapel-modal" maxWidth="lg" :closeable="true">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title :text="$editMode ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran'" size="lg" class="text-gray-900" />
        </div>

        {{-- Modal Content --}}
        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- Name Field --}}
                <x-molecules.input-field label="Nama Mata Pelajaran" name="mapel_name" placeholder="Masukan nama mata pelajaran"
                    wire:model="mapel_name" :error="$errors->first('mapel_name')" required />

                {{-- Info Text --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" />
                        <div>
                            <x-atoms.description size="sm" class="text-blue-800 font-medium mb-1">
                                Informasi Penting
                            </x-atoms.description>
                            <x-atoms.description size="xs" class="text-blue-700">
                                Mata pelajaran yang sudah digunakan oleh guru tidak dapat dihapus. Pastikan nama mata pelajaran sudah benar sebelum menyimpan.
                            </x-atoms.description>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button wire:click="save" variant="primary" theme="dark" heroicon="check" isFullWidth
                class="bg-lime-600 hover:bg-lime-700">
                {{ $editMode ? 'Update' : 'Simpan' }}
            </x-atoms.button>
            <x-atoms.button wire:click="cancel" variant="secondary" theme="dark" heroicon="x-mark" isFullWidth
                class="bg-gray-500 hover:bg-gray-600">
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>