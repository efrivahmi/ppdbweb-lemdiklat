<div class="space-y-6">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <i class="ri-check-line text-lg"></i>
            {{ session('message') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profile SMK Taruna Nusantara Jaya</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola informasi profile halaman SMK</p>
        </div>
    </div>

    {{-- Form Container --}}
    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Hero Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-layout-top-line text-green-600"></i>
                    Hero Section
                </h2>
                <p class="text-sm text-gray-500 mt-1">Bagian header halaman profile</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title Prefix</label>
                        <input type="text" wire:model="hero_title_prefix"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Contoh: SMK">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title Main</label>
                        <input type="text" wire:model="hero_title_main"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Contoh: Taruna Nusantara Jaya">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                    <input type="text" wire:model="hero_subtitle"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="Contoh: Sekolah Menengah Kejuruan Siap Kerja dan Berkarakter">
                </div>
                
                {{-- Hero Badges --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Badges</label>
                    <div class="space-y-2">
                        @foreach($hero_badges as $index => $badge)
                            <div class="flex gap-2">
                                <input type="text" wire:model="hero_badges.{{ $index }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Contoh: Akreditasi: A">
                                <button type="button" wire:click="removeHeroBadge({{ $index }})"
                                        class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addHeroBadge"
                            class="mt-2 px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="ri-add-line mr-1"></i> Tambah Badge
                    </button>
                </div>
            </div>
        </div>

        {{-- Identity Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-building-line text-green-600"></i>
                    Identitas Sekolah
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                        <input type="text" wire:model="school_name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="SMK Taruna Nusantara Jaya">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NPSN</label>
                        <input type="text" wire:model="npsn"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="87654321">
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Akreditasi</label>
                        <input type="text" wire:model="accreditation"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="A (Unggul)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Berdiri</label>
                        <input type="text" wire:model="year_founded"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="2012">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kurikulum</label>
                        <input type="text" wire:model="curriculum"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Kurikulum Merdeka SMK">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mitra Industri</label>
                    <input type="text" wire:model="students_teachers"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="50+ Mitra Industri">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              placeholder="Deskripsi singkat tentang sekolah..."></textarea>
                </div>
            </div>
        </div>

        {{-- Kompetensi Keahlian Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="ri-tools-line text-amber-600"></i>
                            Kompetensi Keahlian
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Program keahlian yang tersedia</p>
                    </div>
                    <button type="button" wire:click="addKompetensi"
                            class="px-3 py-1.5 text-sm bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                        <i class="ri-add-line mr-1"></i> Tambah Program
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-6">
                @foreach($kompetensi as $kompIndex => $komp)
                    @php
                        $colorClasses = match($komp['color'] ?? 'blue') {
                            'red' => 'border-red-200 bg-red-50',
                            'purple' => 'border-purple-200 bg-purple-50',
                            'green' => 'border-green-200 bg-green-50',
                            'orange' => 'border-orange-200 bg-orange-50',
                            default => 'border-blue-200 bg-blue-50',
                        };
                        $headerColor = match($komp['color'] ?? 'blue') {
                            'red' => 'text-red-700',
                            'purple' => 'text-purple-700',
                            'green' => 'text-green-700',
                            'orange' => 'text-orange-700',
                            default => 'text-blue-700',
                        };
                    @endphp
                    <div class="border-2 {{ $colorClasses }} rounded-xl p-5 relative">
                        <button type="button" wire:click="removeKompetensi({{ $kompIndex }})"
                                class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition-colors"
                                title="Hapus Program">
                            <i class="ri-close-line"></i>
                        </button>
                        <div class="flex items-center justify-between mb-4 pr-10">
                            <span class="text-lg font-bold {{ $headerColor }}">{{ $komp['code'] ?? 'Program' }} - #{{ $kompIndex + 1 }}</span>
                            <select wire:model="kompetensi.{{ $kompIndex }}.color" 
                                    class="text-sm border border-gray-300 rounded-lg px-2 py-1">
                                <option value="blue">Biru</option>
                                <option value="red">Merah</option>
                                <option value="purple">Ungu</option>
                                <option value="green">Hijau</option>
                                <option value="orange">Orange</option>
                            </select>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Nama Program</label>
                                <input type="text" wire:model="kompetensi.{{ $kompIndex }}.name"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Kode</label>
                                <input type="text" wire:model="kompetensi.{{ $kompIndex }}.code"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                            <textarea wire:model="kompetensi.{{ $kompIndex }}.description" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Mata Pelajaran / Kompetensi</label>
                            <div class="space-y-2">
                                @foreach($komp['subjects'] ?? [] as $subIndex => $subject)
                                    <div class="flex gap-2">
                                        <input type="text" wire:model="kompetensi.{{ $kompIndex }}.subjects.{{ $subIndex }}"
                                               class="flex-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                                        <button type="button" wire:click="removeKompetensiSubject({{ $kompIndex }}, {{ $subIndex }})"
                                                class="px-2 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" wire:click="addKompetensiSubject({{ $kompIndex }})"
                                    class="mt-2 px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                <i class="ri-add-line mr-1"></i> Tambah Kompetensi
                            </button>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Prospek Karir</label>
                            <input type="text" wire:model="kompetensi.{{ $kompIndex }}.career"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                   placeholder="Contoh: Network Engineer, IT Support, Cyber Security Analyst">
                        </div>
                    </div>
                @endforeach
                @if(count($kompetensi) === 0)
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-tools-line text-4xl mb-2"></i>
                        <p>Belum ada program keahlian. Klik "Tambah Program" untuk menambahkan.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kesiswaan & Kegiatan (PKL) Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-50 to-cyan-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-user-star-line text-teal-600"></i>
                    Kesiswaan & Kegiatan (PKL)
                </h2>
                <p class="text-sm text-gray-500 mt-1">Program Praktik Kerja Lapangan</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi PKL</label>
                    <textarea wire:model="pkl_description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                              placeholder="Deskripsi program PKL..."></textarea>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Durasi</label>
                        <input type="text" wire:model="pkl_duration"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                               placeholder="3 bulan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                        <input type="text" wire:model="pkl_timing"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                               placeholder="Kelas XII">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mitra Perusahaan</label>
                        <input type="text" wire:model="pkl_partners"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                               placeholder="50+ Mitra">
                    </div>
                </div>
            </div>
        </div>

        {{-- Seragam Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-t-shirt-line text-green-600"></i>
                    Seragam Sekolah
                </h2>
                <p class="text-sm text-gray-500 mt-1">Upload gambar seragam sekolah</p>
            </div>
            <div class="p-6">
                <div class="flex justify-end mb-4">
                    <button type="button" wire:click="addSeragam"
                            class="px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="ri-add-line mr-1"></i> Tambah Seragam
                    </button>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($seragam as $index => $item)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 relative">
                            <button type="button" wire:click="removeSeragam({{ $index }})"
                                    class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition-colors"
                                    title="Hapus Seragam">
                                <i class="ri-close-line text-sm"></i>
                            </button>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Judul</label>
                                <input type="text" wire:model="seragam.{{ $index }}.title"
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="PDH Putih Abu">
                            </div>
                            <div class="mb-2">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Gambar</label>
                                @if(isset($new_seragam_images[$index]) && $new_seragam_images[$index])
                                    <img src="{{ $new_seragam_images[$index]->temporaryUrl() }}" class="w-full h-32 object-cover rounded-lg mb-2">
                                @elseif(isset($item['image']) && $item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-32 object-cover rounded-lg mb-2">
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-lg mb-2 flex items-center justify-center text-gray-400">
                                        <i class="ri-image-line text-3xl"></i>
                                    </div>
                                @endif
                                <input type="file" wire:model="new_seragam_images.{{ $index }}" accept="image/*"
                                       class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(count($seragam) === 0)
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-t-shirt-line text-4xl mb-2"></i>
                        <p>Belum ada seragam. Klik "Tambah Seragam" untuk menambahkan.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- CTA Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-megaphone-line text-green-600"></i>
                    Call-to-Action Section
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Badge Text</label>
                        <input type="text" wire:model="cta_badge_text"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Bergabunglah Bersama Kami">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" wire:model="cta_title"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Bergabunglah dengan SMK Taruna Nusantara Jaya">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea wire:model="cta_description" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              placeholder="Raih masa depan cerah bersama kami..."></textarea>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Primary Button Text</label>
                        <input type="text" wire:model="cta_primary_button_text"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Daftar Sekarang">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Primary Button URL</label>
                        <input type="text" wire:model="cta_primary_button_url"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="/login">
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secondary Button Text</label>
                        <input type="text" wire:model="cta_secondary_button_text"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Info Pendaftaran">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secondary Button URL</label>
                        <input type="text" wire:model="cta_secondary_button_url"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="/spmb">
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 flex items-center gap-2">
                <i class="ri-save-line"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
