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




</div>
