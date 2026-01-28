<div>
    <x-atoms.breadcrumb currentPath="Pengaturan PDF" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col gap-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <x-atoms.title text="Pengaturan PDF" size="xl" />
                    <x-atoms.description size="sm" color="gray-600">
                        Kelola pengaturan untuk PDF verifikasi dan penerimaan siswa
                    </x-atoms.description>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button wire:click="switchTab('verifikasi')" 
                            class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'verifikasi' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-document-check class="w-5 h-5" />
                            PDF Verifikasi
                        </div>
                    </button>
                    <button wire:click="switchTab('penerimaan')" 
                            class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'penerimaan' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-document-text class="w-5 h-5" />
                            PDF Penerimaan
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Preview Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <x-heroicon-o-eye class="w-6 h-6 text-blue-600" />
                    </div>
                    <div>
                        <x-atoms.title text="Preview PDF {{ ucfirst($activeTab) }}" size="lg" />
                        <x-atoms.description size="sm" color="blue-600">
                            Pilih siswa untuk melihat preview PDF
                            @if($activeTab === 'penerimaan')
                                (hanya siswa yang diterima)
                            @endif
                        </x-atoms.description>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <x-atoms.label for="siswa-select">Pilih Siswa</x-atoms.label>
                        <div class="relative mt-1">
                            <select wire:model.live="selectedSiswaId" 
                                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($availableSiswa as $siswa)
                                <option value="{{ $siswa->id }}">
                                    {{ $siswa->name }} 
                                    @if($siswa->nisn)
                                        - {{ $siswa->nisn }}
                                    @endif
                                    @if($siswa->pendaftaranMurids->isNotEmpty())
                                        ({{ $siswa->pendaftaranMurids->first()->jalurPendaftaran->nama ?? 'Jalur tidak tersedia' }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <x-heroicon-o-chevron-down class="w-4 h-4 text-blue-400" />
                            </div>
                        </div>
                        @if($availableSiswa->isEmpty())
                            <p class="text-sm text-blue-600 mt-2">
                                @if($activeTab === 'verifikasi')
                                    Belum ada siswa yang mendaftar
                                @else
                                    Belum ada siswa yang diterima
                                @endif
                            </p>
                        @endif
                    </div>
                    
                    <div class="flex items-end">
                        <x-atoms.button
                            wire:click="previewPDF"
                            variant="primary"
                            heroicon="eye"
                            :disabled="!$selectedSiswaId"
                            wire:loading.attr="disabled"
                            wire:target="previewPDF"
                        >
                            <span wire:loading.remove wire:target="previewPDF">
                                Preview PDF
                            </span>
                            <span wire:loading wire:target="previewPDF">
                                Loading...
                            </span>
                        </x-atoms.button>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="save" class="space-y-8">
                <!-- Status Section -->
                <div>
                    <x-atoms.title text="Status" size="md" className="mb-4" />
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center gap-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="is_active" value="1" 
                                       class="text-lime-600 focus:ring-lime-500 mr-2">
                                <span class="text-sm text-gray-700">Aktif</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="is_active" value="0" 
                                       class="text-lime-600 focus:ring-lime-500 mr-2">
                                <span class="text-sm text-gray-700">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Informasi Sekolah -->
                <div>
                    <x-atoms.title text="Informasi Sekolah" size="md" className="mb-4" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-molecules.input-field
                            label="Nama Sekolah"
                            name="nama_sekolah"
                            wire:model="nama_sekolah"
                            placeholder="Masukan nama sekolah"
                            :required="true"
                            :error="$errors->first('nama_sekolah')"
                        />

                        <x-molecules.input-field
                            label="Email"
                            inputType="email"
                            name="email"
                            wire:model="email"
                            placeholder="Masukan email sekolah"
                            :required="true"
                            :error="$errors->first('email')"
                        />

                        <x-molecules.input-field
                            label="Telepon"
                            name="telepon"
                            wire:model="telepon"
                            placeholder="Masukan nomor telepon"
                            :required="true"
                            :error="$errors->first('telepon')"
                        />

                        <x-molecules.input-field
                            label="Website"
                            inputType="text"
                            name="website"
                            wire:model="website"
                            placeholder="https://website-sekolah.com"
                            :error="$errors->first('website')"
                        />
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <x-atoms.title text="Alamat Sekolah" size="md" className="mb-4" />
                    <div class="space-y-4">
                        <x-molecules.textarea-field
                            label="Alamat Lengkap"
                            name="alamat_sekolah"
                            wire:model="alamat_sekolah"
                            placeholder="Masukan alamat lengkap sekolah"
                            :rows="3"
                            :required="true"
                            :error="$errors->first('alamat_sekolah')"
                        />
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <x-molecules.input-field
                                label="Kecamatan"
                                name="kecamatan"
                                wire:model="kecamatan"
                                placeholder="Masukan kecamatan"
                                :required="true"
                                :error="$errors->first('kecamatan')"
                            />

                            <x-molecules.input-field
                                label="Kabupaten/Kota"
                                name="kabupaten"
                                wire:model="kabupaten"
                                placeholder="Masukan kabupaten/kota"
                                :required="true"
                                :error="$errors->first('kabupaten')"
                            />

                            <x-molecules.input-field
                                label="Provinsi"
                                name="provinsi"
                                wire:model="provinsi"
                                placeholder="Masukan provinsi"
                                :required="true"
                                :error="$errors->first('provinsi')"
                            />

                            <x-molecules.input-field
                                label="Kode Pos"
                                name="kode_pos"
                                wire:model="kode_pos"
                                placeholder="Masukan kode pos"
                                :required="true"
                                :error="$errors->first('kode_pos')"
                            />
                        </div>
                    </div>
                </div>

                <!-- Logo -->
                <div>
                    <x-atoms.title text="Logo & Identitas" size="md" className="mb-4" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Logo Kiri -->
                        <div>
                            <x-atoms.label for="logo-kiri">Logo Kiri</x-atoms.label>
                            <div class="mt-2">
                                @if($logo_kiri && $currentPDF && $currentPDF->hasLogoKiri())
                                    <div class="mb-4">
                                        <img src="{{ $currentPDF->logo_kiri_url }}" alt="Logo Kiri" class="w-20 h-20 object-contain border border-gray-200 rounded-lg">
                                        <button type="button" wire:click="deleteLogo('kiri')" 
                                                wire:confirm="Yakin ingin menghapus logo kiri?"
                                                class="mt-2 text-sm text-red-600 hover:text-red-700">
                                            Hapus Logo
                                        </button>
                                    </div>
                                @endif
                                <input type="file" wire:model="newLogoKiri" accept="image/*" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-lime-50 file:text-lime-700 hover:file:bg-lime-100">
                                @if($newLogoKiri)
                                    <div class="mt-2">
                                        <img src="{{ $newLogoKiri->temporaryUrl() }}" alt="Preview" class="w-20 h-20 object-contain border border-gray-200 rounded-lg">
                                    </div>
                                @endif
                                @error('newLogoKiri')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Logo Kanan -->
                        <div>
                            <x-atoms.label for="logo-kanan">Logo Kanan</x-atoms.label>
                            <div class="mt-2">
                                @if($logo_kanan && $currentPDF && $currentPDF->hasLogoKanan())
                                    <div class="mb-4">
                                        <img src="{{ $currentPDF->logo_kanan_url }}" alt="Logo Kanan" class="w-20 h-20 object-contain border border-gray-200 rounded-lg">
                                        <button type="button" wire:click="deleteLogo('kanan')" 
                                                wire:confirm="Yakin ingin menghapus logo kanan?"
                                                class="mt-2 text-sm text-red-600 hover:text-red-700">
                                            Hapus Logo
                                        </button>
                                    </div>
                                @endif
                                <input type="file" wire:model="newLogoKanan" accept="image/*" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-lime-50 file:text-lime-700 hover:file:bg-lime-100">
                                @if($newLogoKanan)
                                    <div class="mt-2">
                                        <img src="{{ $newLogoKanan->temporaryUrl() }}" alt="Preview" class="w-20 h-20 object-contain border border-gray-200 rounded-lg">
                                    </div>
                                @endif
                                @error('newLogoKanan')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PDF Settings -->
                <div>
                    <x-atoms.title text="Pengaturan PDF" size="md" className="mb-4" />
                    <div class="space-y-4">
                        <x-molecules.input-field
                            label="Judul PDF"
                            name="judul_pdf"
                            wire:model="judul_pdf"
                            placeholder="Masukan judul untuk PDF"
                            :required="true"
                            :error="$errors->first('judul_pdf')"
                        />

                        <x-molecules.textarea-field
                            label="Pesan Penting"
                            name="pesan_penting"
                            wire:model="pesan_penting"
                            placeholder="Masukan pesan penting yang akan ditampilkan di PDF"
                            :rows="4"
                            :error="$errors->first('pesan_penting')"
                        />

                        <x-molecules.textarea-field
                            label="Catatan Tambahan"
                            name="catatan_tambahan"
                            wire:model="catatan_tambahan"
                            placeholder="Catatan tambahan (opsional)"
                            :rows="3"
                            :error="$errors->first('catatan_tambahan')"
                        />
                    </div>
                </div>

                <!-- Operator -->
                <div>
                    <x-atoms.title text="Informasi Operator" size="md" className="mb-4" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-molecules.input-field
                            label="Nama Operator"
                            name="nama_operator"
                            wire:model="nama_operator"
                            placeholder="Nama operator PPDB"
                            :required="true"
                            :error="$errors->first('nama_operator')"
                        />

                        <x-molecules.input-field
                            label="Jabatan Operator"
                            name="jabatan_operator"
                            wire:model="jabatan_operator"
                            placeholder="Jabatan operator PPDB"
                            :required="true"
                            :error="$errors->first('jabatan_operator')"
                        />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="border-t pt-6">
                    <x-atoms.button
                        type="submit"
                        variant="success"
                        heroicon="check"
                        className="w-full md:w-auto"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        <span wire:loading.remove wire:target="save">
                            {{ $editMode ? 'Perbarui Pengaturan' : 'Simpan Pengaturan' }}
                        </span>
                        <span wire:loading wire:target="save">
                            {{ $editMode ? 'Memperbarui...' : 'Menyimpan...' }}
                        </span>
                    </x-atoms.button>
                </div>
            </form>
        </div>
    </x-atoms.card>

    <!-- Loading Overlay -->
    <div wire:loading.flex wire:target="save" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">
                {{ $editMode ? 'Memperbarui pengaturan...' : 'Menyimpan pengaturan...' }}
            </span>
        </div>
    </div>

    <!-- Preview Loading -->
    <div wire:loading.flex wire:target="previewPDF" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Memuat preview PDF...</span>
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