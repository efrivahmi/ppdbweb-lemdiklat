<div>
    <x-atoms.breadcrumb currentPath="Jadwal Ujian Khusus" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <x-atoms.title text="Jadwal Ujian Khusus" size="xl" />
                <x-atoms.description size="sm" color="gray-500">
                    Kelola jadwal ujian urgent untuk siswa tertentu
                </x-atoms.description>
            </div>

            <x-atoms.button
                wire:click="openModal"
                variant="success"
                heroicon="plus"
                className="whitespace-nowrap">
                Tambah Jadwal
            </x-atoms.button>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama Jadwal</th>
                        <th scope="col" class="px-6 py-3">Waktu</th>
                        <th scope="col" class="px-6 py-3">Siswa</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($jadwals->count() > 0)
                    @foreach ($jadwals as $index => $jadwal)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ ($jadwals->currentPage() - 1) * $jadwals->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <x-heroicon-o-clock class="w-5 h-5 text-orange-600" />
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $jadwal->nama }}</p>
                                    @if($jadwal->deskripsi)
                                    <p class="text-xs text-gray-500 line-clamp-1">{{ $jadwal->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="font-medium text-gray-900">{{ $jadwal->waktu_mulai->format('d M Y H:i') }}</div>
                                <div class="text-gray-500">s/d {{ $jadwal->waktu_selesai->format('d M Y H:i') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $jadwal->siswa_count }}</span>
                                <span class="text-gray-500">siswa</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $status = $jadwal->status;
                            $badgeConfig = match($status) {
                                'berlangsung' => ['text' => 'Berlangsung', 'variant' => 'green'],
                                'akan_datang' => ['text' => 'Akan Datang', 'variant' => 'blue'],
                                'selesai' => ['text' => 'Selesai', 'variant' => 'gray'],
                                'nonaktif' => ['text' => 'Nonaktif', 'variant' => 'red'],
                                default => ['text' => 'Unknown', 'variant' => 'gray']
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
                                    wire:click="openSiswaModal({{ $jadwal->id }})"
                                    variant="primary"
                                    size="sm"
                                    heroicon="users">
                                    Siswa
                                </x-atoms.button>

                                <x-atoms.button
                                    wire:click="edit({{ $jadwal->id }})"
                                    variant="warning"
                                    theme="dark"
                                    size="sm"
                                    heroicon="pencil">
                                    Edit
                                </x-atoms.button>

                                <x-atoms.button
                                    wire:click="toggleActive({{ $jadwal->id }})"
                                    variant="{{ $jadwal->is_active ? 'gray' : 'success' }}"
                                    theme="dark"
                                    size="sm"
                                    heroicon="{{ $jadwal->is_active ? 'pause' : 'play' }}">
                                    {{ $jadwal->is_active ? 'Off' : 'On' }}
                                </x-atoms.button>

                                <x-atoms.button
                                    wire:click="delete({{ $jadwal->id }})"
                                    wire:confirm="Yakin ingin menghapus jadwal ini? Semua siswa yang terdaftar akan dihapus dari jadwal."
                                    variant="danger"
                                    theme="dark"
                                    size="sm"
                                    heroicon="trash">
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
                                    <x-heroicon-o-clock class="w-8 h-8 text-gray-400" />
                                </div>
                                <div class="text-center">
                                    <x-atoms.title text="Belum ada jadwal ujian khusus" size="md" className="text-gray-500 mb-2" />
                                    <x-atoms.description color="gray-400">
                                        Klik tombol "Tambah Jadwal" untuk membuat jadwal ujian urgent
                                    </x-atoms.description>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($jadwals->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $jadwals->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </x-atoms.card>

    {{-- Modal Create/Edit Jadwal --}}
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center p-4" wire:click.self="closeModal">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg" wire:click.stop>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <x-heroicon-o-clock class="w-6 h-6 text-orange-600" />
                    </div>
                    <div>
                        <x-atoms.title
                            :text="$editingId ? 'Edit Jadwal Ujian Khusus' : 'Tambah Jadwal Ujian Khusus'"
                            size="lg" />
                        <x-atoms.description size="sm" color="gray-500">
                            {{ $editingId ? 'Perbarui data jadwal' : 'Buat jadwal urgent untuk siswa tertentu' }}
                        </x-atoms.description>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="space-y-5">
                    <x-molecules.input-field
                        label="Nama Jadwal"
                        name="nama"
                        wire:model="nama"
                        placeholder="Contoh: Ujian Susulan Batch 1"
                        :required="true"
                        :error="$errors->first('nama')" />

                    <x-molecules.input-field
                        label="Deskripsi"
                        inputType="textarea"
                        name="deskripsi"
                        wire:model="deskripsi"
                        placeholder="Keterangan tambahan (opsional)"
                        :error="$errors->first('deskripsi')" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-molecules.input-field
                            label="Waktu Mulai"
                            inputType="datetime-local"
                            name="waktu_mulai"
                            wire:model="waktu_mulai"
                            :required="true"
                            :error="$errors->first('waktu_mulai')" />

                        <x-molecules.input-field
                            label="Waktu Selesai"
                            inputType="datetime-local"
                            name="waktu_selesai"
                            wire:model="waktu_selesai"
                            :required="true"
                            :error="$errors->first('waktu_selesai')" />
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-lime-600 focus:ring-lime-500">
                        <label for="is_active" class="text-sm text-gray-700">Aktifkan jadwal ini</label>
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
                                    {{ $editingId ? 'Update' : 'Simpan' }}
                                </span>
                                <span wire:loading wire:target="save">
                                    Menyimpan...
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
        </div>
    </div>
    @endif

    {{-- Modal Manage Siswa --}}
    @if($showSiswaModal && $selectedJadwal)
    <div class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center p-4" wire:click.self="closeSiswaModal">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col" wire:click.stop>
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <x-heroicon-o-users class="w-5 h-5 text-blue-600" />
                        </div>
                        <div>
                            <x-atoms.title text="Kelola Siswa" size="lg" />
                            <x-atoms.description size="sm" color="gray-500">
                                {{ $selectedJadwal->nama }}
                            </x-atoms.description>
                        </div>
                    </div>
                    <button wire:click="closeSiswaModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <x-heroicon-o-x-mark class="w-5 h-5 text-gray-500" />
                    </button>
                </div>
            </div>

            <div class="p-6 flex-1 overflow-y-auto">
                {{-- Search Siswa --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari & Tambah Siswa</label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="searchSiswa"
                        placeholder="Ketik nama, email, atau NISN siswa..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-lime-500 focus:border-lime-500">

                    @if(count($searchResults) > 0)
                    <div class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                        @foreach($searchResults as $siswa)
                        <div class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 border-b last:border-b-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $siswa->name }}</p>
                                <p class="text-sm text-gray-500">{{ $siswa->email }} @if($siswa->nisn)• {{ $siswa->nisn }}@endif</p>
                            </div>
                            <x-atoms.button
                                wire:click="addSiswa({{ $siswa->id }})"
                                variant="success"
                                size="sm"
                                heroicon="plus">
                                Tambah
                            </x-atoms.button>
                        </div>
                        @endforeach
                    </div>
                    @elseif(strlen($searchSiswa) >= 2)
                    <p class="mt-2 text-sm text-gray-500">Tidak ditemukan siswa dengan kata kunci "{{ $searchSiswa }}"</p>
                    @endif
                </div>

                {{-- Assigned Students --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Siswa Terdaftar ({{ $selectedJadwal->siswa->count() }})
                    </label>

                    @if($selectedJadwal->siswa->count() > 0)
                    <div class="border border-gray-200 rounded-lg divide-y">
                        @foreach($selectedJadwal->siswa as $siswa)
                        <div class="flex items-center justify-between px-4 py-3 hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                <img src="{{ $siswa->profile_photo_url }}" alt="{{ $siswa->name }}" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $siswa->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $siswa->email }}</p>
                                </div>
                            </div>
                            <x-atoms.button
                                wire:click="removeSiswa({{ $siswa->id }})"
                                wire:confirm="Hapus {{ $siswa->name }} dari jadwal ini?"
                                variant="danger"
                                theme="light"
                                size="sm"
                                heroicon="trash">
                            </x-atoms.button>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 border border-dashed border-gray-300 rounded-lg">
                        <x-heroicon-o-user-group class="w-12 h-12 text-gray-300 mx-auto mb-2" />
                        <p class="text-gray-500">Belum ada siswa yang terdaftar</p>
                        <p class="text-sm text-gray-400">Gunakan pencarian di atas untuk menambah siswa</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="p-6 border-t bg-gray-50">
                <x-atoms.button
                    wire:click="closeSiswaModal"
                    variant="gray"
                    className="w-full"
                    heroicon="check">
                    Selesai
                </x-atoms.button>
            </div>
        </div>
    </div>
    @endif

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="save,delete,toggleActive,addSiswa,removeSiswa" class="fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">Memproses...</span>
        </div>
    </div>
</div>
