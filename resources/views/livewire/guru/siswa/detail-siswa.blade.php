<div class="space-y-6">
    <x-atoms.breadcrumb current-path="Detail Siswa" />
    
    {{-- Header Profil --}}
    <div class="bg-white p-6 rounded-lg shadow border">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center">
                    <img src="{{ $user->profile_photo_url }}" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500">

            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-gray-600 text-lg">{{ $user->email }}</p>
                <div class="flex gap-4 mt-2 text-sm text-gray-600">
                    <span><i class="ri-phone-line mr-1"></i> {{ $user->telp ?? 'Tidak ada' }}</span>
                    <span><i class="ri-id-card-line mr-1"></i> NISN: {{ $user->nisn ?? 'Tidak adAa' }}</span>
                    <span><i class="ri-user-star-line mr-1"></i> {{ ucfirst($user->role) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Pendaftaran --}}
    @if($user->pendaftaranMurids->count() > 0)
    <div class="bg-white p-6 rounded-lg shadow border">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Pendaftaran</h2>
        
        @foreach($user->pendaftaranMurids as $pendaftaran)
        <div class="border rounded-lg p-4 mb-4 last:mb-0">
            <div class="flex justify-between items-start mb-3">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                    <div>
                        <span class="text-sm text-gray-500">Jalur Pendaftaran</span>
                        <p class="font-medium">{{ $pendaftaran->jalurPendaftaran->nama }}</p>
                        <p class="text-sm text-green-600">Rp{{ number_format($pendaftaran->jalurPendaftaran->biaya, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Tipe Sekolah</span>
                        <p class="font-medium">{{ $pendaftaran->tipeSekolah->nama }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Jurusan</span>
                        <p class="font-medium">{{ $pendaftaran->jurusan->nama }}</p>
                    </div>
                </div>
                
                {{-- Status Buttons --}}
                <div class="flex gap-2 ml-4">
                    @foreach(['pending', 'diterima', 'ditolak'] as $status)
                        <button
                            wire:click="updateStatusPendaftaran({{ $pendaftaran->id }}, '{{ $status }}')"
                            class="px-3 py-1 text-xs font-semibold rounded-full transition
                                {{ $pendaftaran->status === $status 
                                    ? ($status === 'diterima' ? 'bg-green-500 text-white' : 
                                       ($status === 'ditolak' ? 'bg-red-500 text-white' : 'bg-yellow-500 text-white'))
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ ucfirst($status) }}
                        </button>
                    @endforeach
                </div>
            </div>
            
            <div class="text-sm text-gray-500">
                Tanggal Daftar: {{ $pendaftaran->created_at->format('d M Y H:i') }}
            </div>
        </div>
        @endforeach
    </div>
    @endif


   
    {{-- Data Murid --}}
    <div class="bg-white p-6 rounded-lg shadow border">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Data Murid</h2>
            <button wire:click="toggleEditData" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="ri-edit-line mr-1"></i>
                {{ $showEditData ? 'Batal' : 'Edit' }}
            </button>
        </div>

        @if($showEditData)
            {{-- Form Edit Data Murid --}}
            <form wire:submit.prevent="updateDataMurid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
               

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                    <input type="text" wire:model="tempat_lahir" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('tempat_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" wire:model="tgl_lahir" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('tgl_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                    <select wire:model="agama" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                    @error('agama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                    <input type="text" wire:model="whatsapp" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('whatsapp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Asal Sekolah</label>
                    <input type="text" wire:model="asal_sekolah" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('asal_sekolah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Berat Badan (kg)</label>
                    <input type="number" wire:model="berat_badan" step="0.1" min="1" max="999"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('berat_badan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tinggi Badan (cm)</label>
                    <input type="number" wire:model="tinggi_badan" step="0.1" min="1" max="999"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('tinggi_badan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Riwayat Penyakit (kosongkan jika tidak ada)</label>
                    <input type="text" wire:model="riwayat_penyakit" step="0.1"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('riwayat_penyakit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                 <!-- Jenis Kelamin -->
                    <div>
                        <x-atoms.label for="jenis_kelamin">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </x-atoms.label>
                        <div class="mt-2 space-y-3">
                            @foreach($jenisKelaminOptions as $value => $label)
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" 
                                       wire:model.blur="jenis_kelamin" 
                                       value="{{ $value }}"
                                       class="w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 focus:ring-lime-500 focus:ring-2">
                                <div class="ml-3 flex items-center gap-2">
                                    <i class="ri-{{ $value === 'Laki-laki' ? 'men' : 'women' }}-line text-gray-500 group-hover:text-lime-600"></i>
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-lime-600">{{ $label }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea wire:model="alamat" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    @error('alamat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2 flex gap-3">
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="ri-save-line mr-1"></i> Simpan
                    </button>
                    <button type="button" wire:click="toggleEditData"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </form>
        @else
            {{-- Display Data Murid --}}
            @if($user->dataMurid)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Tempat Lahir:</span>
                        <p class="font-medium">{{ $user->dataMurid->tempat_lahir ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Tanggal Lahir:</span>
                        <p class="font-medium">{{ $user->dataMurid->tgl_lahir ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Agama:</span>
                        <p class="font-medium">{{ $user->dataMurid->agama ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">WhatsApp:</span>
                        <p class="font-medium">{{ $user->dataMurid->whatsapp ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Asal Sekolah:</span>
                        <p class="font-medium">{{ $user->dataMurid->asal_sekolah ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Berat Badan:</span>
                        <p class="font-medium">{{ $user->dataMurid->berat_badan ? $user->dataMurid->berat_badan . ' kg' : 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Tinggi Badan:</span>
                        <p class="font-medium">{{ $user->dataMurid->tinggi_badan ? $user->dataMurid->tinggi_badan . ' cm' : 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Riwayat Penyakit:</span>
                        <p class="font-medium">{{ $user->dataMurid->riwayat_penyakit ? $user->dataMurid->riwayat_penyakit : 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Jenis Kelamin:</span>
                        <p class="font-medium">{{ $user->dataMurid->jenis_kelamin ? $user->dataMurid->jenis_kelamin : 'Tidak ada' }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <span class="text-gray-500">Alamat:</span>
                        <p class="font-medium">{{ $user->dataMurid->alamat ?? 'Belum diisi' }}</p>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-sm text-gray-500">Status:</span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $user->dataMurid->proses ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $user->dataMurid->proses ? 'Lengkap' : 'Belum Lengkap' }}
                    </span>
                </div>

                
            @else
                <p class="text-gray-500 italic">Data murid belum diisi</p>
            @endif
        @endif
    </div>

    {{-- Data Orang Tua --}}
    <div class="bg-white p-6 rounded-lg shadow border">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Data Orang Tua</h2>
            <button wire:click="toggleEditOrangTua" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="ri-edit-line mr-1"></i>
                {{ $showEditOrangTua ? 'Batal' : 'Edit' }}
            </button>
        </div>

        @if($showEditOrangTua)
            {{-- Form Edit Data Orang Tua --}}
            <form wire:submit.prevent="updateDataOrangTua" class="space-y-6">
                {{-- Data Ayah --}}
                <div>
                    <h3 class="text-lg font-semibold text-indigo-700 mb-3">Data Ayah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                            <input type="text" wire:model="nama_ayah" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ayah</label>
                            <input type="text" wire:model="pendidikan_ayah" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon Ayah</label>
                            <input type="text" wire:model="telp_ayah" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                            <input type="text" wire:model="pekerjaan_ayah" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <x-molecules.select-field
                label="Penghasilan Ayah"
                name="penghasilan_ayah"
                wire:model.defer="penghasilan_ayah"
                :options="collect($this->getPenghasilanOptions())->map(fn($label, $value) => ['value' => $value, 'label' => $label])->values()->toArray()"
                placeholder="-- Pilih Range Penghasilan --"
                :error="$errors->first('penghasilan_ayah')"
            />

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Ayah</label>
                            <textarea wire:model="alamat_ayah" rows="2"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Data Ibu --}}
                <div>
                    <h3 class="text-lg font-semibold text-indigo-700 mb-3">Data Ibu</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                            <input type="text" wire:model="nama_ibu" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ibu</label>
                            <input type="text" wire:model="pendidikan_ibu" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon Ibu</label>
                            <input type="text" wire:model="telp_ibu" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                            <input type="text" wire:model="pekerjaan_ibu" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <x-molecules.select-field
                label="Penghasilan Ibu"
                name="penghasilan_ibu"
                wire:model.defer="penghasilan_ibu"
                :options="collect($this->getPenghasilanOptions())->map(fn($label, $value) => ['value' => $value, 'label' => $label])->values()->toArray()"
                placeholder="-- Pilih Range Penghasilan --"
                :error="$errors->first('penghasilan_ibu')"
            />
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Ibu</label>
                            <textarea wire:model="alamat_ibu" rows="2"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Data Wali --}}
                <div>
                    <h3 class="text-lg font-semibold text-indigo-700 mb-3">Data Wali (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Wali</label>
                            <input type="text" wire:model="nama_wali" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Wali</label>
                            <input type="text" wire:model="pendidikan_wali" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon Wali</label>
                            <input type="text" wire:model="telp_wali" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Wali</label>
                            <input type="text" wire:model="pekerjaan_wali" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <x-molecules.select-field
                label="Penghasilan Wali"
                name="penghasilan_wali"
                wire:model.defer="penghasilan_wali"
                :options="collect($this->getPenghasilanOptions())->map(fn($label, $value) => ['value' => $value, 'label' => $label])->values()->toArray()"
                placeholder="-- Pilih Range Penghasilan --"
                :error="$errors->first('penghasilan_wali')"
            />
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Wali</label>
                            <textarea wire:model="alamat_wali" rows="2"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="ri-save-line mr-1"></i> Simpan
                    </button>
                    <button type="button" wire:click="toggleEditOrangTua"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </form>
        @else
            {{-- Display Data Orang Tua --}}
            @if($user->dataOrangTua)
                <div class="space-y-6">
                    {{-- Data Ayah --}}
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-700 mb-3">Data Ayah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Nama:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->nama_ayah ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Pendidikan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->pendidikan_ayah ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Telepon:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->telp_ayah ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Pekerjaan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->pekerjaan_ayah ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Penghasilan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->penghasilan_ayah ?? 'Belum diisi' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-gray-500">Alamat:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->alamat_ayah ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Data Ibu --}}
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-700 mb-3">Data Ibu</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Nama:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->nama_ibu ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Pendidikan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->pendidikan_ibu ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Telepon:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->telp_ibu ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Pekerjaan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->pekerjaan_ibu ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Penghasilan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->penghasilan_ibu ?? 'Belum diisi' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-gray-500">Alamat:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->alamat_ibu ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Data Wali --}}
                    @if($user->dataOrangTua->nama_wali)
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-700 mb-3">Data Wali</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Nama:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->nama_wali ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Pendidikan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->pendidikan_wali ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Telepon:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->telp_wali ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Pekerjaan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->pekerjaan_wali ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Penghasilan:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->penghasilan_wali ?? 'Belum diisi' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-gray-500">Alamat:</span>
                                <p class="font-medium">{{ $user->dataOrangTua->alamat_wali ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            @else
                <p class="text-gray-500 italic">Data orang tua belum diisi</p>
            @endif
        @endif
    </div>

    {{-- Berkas Murid --}}
    <div class="bg-white p-6 rounded-lg shadow border">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Berkas Murid</h2>
            <button wire:click="toggleUploadBerkas" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="ri-upload-line mr-1"></i>
                {{ $showUploadBerkas ? 'Batal' : 'Upload Berkas' }}
            </button>
        </div>

        @if($showUploadBerkas)
            {{-- Form Upload Berkas --}}
            <form wire:submit.prevent="uploadBerkas" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $berkasFields = [
                        ['label' => 'Kartu Keluarga', 'name' => 'kartu_keluarga'],
                        ['label' => 'Akte Kelahiran', 'name' => 'akte_kelahiran'],
                        ['label' => 'Surat Kelakuan Baik', 'name' => 'surat_kelakuan_baik'],
                        ['label' => 'Surat Sehat', 'name' => 'surat_sehat'],
                        ['label' => 'Surat Tidak Buta Warna', 'name' => 'surat_tidak_buta_warna'],
                        ['label' => 'Rapor', 'name' => 'rapor'],
                        ['label' => 'Foto', 'name' => 'foto'],
                        ['label' => 'Ijazah', 'name' => 'ijazah'],
                    ];
                @endphp

                @foreach ($berkasFields as $field)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $field['label'] }}</label>
                        <input type="file" wire:model="{{ $field['name'] }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 
                                      hover:file:bg-indigo-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error($field['name']) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @endforeach

                <div class="md:col-span-2 flex gap-3">
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="ri-upload-line mr-1"></i> Upload
                    </button>
                    <button type="button" wire:click="toggleUploadBerkas"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </form>
        @else
            {{-- Display Berkas --}}
            @if($user->berkasMurid)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $berkasFields = [
                            ['label' => 'Kartu Keluarga', 'name' => 'kartu_keluarga'],
                            ['label' => 'Akte Kelahiran', 'name' => 'akte_kelahiran'],
                            ['label' => 'Surat Kelakuan Baik', 'name' => 'surat_kelakuan_baik'],
                            ['label' => 'Surat Sehat', 'name' => 'surat_sehat'],
                            ['label' => 'Surat Tidak Buta Warna', 'name' => 'surat_tidak_buta_warna'],
                            ['label' => 'Rapor', 'name' => 'rapor'],
                            ['label' => 'Foto', 'name' => 'foto'],
                            ['label' => 'Ijazah', 'name' => 'ijazah'],
                        ];
                    @endphp

                    @foreach ($berkasFields as $field)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-gray-900">{{ $field['label'] }}</h4>
                                @if($user->berkasMurid->{$field['name']})
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">
                                        <i class="ri-check-line mr-1"></i>Tersedia
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-semibold">
                                        <i class="ri-close-line mr-1"></i>Belum Upload
                                    </span>
                                @endif
                            </div>
                            
                            @if($user->berkasMurid->{$field['name']})
                                <div class="flex gap-2">
                                    <a href="{{ asset('storage/' . $user->berkasMurid->{$field['name']}) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-lg hover:bg-blue-200 transition">
                                        <i class="ri-eye-line mr-1"></i>Lihat
                                    </a>
                                    <button wire:click="deleteBerkas('{{ $field['name'] }}')"
                                            onclick="return confirm('Yakin ingin menghapus file ini?')"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs rounded-lg hover:bg-red-200 transition">
                                        <i class="ri-delete-bin-line mr-1"></i>Hapus
                                    </button>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm italic">File belum diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">Belum ada berkas yang diupload</p>
            @endif
        @endif
    </div>

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="approveEssayAnswer,rejectEssayAnswer,approveAllEssayForTest" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
            <span class="text-gray-700">Memproses review...</span>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
    window.addEventListener('success', event => {
        // Add your toast notification here
        console.log('Success:', event.detail.message);
    });
    
    window.addEventListener('error', event => {
        // Add your toast notification here
        console.log('Error:', event.detail.message);
    });
    
    window.addEventListener('info', event => {
        // Add your toast notification here
        console.log('Info:', event.detail.message);
    });
</script>
@endpush