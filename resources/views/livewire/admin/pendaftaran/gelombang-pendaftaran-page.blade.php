<div>
    <x-atoms.breadcrumb currentPath="Gelombang Pendaftaran" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Gelombang Pendaftaran" size="xl" />

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari gelombang pendaftaran..."
                    className="md:w-64" />

                <x-atoms.button
                    wire:click="create"
                    variant="success"
                    heroicon="plus"
                    className="whitespace-nowrap">
                    Tambah Gelombang
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama Gelombang</th>
                        <th scope="col" class="px-6 py-3">Pendaftaran</th>
                        <th scope="col" class="px-6 py-3">Ujian</th>
                        <th scope="col" class="px-6 py-3">Pengumuman</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($gelombangs->count() > 0)
                    @foreach ($gelombangs as $index => $gelombang)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ ($gelombangs->currentPage() - 1) * $gelombangs->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-lime-100 rounded-full flex items-center justify-center">
                                    <x-heroicon-o-calendar class="w-5 h-5 text-lime-600" />
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $gelombang->nama_gelombang }}</p>
                                    <p class="text-xs text-gray-500">Dibuat {{ $gelombang->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="font-medium text-gray-900">{{ $gelombang->pendaftaran_mulai->format('d M Y') }}</div>
                                <div class="text-gray-500">s/d {{ $gelombang->pendaftaran_selesai->format('d M Y') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="font-medium text-gray-900">{{ $gelombang->ujian_mulai->format('d M Y') }}</div>
                                <div class="text-gray-500">s/d {{ $gelombang->ujian_selesai->format('d M Y') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $gelombang->pengumuman_tanggal->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $status = $gelombang->status;
                            $badgeConfig = match($status) {
                            'pendaftaran' => ['text' => 'Pendaftaran', 'variant' => 'blue'],
                            'ujian' => ['text' => 'Ujian', 'variant' => 'orange'],
                            'pengumuman' => ['text' => 'Pengumuman', 'variant' => 'purple'],
                            'selesai' => ['text' => 'Selesai', 'variant' => 'gray'],
                            default => ['text' => 'Belum Dimulai', 'variant' => 'gray']
                            };
                            @endphp

                            <x-atoms.badge
                                text="{{ $badgeConfig['text'] }}"
                                variant="{{ $badgeConfig['variant'] }}"
                                size="sm" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-center">
                                <x-atoms.button
                                    wire:click="exportExcel({{ $gelombang->id }})"
                                    variant="success"
                                    theme="dark"
                                    size="sm"
                                    heroicon="arrow-down-tray"
                                    title="Export Excel">
                                    Excel
                                </x-atoms.button>

                                <x-atoms.button
                                    wire:click="edit({{ $gelombang->id }})"
                                    variant="primary"
                                    theme="dark"
                                    size="sm"
                                    heroicon="pencil">
                                    Edit
                                </x-atoms.button>

                                <x-atoms.button
                                    wire:click="delete({{ $gelombang->id }})"
                                    wire:confirm="Yakin ingin menghapus gelombang pendaftaran ini?"
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
                        <td class="text-center px-6 py-12 text-gray-500" colspan="7">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <x-heroicon-o-calendar class="w-8 h-8 text-gray-400" />
                                </div>
                                <div class="text-center">
                                    <x-atoms.title text="Tidak ada gelombang pendaftaran" size="md" className="text-gray-500 mb-2" />
                                    <x-atoms.description color="gray-400">
                                        @if ($search)
                                        Tidak ditemukan gelombang pendaftaran sesuai pencarian "{{ $search }}"
                                        @else
                                        Belum ada data gelombang pendaftaran
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

        @if ($gelombangs->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $gelombangs->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="gelombang-pendaftaran" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-calendar class="w-6 h-6 text-lime-600" />
                </div>
                <div>
                    <x-atoms.title
                        :text="$editMode ? 'Edit Gelombang Pendaftaran' : 'Tambah Gelombang Pendaftaran'"
                        size="lg" />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data gelombang pendaftaran' : 'Lengkapi form dibawah untuk menambahkan gelombang pendaftaran baru' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-5">
                <x-molecules.input-field
                    label="Nama Gelombang"
                    name="nama_gelombang"
                    wire:model="nama_gelombang"
                    placeholder="Contoh: Gelombang 1, Gelombang Januari, dll"
                    :required="true"
                    :error="$errors->first('nama_gelombang')" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-molecules.input-field
                        label="Pendaftaran Mulai"
                        inputType="datetime-local"
                        name="pendaftaran_mulai"
                        wire:model="pendaftaran_mulai"
                        :required="true"
                        :error="$errors->first('pendaftaran_mulai')" />

                    <x-molecules.input-field
                        label="Pendaftaran Selesai"
                        inputType="datetime-local"
                        name="pendaftaran_selesai"
                        wire:model="pendaftaran_selesai"
                        :required="true"
                        :error="$errors->first('pendaftaran_selesai')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-molecules.input-field
                        label="Ujian Mulai"
                        inputType="datetime-local"
                        name="ujian_mulai"
                        wire:model="ujian_mulai"
                        :required="true"
                        :error="$errors->first('ujian_mulai')" />

                    <x-molecules.input-field
                        label="Ujian Selesai"
                        inputType="datetime-local"
                        name="ujian_selesai"
                        wire:model="ujian_selesai"
                        :required="true"
                        :error="$errors->first('ujian_selesai')" />
                </div>

                <x-molecules.input-field
                    label="Tanggal Pengumuman"
                    inputType="datetime-local"
                    name="pengumuman_tanggal"
                    wire:model="pengumuman_tanggal"
                    :required="true"
                    :error="$errors->first('pengumuman_tanggal')" />

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

    <div wire:loading.flex wire:target="save,exportExcel" class="fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">
                <span wire:loading wire:target="save">
                    {{ $editMode ? 'Mengupdate gelombang pendaftaran...' : 'Menyimpan gelombang pendaftaran...' }}
                </span>
                <span wire:loading wire:target="exportExcel">
                    Mengexport data ke Excel...
                </span>
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