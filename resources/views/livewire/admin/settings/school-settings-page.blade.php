<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sekolah</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola informasi sekolah, logo, dan operator</p>
        </div>
    </div>

    {{-- School Settings Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-50 to-emerald-50">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <x-lucide-school class="w-5 h-5 text-lime-600" />
                Informasi Sekolah
            </h2>
        </div>
        <form wire:submit="saveSchoolSettings" class="p-6 space-y-6">
            {{-- Basic Info Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah *</label>
                    <input type="text" wire:model="nama_sekolah" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                        placeholder="Masukkan nama sekolah">
                    @error('nama_sekolah') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran *</label>
                    <input type="text" wire:model="tahun_ajaran" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                        placeholder="contoh: 2026/2027">
                    @error('tahun_ajaran') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Address --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                <textarea wire:model="alamat" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                    placeholder="Masukkan alamat lengkap sekolah"></textarea>
                @error('alamat') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Contact Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                    <input type="text" wire:model="kode_pos" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                        placeholder="12345">
                    @error('kode_pos') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" wire:model="telp" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                        placeholder="(021) 12345678">
                    @error('telp') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" wire:model="email" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                        placeholder="info@sekolah.sch.id">
                    @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Social Media Links Section --}}
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-md font-semibold text-gray-800 flex items-center gap-2">
                        <i class="ri-share-line text-lime-600"></i>
                        Media Sosial & Website
                    </h3>
                    <button type="button" wire:click="addSocialLink"
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-lime-100 text-lime-700 text-sm font-medium rounded-lg hover:bg-lime-200 transition-colors">
                        <i class="ri-add-line"></i>
                        Tambah Link
                    </button>
                </div>
                
                @if(count($social_links) > 0)
                    <div class="space-y-3">
                        @foreach($social_links as $index => $link)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg" wire:key="social-link-{{ $index }}">
                                {{-- Platform Select --}}
                                <select wire:model="social_links.{{ $index }}.platform"
                                    class="w-40 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors text-sm">
                                    @foreach($availablePlatforms as $key => $platform)
                                        <option value="{{ $key }}">{{ $platform['name'] }}</option>
                                    @endforeach
                                </select>
                                
                                {{-- URL Input --}}
                                <input type="url" wire:model="social_links.{{ $index }}.url"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors text-sm"
                                    placeholder="{{ $availablePlatforms[$link['platform'] ?? 'website']['placeholder'] ?? 'https://...' }}">
                                
                                {{-- Remove Button --}}
                                <button type="button" wire:click="removeSocialLink({{ $index }})"
                                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                        <i class="ri-link text-3xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500 text-sm">Belum ada link. Klik "Tambah Link" untuk menambahkan.</p>
                    </div>
                @endif
            </div>

            {{-- Logos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Kiri</label>
                    <div class="flex items-center gap-4">
                        @if($logo_kiri_preview)
                            <img src="{{ $logo_kiri_preview }}" alt="Logo Kiri" class="w-16 h-16 object-contain rounded-lg border">
                        @endif
                        <input type="file" wire:model="logo_kiri" accept="image/*"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors">
                    </div>
                    @error('logo_kiri') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Kanan</label>
                    <div class="flex items-center gap-4">
                        @if($logo_kanan_preview)
                            <img src="{{ $logo_kanan_preview }}" alt="Logo Kanan" class="w-16 h-16 object-contain rounded-lg border">
                        @endif
                        <input type="file" wire:model="logo_kanan" accept="image/*"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors">
                    </div>
                    @error('logo_kanan') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Payment Message --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pesan Pembayaran</label>
                <textarea wire:model="pesan_pembayaran" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                    placeholder="Pesan yang ditampilkan pada halaman pembayaran"></textarea>
                @error('pesan_pembayaran') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Important Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Penting</label>
                <textarea wire:model="catatan_penting" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                    placeholder="Catatan penting untuk calon siswa"></textarea>
                @error('catatan_penting') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Separator --}}
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-md font-semibold text-gray-800 flex items-center gap-2 mb-4">
                    <x-lucide-map-pin class="w-5 h-5 text-lime-600" />
                    Pengaturan Peta & Lokasi
                </h3>
            </div>

            {{-- Maps Embed Link --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Google Maps Embed Link</label>
                <textarea wire:model="maps_embed_link" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors font-mono text-sm"
                    placeholder="Paste iframe embed code dari Google Maps, contoh: <iframe src='https://www.google.com/maps/embed?...'></iframe>"></textarea>
                <p class="text-xs text-gray-500 mt-1">Buka Google Maps → Share → Embed a map → Copy HTML</p>
                @error('maps_embed_link') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Maps Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Peta (Alternatif)</label>
                <div class="flex items-start gap-4">
                    @if($maps_image_preview)
                        <img src="{{ $maps_image_preview }}" alt="Maps Preview" class="w-32 h-24 object-cover rounded-lg border shadow-sm">
                    @endif
                    <div class="flex-1">
                        <input type="file" wire:model="maps_image" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Upload gambar peta jika tidak menggunakan embed Google Maps</p>
                    </div>
                </div>
                @error('maps_image') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" 
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-lime-600 to-emerald-600 text-white font-semibold rounded-lg shadow-md hover:from-lime-700 hover:to-emerald-700 focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 transition-all disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveSchoolSettings">
                        <x-lucide-save class="w-4 h-4" />
                    </span>
                    <span wire:loading wire:target="saveSchoolSettings">
                        <x-lucide-loader-2 class="w-4 h-4 animate-spin" />
                    </span>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    {{-- Operators Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-50 to-emerald-50 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <x-lucide-users class="w-5 h-5 text-lime-600" />
                Operator Sekolah
            </h2>
            <button wire:click="createOperator" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-lime-600 text-white text-sm font-medium rounded-lg hover:bg-lime-700 transition-colors">
                <x-lucide-plus class="w-4 h-4" />
                Tambah Operator
            </button>
        </div>
        <div class="p-6">
            @if($operators->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Jabatan</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($operators as $operator)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-sm text-gray-800">{{ $operator->nama }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $operator->jabatan }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <button wire:click="toggleOperatorStatus({{ $operator->id }})"
                                            class="px-3 py-1 text-xs font-medium rounded-full transition-colors {{ $operator->is_active ? 'bg-lime-100 text-lime-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $operator->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="editOperator({{ $operator->id }})" 
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <x-lucide-pencil class="w-4 h-4" />
                                            </button>
                                            <button wire:click="deleteOperator({{ $operator->id }})" 
                                                wire:confirm="Apakah Anda yakin ingin menghapus operator ini?"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <x-lucide-users class="w-12 h-12 mx-auto mb-3 text-gray-300" />
                    <p>Belum ada operator. Klik tombol "Tambah Operator" untuk menambahkan.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Operator Modal --}}
    <x-atoms.modal name="operator" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $editOperatorMode ? 'Edit Operator' : 'Tambah Operator' }}
                </h3>
                <button type="button" x-on:click="close()" class="text-gray-400 hover:text-gray-600">
                    <x-lucide-x class="w-5 h-5" />
                </button>
            </div>
            <form wire:submit="saveOperator" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Operator *</label>
                    <input type="text" wire:model="operator_nama" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                        placeholder="Masukkan nama operator">
                    @error('operator_nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                    <input type="text" wire:model="operator_jabatan" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors"
                        placeholder="Masukkan jabatan">
                    @error('operator_jabatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" wire:model="operator_is_active" id="operator_is_active" 
                        class="w-4 h-4 text-lime-600 border-gray-300 rounded focus:ring-lime-500">
                    <label for="operator_is_active" class="text-sm text-gray-700">Aktifkan operator ini</label>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="closeOperatorModal"
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-lime-600 text-white rounded-lg hover:bg-lime-700 transition-colors">
                        {{ $editOperatorMode ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </x-atoms.modal>
</div>
