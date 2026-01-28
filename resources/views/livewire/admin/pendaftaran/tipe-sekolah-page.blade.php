<div>
    <x-atoms.breadcrumb currentPath="Jenjang Sekolah & Jurusan" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Jenjang Sekolah & Jurusan" size="xl" />
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari Jenjang Sekolah atau jurusan..."
                    className="md:w-64"
                />

                <div class="flex gap-2">
                    <x-atoms.button
                        wire:click="createTipe"
                        variant="success"
                        heroicon="plus"
                        size="sm"
                        className="whitespace-nowrap"
                    >
                        Tambah Jenjang
                    </x-atoms.button>
                    
                    <x-atoms.button
                        wire:click="createJurusan"
                        variant="success"
                        heroicon="plus"
                        size="sm"
                        className="whitespace-nowrap"
                    >
                        Tambah Jurusan
                    </x-atoms.button>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @if ($tipeSekolahs->count() > 0)
                @foreach ($tipeSekolahs as $tipe)
                    <div class="border border-gray-200 rounded-lg p-6 bg-gray-50 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                            <div class="flex flex-col md:flex-row md:items-center gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-lime-100 rounded-lg flex items-center justify-center">
                                        <x-heroicon-o-academic-cap class="w-6 h-6 text-lime-600" />
                                    </div>
                                    <div>
                                        <x-atoms.title text="{{ $tipe->nama }}" size="lg" />
                                        <x-atoms.description size="sm" color="gray-500">
                                            Jenjang Sekolah
                                        </x-atoms.description>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <x-atoms.badge 
                                        text="{{ $tipe->jurusans_count }} Jurusan"
                                        variant="sky" 
                                        size="sm"
                                    />
                                    
                                    <div class="flex items-center gap-1 text-sm text-gray-500">
                                        <x-heroicon-o-calendar-days class="w-4 h-4" />
                                        <span>{{ $tipe->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col lg:flex-row w-full lg:w-auto gap-2">
                                <x-atoms.button
                                    wire:click="createJurusan({{ $tipe->id }})"
                                    variant="success"
                                    theme="light"
                                    size="sm"
                                    heroicon="plus"
                                >
                                    Tambah Jurusan
                                </x-atoms.button>
                                
                                <x-atoms.button
                                    wire:click="editTipe({{ $tipe->id }})"
                                    variant="primary"
                                    theme="dark"
                                    size="sm"
                                    heroicon="pencil"
                                >
                                    Edit
                                </x-atoms.button>
                                
                                <x-atoms.button
                                    wire:click="deleteTipe({{ $tipe->id }})"
                                    wire:confirm="Yakin ingin menghapus Jenjang Sekolah ini? Semua jurusan akan ikut terhapus."
                                    variant="danger"
                                    theme="dark"
                                    size="sm"
                                    heroicon="trash"
                                >
                                    Hapus
                                </x-atoms.button>
                            </div>
                        </div>

                        @if($tipe->jurusans->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($tipe->jurusans as $jurusan)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all group">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center gap-2 flex-1">
                                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                                    <x-heroicon-o-book-open class="w-4 h-4 text-emerald-600" />
                                                </div>
                                                <x-atoms.title text="{{ $jurusan->nama }}" size="sm" className="group-hover:text-emerald-600 transition-colors" />
                                            </div>
                                            
                                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <x-atoms.button
                                                    wire:click="editJurusan({{ $jurusan->id }})"
                                                    variant="primary"
                                                    theme="dark"
                                                    size="sm"
                                                    heroicon="pencil"
                                                    className="!p-1 !min-h-[28px]"
                                                />
                                                
                                                <x-atoms.button
                                                    wire:click="deleteJurusan({{ $jurusan->id }})"
                                                    wire:confirm="Yakin ingin menghapus jurusan ini?"
                                                    variant="danger"
                                                    theme="dark"
                                                    size="sm"
                                                    heroicon="trash"
                                                    className="!p-1 !min-h-[28px]"
                                                />
                                            </div>
                                        </div>
                                        
                                        @if($jurusan->deskripsi)
                                            <x-atoms.description size="xs" class="mb-3 line-clamp-2">
                                                {{ $jurusan->deskripsi }}
                                            </x-atoms.description>
                                        @endif
                                        
                                        <div class="flex items-center gap-1 text-xs text-gray-500">
                                            <x-heroicon-o-calendar-days class="w-3 h-3" />
                                            <span>{{ $jurusan->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-white rounded-lg border border-gray-200">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-folder-open class="w-8 h-8 text-gray-400" />
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <x-atoms.title text="Belum ada jurusan" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400" class="mb-4">
                                            Belum ada jurusan untuk Jenjang Sekolah {{ $tipe->nama }}
                                        </x-atoms.description>
                                        <x-atoms.button
                                            wire:click="createJurusan({{ $tipe->id }})"
                                            variant="success"
                                            size="sm"
                                            heroicon="plus"
                                        >
                                            Tambah jurusan pertama
                                        </x-atoms.button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-16">
                    <div class="flex flex-col justify-center items-center gap-6">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                            <x-heroicon-o-academic-cap class="w-10 h-10 text-gray-400" />
                        </div>
                        <div class="flex items-center flex-col">
                            <x-atoms.title text="Belum ada data Jenjang Sekolah" size="xl" className="text-gray-500 mb-3" />
                            <x-atoms.description color="gray-400" class="mb-6 text-center max-w-md">
                                @if ($search)
                                    Tidak ditemukan data sesuai pencarian "{{ $search }}"
                                @else
                                    Mulai dengan menambahkan Jenjang Sekolah terlebih dahulu, kemudian tambahkan jurusan untuk setiap Jenjang Sekolah
                                @endif
                            </x-atoms.description>
                            @if (!$search)
                                <x-atoms.button
                                    wire:click="createTipe"
                                    variant="success"
                                    heroicon="plus"
                                    size="lg"
                                >
                                    Tambah Jenjang Sekolah Pertama
                                </x-atoms.button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if ($tipeSekolahs->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $tipeSekolahs->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Jenjang Sekolah Modal --}}
    <x-atoms.modal name="tipe-sekolah" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-academic-cap class="w-6 h-6 text-lime-600" />
                </div>
                <div>
                    <x-atoms.title 
                        :text="$editMode ? 'Edit Jenjang Sekolah' : 'Tambah Jenjang Sekolah'" 
                        size="lg" 
                    />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data Jenjang Sekolah' : 'Tambahkan Jenjang Sekolah baru seperti SMA, SMK, MA' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="saveTipe" class="space-y-5">
                <x-molecules.input-field
                    label="Nama Jenjang Sekolah"
                    name="tipeName"
                    wire:model="tipeName"
                    placeholder="Contoh: SMA, SMK, MA, SMP"
                    :required="true"
                    :error="$errors->first('tipeName')"
                />

                <div class="border-t pt-6 mt-6">
                    <div class="flex gap-3">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="saveTipe"
                        >
                            <span wire:loading.remove wire:target="saveTipe">
                                {{ $editMode ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="saveTipe">
                                {{ $editMode ? 'Mengupdate...' : 'Menyimpan...' }}
                            </span>
                        </x-atoms.button>
                        
                        <x-atoms.button
                            type="button"
                            wire:click="closeTipeModal"
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

    {{-- Jurusan Modal --}}
    <x-atoms.modal name="jurusan" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-book-open class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <x-atoms.title 
                        :text="$editMode ? 'Edit Jurusan' : 'Tambah Jurusan'" 
                        size="lg" 
                    />
                    <x-atoms.description size="sm" color="gray-500">
                        {{ $editMode ? 'Perbarui data jurusan' : 'Tambahkan jurusan baru untuk Jenjang Sekolah' }}
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="saveJurusan" class="space-y-5">
                <x-molecules.select-field
                    label="Jenjang Sekolah"
                    name="tipe_sekolah_id"
                    wire:model="tipe_sekolah_id"
                    :options="collect($allTipeSekolahs)->map(fn($tipe) => ['value' => $tipe->id, 'label' => $tipe->nama])->toArray()"
                    placeholder="-- Pilih Jenjang Sekolah --"
                    :required="true"
                    :error="$errors->first('tipe_sekolah_id')"
                />

                <x-molecules.input-field
                    label="Nama Jurusan"
                    name="jurusanName"
                    wire:model="jurusanName"
                    placeholder="Contoh: IPA, IPS, TKJ, Multimedia"
                    :required="true"
                    :error="$errors->first('jurusanName')"
                />

                <x-molecules.textarea-field
                    label="Deskripsi"
                    name="deskripsi"
                    wire:model="deskripsi"
                    placeholder="Deskripsi singkat tentang jurusan ini (opsional)"
                    :rows="3"
                    :error="$errors->first('deskripsi')"
                />

                <div class="border-t pt-6 mt-6">
                    <div class="flex gap-3">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="saveJurusan"
                        >
                            <span wire:loading.remove wire:target="saveJurusan">
                                {{ $editMode ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="saveJurusan">
                                {{ $editMode ? 'Mengupdate...' : 'Menyimpan...' }}
                            </span>
                        </x-atoms.button>
                        
                        <x-atoms.button
                            type="button"
                            wire:click="closeJurusanModal"
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

    {{-- Loading overlays --}}
    <div wire:loading.flex wire:target="saveTipe" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">
                {{ $editMode ? 'Mengupdate Jenjang Sekolah...' : 'Menyimpan Jenjang Sekolah...' }}
            </span>
        </div>
    </div>

    <div wire:loading.flex wire:target="saveJurusan" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-emerald-600"></div>
            <span class="text-gray-700">
                {{ $editMode ? 'Mengupdate jurusan...' : 'Menyimpan jurusan...' }}
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