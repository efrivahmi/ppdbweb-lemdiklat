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
            <h1 class="text-2xl font-bold text-gray-900">Profile SMA Taruna Nusantara Indonesia</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola informasi profile halaman SMA</p>
        </div>
    </div>

    {{-- Form Container --}}
    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Hero Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-layout-top-line text-blue-600"></i>
                    Hero Section
                </h2>
                <p class="text-sm text-gray-500 mt-1">Bagian header halaman profile</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title Prefix</label>
                        <input type="text" wire:model="hero_title_prefix"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: SMA">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title Main</label>
                        <input type="text" wire:model="hero_title_main"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: Taruna Nusantara Indonesia">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                    <input type="text" wire:model="hero_subtitle"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Contoh: Pendidikan Menengah Atas Berkarakter dan Berprestasi">
                </div>
                
                {{-- Hero Badges --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Badges</label>
                    <div class="space-y-2">
                        @foreach($hero_badges as $index => $badge)
                            <div class="flex gap-2">
                                <input type="text" wire:model="hero_badges.{{ $index }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-building-line text-blue-600"></i>
                    Identitas Sekolah
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                        <input type="text" wire:model="school_name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="SMA Taruna Nusantara Indonesia">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NPSN</label>
                        <input type="text" wire:model="npsn"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="12345678">
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Akreditasi</label>
                        <input type="text" wire:model="accreditation"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="A (Unggul)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Berdiri</label>
                        <input type="text" wire:model="year_founded"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="2010">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kurikulum</label>
                        <input type="text" wire:model="curriculum"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Kurikulum Merdeka">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Siswa & Pendidik</label>
                    <input type="text" wire:model="students_teachers"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="500+ Siswa Aktif | 50+ Tenaga Pendidik">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Deskripsi singkat tentang sekolah..."></textarea>
                </div>
            </div>
        </div>

        {{-- Akademik Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-book-2-line text-amber-600"></i>
                    Akademik
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kurikulum dan Program Akademik</p>
            </div>
            <div class="p-6 space-y-6">
                {{-- Kurikulum Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kurikulum</label>
                    <textarea wire:model="kurikulum_description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                              placeholder="SMA Taruna Nusantara Indonesia menerapkan Kurikulum Merdeka yang diperkaya dengan muatan lokal dan pendidikan karakter..."></textarea>
                </div>

                {{-- Program IPA --}}
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 relative">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-gray-700">Program IPA (Sains)</label>
                        <button type="button" wire:click="clearProgramIpa"
                                wire:confirm="Yakin ingin menghapus seluruh Program IPA?"
                                class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors">
                            <i class="ri-delete-bin-line mr-1"></i> Hapus Program
                        </button>
                    </div>
                    <div class="space-y-2">
                        @foreach($program_ipa as $index => $subject)
                            <div class="flex gap-2">
                                <input type="text" wire:model="program_ipa.{{ $index }}"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                       placeholder="Mata Pelajaran">
                                <button type="button" wire:click="removeProgramIpa({{ $index }})"
                                        class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addProgramIpa"
                            class="mt-2 px-3 py-1.5 text-sm bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors">
                        <i class="ri-add-line mr-1"></i> Tambah Mata Pelajaran IPA
                    </button>
                    @if(count($program_ipa) === 0)
                        <p class="text-sm text-gray-500 mt-2 italic">Program IPA kosong. Klik "Tambah Mata Pelajaran IPA" untuk menambahkan.</p>
                    @endif
                </div>

                {{-- Program IPS --}}
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 relative">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-gray-700">Program IPS (Sosial)</label>
                        <button type="button" wire:click="clearProgramIps"
                                wire:confirm="Yakin ingin menghapus seluruh Program IPS?"
                                class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors">
                            <i class="ri-delete-bin-line mr-1"></i> Hapus Program
                        </button>
                    </div>
                    <div class="space-y-2">
                        @foreach($program_ips as $index => $subject)
                            <div class="flex gap-2">
                                <input type="text" wire:model="program_ips.{{ $index }}"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                       placeholder="Mata Pelajaran">
                                <button type="button" wire:click="removeProgramIps({{ $index }})"
                                        class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addProgramIps"
                            class="mt-2 px-3 py-1.5 text-sm bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors">
                        <i class="ri-add-line mr-1"></i> Tambah Mata Pelajaran IPS
                    </button>
                    @if(count($program_ips) === 0)
                        <p class="text-sm text-gray-500 mt-2 italic">Program IPS kosong. Klik "Tambah Mata Pelajaran IPS" untuk menambahkan.</p>
                    @endif
                </div>

                {{-- Additional Academic Programs (Dynamic) --}}
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Program Akademik Tambahan</label>
                            <p class="text-xs text-gray-500">Tambahkan program akademik selain IPA/IPS</p>
                        </div>
                        <button type="button" wire:click="addAcademicProgram"
                                class="px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="ri-add-line mr-1"></i> Tambah Program Baru
                        </button>
                    </div>
                    
                    @foreach($academic_programs as $progIndex => $program)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-green-700">Program Tambahan #{{ $progIndex + 1 }}</span>
                                <button type="button" wire:click="removeAcademicProgram({{ $progIndex }})"
                                        class="px-2 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors">
                                    <i class="ri-delete-bin-line"></i> Hapus Program
                                </button>
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Nama Program</label>
                                <input type="text" wire:model="academic_programs.{{ $progIndex }}.title"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Contoh: Program Bahasa, Program Keagamaan">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-2">Mata Pelajaran</label>
                                <div class="space-y-2">
                                    @foreach($program['subjects'] ?? [] as $subIndex => $subject)
                                        <div class="flex gap-2">
                                            <input type="text" wire:model="academic_programs.{{ $progIndex }}.subjects.{{ $subIndex }}"
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                   placeholder="Mata Pelajaran">
                                            <button type="button" wire:click="removeAcademicProgramSubject({{ $progIndex }}, {{ $subIndex }})"
                                                    class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" wire:click="addAcademicProgramSubject({{ $progIndex }})"
                                        class="mt-2 px-3 py-1.5 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                                    <i class="ri-add-line mr-1"></i> Tambah Mata Pelajaran
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Program Unggulan Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-star-line text-blue-600"></i>
                    Program Unggulan
                </h2>
                <p class="text-sm text-gray-500 mt-1">Program unggulan sekolah</p>
            </div>
            <div class="p-6 space-y-4">
                @foreach($program_unggulan as $index => $program)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-blue-700">Program #{{ $index + 1 }}</span>
                            <button type="button" wire:click="removeProgramUnggulan({{ $index }})"
                                    class="px-2 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors">
                                <i class="ri-delete-bin-line"></i> Hapus
                            </button>
                        </div>
                        <div class="grid md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Judul Program</label>
                                <input type="text" wire:model="program_unggulan.{{ $index }}.title"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Tahfidz Al-Qur'an">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Icon (heroicon)</label>
                                <input type="text" wire:model="program_unggulan.{{ $index }}.icon"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="book-open">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                            <textarea wire:model="program_unggulan.{{ $index }}.description" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Deskripsi singkat program..."></textarea>
                        </div>
                    </div>
                @endforeach
                <button type="button" wire:click="addProgramUnggulan"
                        class="w-full px-4 py-3 text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors border-2 border-dashed border-blue-300">
                    <i class="ri-add-line mr-1"></i> Tambah Program Unggulan
                </button>
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
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-megaphone-line text-blue-600"></i>
                    Call-to-Action Section
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Badge Text</label>
                        <input type="text" wire:model="cta_badge_text"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Bergabunglah Bersama Kami">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" wire:model="cta_title"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Bergabunglah dengan SMA Taruna Nusantara Indonesia">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea wire:model="cta_description" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Wujudkan impian menjadi siswa berprestasi..."></textarea>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Primary Button Text</label>
                        <input type="text" wire:model="cta_primary_button_text"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Daftar Sekarang">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Primary Button URL</label>
                        <input type="text" wire:model="cta_primary_button_url"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="/login">
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secondary Button Text</label>
                        <input type="text" wire:model="cta_secondary_button_text"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Info Pendaftaran">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secondary Button URL</label>
                        <input type="text" wire:model="cta_secondary_button_url"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="/spmb">
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 flex items-center gap-2">
                <i class="ri-save-line"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
