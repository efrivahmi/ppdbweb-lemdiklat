<div class="">
    <x-atoms.breadcrumb currentPath="Struktur Sekolah" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <x-atoms.title text="Foto Bagan Organisasi" size="xl"/>
                <x-atoms.description class="text-gray-600">
                    Kelola foto bagan organisasi yang ditampilkan di halaman publik
                </x-atoms.description>
            </div>

            <x-atoms.button wire:click="editFotoStruktur" variant="primary" heroicon="photo" className="whitespace-nowrap">
                {{ $fotoStruktur ? 'Edit Foto' : 'Tambah Foto' }}
            </x-atoms.button>
        </div>

        @if ($fotoStruktur)
            <div class="bg-gradient-to-br from-lime-50 to-green-50 rounded-xl p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                    <div class="lg:col-span-1">
                        <x-atoms.title text="{{ $fotoStruktur->nama }}" size="lg" class="text-gray-800 mb-2" />
                        <x-atoms.description class="text-gray-600 mb-4">
                            Status: <span class="text-green-600 font-semibold">Aktif</span>
                        </x-atoms.description>
                        <div class="flex gap-2">
                            <x-atoms.button wire:click="editFotoStruktur" variant="primary" theme="dark"
                                size="sm" heroicon="pencil">
                                Edit
                            </x-atoms.button>
                            <x-atoms.button wire:click="deleteFotoStruktur" variant="danger" theme="dark"
                                size="sm" heroicon="trash">
                                Hapus
                            </x-atoms.button>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        @if ($fotoStruktur->img)
                            <div class="relative group">
                                <img src="{{ $fotoStruktur->image_url }}" alt="{{ $fotoStruktur->nama }}"
                                    class="w-full h-48 object-cover rounded-lg shadow-lg border border-gray-200">
                            </div>
                        @else
                            <div
                                class="w-full h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <div class="text-center">
                                    <x-heroicon-o-photo class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                                    <x-atoms.description class="text-gray-500">Belum ada foto</x-atoms.description>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-8 text-center">
                <x-heroicon-o-photo class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                <x-atoms.title text="Belum Ada Foto Bagan Organisasi" size="lg" align="center" class="text-gray-600 mb-2" />
                <x-atoms.description class="text-gray-500 mb-4">
                    Tambahkan foto bagan organisasi untuk ditampilkan di halaman publik
                </x-atoms.description>
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Struktur Sekolah" size="xl" />

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari nama atau jabatan..."
                    className="md:w-48" />

                <x-atoms.button wire:click="create" variant="success" heroicon="plus" className="whitespace-nowrap">
                    Tambah Struktur
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Posisi</th>
                        <th scope="col" class="px-6 py-3">Foto</th>
                        <th scope="col" class="px-6 py-3">Nama & Jabatan</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($strukturs->count() > 0)
                        @foreach ($strukturs as $struktur)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-lime-100 rounded-full flex items-center justify-center">
                                            <span class="text-lime-600 font-bold text-sm">{{ $struktur->posisi }}</span>
                                        </div>
                                        @if ($struktur->posisi === 1)
                                            <x-atoms.badge text="Tertinggi" variant="gold" size="sm" />
                                        @elseif($struktur->posisi <= 5)
                                            <x-atoms.badge text="Pimpinan" variant="sky" size="sm" />
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($struktur->img)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $struktur->img) }}"
                                                alt="{{ $struktur->nama }}"
                                                class="w-16 h-16 rounded-full object-cover border-2 border-lime-200">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-full transition-opacity">
                                                <x-heroicon-o-eye class="w-5 h-5 text-white" />
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-full bg-lime-100 flex items-center justify-center border-2 border-lime-200">
                                            <x-heroicon-o-user class="w-8 h-8 text-lime-600" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.title text="{{ $struktur->nama }}" size="sm"
                                            class="text-gray-900 mb-1" />
                                        <x-atoms.badge text="{{ $struktur->jabatan }}" variant="emerald"
                                            size="sm" />
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <x-atoms.description size="sm" class="text-gray-600">
                                            {{ Str::limit($struktur->desc, 100) }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $struktur->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $struktur->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button wire:click="edit({{ $struktur->id }})" variant="primary"
                                            theme="dark" size="sm" heroicon="pencil">
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button wire:click="delete({{ $struktur->id }})" variant="danger"
                                            theme="dark" size="sm" heroicon="trash">
                                            Hapus
                                        </x-atoms.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-8 text-gray-500" colspan="6">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-user-group class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2" :text="$search
                                        ? 'Tidak ditemukan struktur sesuai pencarian'
                                        : 'Belum ada struktur sekolah'" />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search)
                                            Coba ubah kata kunci pencarian
                                        @else
                                            Mulai dengan menambahkan struktur sekolah
                                        @endif
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($strukturs->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $strukturs->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="struktur-modal" maxWidth="3xl" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-lime-100 rounded-full">
                    <x-heroicon-o-user-group class="w-6 h-6 text-lime-600" />
                </div>
                <x-atoms.title :text="$editMode ? 'Edit Struktur Sekolah' : 'Tambah Struktur Sekolah'" size="lg" class="text-gray-900" />
            </div>
        </div>

        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="bg-lime-50 rounded-xl p-4">
                    <x-atoms.title text="Informasi Personal" size="md" class="text-lime-800 mb-4" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-molecules.input-field label="Nama Lengkap" name="nama"
                            placeholder="Masukan nama lengkap" wire:model="nama" :error="$errors->first('nama')" required />

                        <x-molecules.input-field label="Jabatan" name="jabatan" placeholder="Masukan jabatan"
                            wire:model="jabatan" :error="$errors->first('jabatan')" required />
                    </div>
                </div>

                <div class="bg-sky-50 rounded-xl p-4">
                    <x-atoms.title text="Posisi dalam Hierarki" size="md" class="text-sky-800 mb-4" />

                    <x-molecules.input-field label="Posisi" name="posisi" inputType="number"
                        placeholder="Masukan nomor posisi (1 = tertinggi)" wire:model="posisi" :error="$errors->first('posisi')"
                        required />

                    <x-atoms.description size="xs" class="text-sky-600 mt-1">
                        Semakin kecil angka, semakin tinggi posisi dalam hierarki (1 = Kepala Sekolah, 2-5 = Wakil,
                        dst.)
                    </x-atoms.description>
                </div>

                <div class="bg-amber-50 rounded-xl p-4">
                    <x-atoms.title text="Foto Profil" size="md" class="text-amber-800 mb-4" />

                    @if ($editMode && $existingImg)
                        <div class="mb-4">
                            <x-atoms.description size="sm" class="text-amber-700 mb-2">
                                Foto saat ini:
                            </x-atoms.description>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $existingImg) }}" alt="Current Image"
                                    class="w-24 h-24 object-cover rounded-full border-2 border-amber-200">
                                <div class="absolute -top-1 -right-1 p-1 bg-amber-100 rounded-full">
                                    <x-heroicon-o-photo class="w-4 h-4 text-amber-600" />
                                </div>
                            </div>
                        </div>
                    @endif

                    <x-molecules.file-field label="Upload Foto Baru" name="img" accept="image/*" maxSize="2MB"
                        wire:model="img" :error="$errors->first('img')" className="mb-0" />

                    @if ($img)
                        <div class="mt-3">
                            <x-atoms.description size="sm" class="text-amber-700 mb-2">
                                Preview foto baru:
                            </x-atoms.description>
                            <div class="relative inline-block">
                                <img src="{{ $img->temporaryUrl() }}" alt="Preview"
                                    class="w-24 h-24 object-cover rounded-full border-2 border-amber-200">
                                <div class="absolute -top-1 -right-1 p-1 bg-green-100 rounded-full">
                                    <x-heroicon-o-check class="w-4 h-4 text-green-600" />
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="bg-purple-50 rounded-xl p-4">
                    <x-atoms.title text="Deskripsi Tugas" size="md" class="text-purple-800 mb-4" />

                    <x-molecules.textarea-field label="Deskripsi & Tanggung Jawab" name="desc"
                        placeholder="Masukan deskripsi tugas dan tanggung jawab..." :rows="4"
                        wire:model="desc" :error="$errors->first('desc')" required />

                    <x-atoms.description size="xs" class="text-purple-600 mt-1">
                        Jelaskan tugas pokok, tanggung jawab, dan wewenang dari posisi ini
                    </x-atoms.description>
                </div>
            </form>
        </div>

        <div class="flex gap-3 p-6 border-t border-gray-200 bg-gray-50">
            <x-atoms.button wire:click="save" variant="primary" theme="dark" heroicon="check" isFullWidth
                class="bg-lime-600 hover:bg-lime-700">
                {{ $editMode ? 'Update Struktur' : 'Simpan Struktur' }}
            </x-atoms.button>
            <x-atoms.button wire:click="cancel" variant="secondary" theme="dark" heroicon="x-mark" isFullWidth
                class="bg-gray-500 hover:bg-gray-600">
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>

    <x-atoms.modal name="foto-struktur-modal" maxWidth="2xl" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-full">
                    <x-heroicon-o-photo class="w-6 h-6 text-blue-600" />
                </div>
                <x-atoms.title :text="$editFotoMode ? 'Edit Foto Bagan Organisasi' : 'Tambah Foto Bagan Organisasi'" size="lg" class="text-gray-900" />
            </div>
        </div>

        <div class="p-6">
            <form wire:submit.prevent="saveFotoStruktur" class="space-y-6">
                <div class="bg-blue-50 rounded-xl p-4">
                    <x-atoms.title text="Informasi Foto" size="md" class="text-blue-800 mb-4" />

                    <x-molecules.input-field label="Nama/Judul Foto" name="fotoNama"
                        placeholder="Contoh: Bagan Organisasi Sekolah 2024" wire:model="fotoNama" :error="$errors->first('fotoNama')"
                        required />

                    <x-atoms.description size="xs" class="text-blue-600 mt-1">
                        Nama ini akan ditampilkan sebagai keterangan foto di halaman publik
                    </x-atoms.description>
                </div>

                <div class="bg-amber-50 rounded-xl p-4">
                    <x-atoms.title text="Upload Foto Bagan" size="md" class="text-amber-800 mb-4" />

                    @if ($editFotoMode && $existingFotoImg)
                        <div class="mb-4">
                            <x-atoms.description size="sm" class="text-amber-700 mb-2">
                                Foto saat ini:
                            </x-atoms.description>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $existingFotoImg) }}" alt="Current Photo"
                                    class="w-full max-w-md h-48 object-cover rounded-lg border-2 border-amber-200">
                                <div class="absolute top-2 right-2 p-1 bg-amber-100 rounded-full">
                                    <x-heroicon-o-photo class="w-4 h-4 text-amber-600" />
                                </div>
                            </div>
                        </div>
                    @endif

                    <x-molecules.file-field label="Upload Foto Bagan Baru" name="fotoImg" accept="image/*"
                        maxSize="5MB" wire:model="fotoImg" :error="$errors->first('fotoImg')" className="mb-0" />

                    @if ($fotoImg)
                        <div class="mt-3">
                            <x-atoms.description size="sm" class="text-amber-700 mb-2">
                                Preview foto baru:
                            </x-atoms.description>
                            <div class="relative inline-block">
                                <img src="{{ $fotoImg->temporaryUrl() }}" alt="Preview"
                                    class="w-full max-w-md h-48 object-cover rounded-lg border-2 border-amber-200">
                                <div class="absolute top-2 right-2 p-1 bg-green-100 rounded-full">
                                    <x-heroicon-o-check class="w-4 h-4 text-green-600" />
                                </div>
                            </div>
                        </div>
                    @endif

                    <x-atoms.description size="xs" class="text-amber-600 mt-2">
                        Rekomendasi: Gunakan gambar dengan rasio landscape untuk hasil terbaik
                    </x-atoms.description>
                </div>
            </form>
        </div>

        <div class="flex gap-3 p-6 border-t border-gray-200 bg-gray-50">
            <x-atoms.button wire:click="saveFotoStruktur" variant="primary" theme="dark" heroicon="check"
                isFullWidth class="bg-blue-600 hover:bg-blue-700">
                {{ $editFotoMode ? 'Update Foto' : 'Simpan Foto' }}
            </x-atoms.button>
            <x-atoms.button wire:click="cancelFotoStruktur" variant="secondary" theme="dark" heroicon="x-mark"
                isFullWidth class="bg-gray-500 hover:bg-gray-600">
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>
