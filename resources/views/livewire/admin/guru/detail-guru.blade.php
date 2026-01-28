<div class="space-y-6">
    <x-atoms.breadcrumb current-path="Detail Guru" />

    {{-- Guru Profile Card --}}
    <div class="bg-white p-6 rounded-lg shadow border">
        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Profile Photo --}}
            <div class="lg:w-1/4">
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                            <img src="{{ $guru->profile_photo_url }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-emerald-500">

                    </div>
                    
                    @if($guru->foto_profile)
                        <button wire:click="deletePhoto" 
                                onclick="return confirm('Yakin ingin menghapus foto profil?')"
                                class="text-sm text-red-600 hover:text-red-800">
                            <i class="ri-delete-bin-line mr-1"></i>Hapus Foto
                        </button>
                    @endif
                </div>
            </div>

            {{-- Profile Info --}}
            <div class="lg:w-3/4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $guru->name }}</h1>
                        <p class="text-gray-600 text-lg">{{ $guru->email }}</p>
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                            <span><i class="ri-phone-line mr-1"></i> {{ $guru->telp ?? 'Tidak ada' }}</span>
                            <span><i class="ri-calendar-line mr-1"></i> Bergabung {{ $guru->created_at->format('d M Y') }}</span>
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                                Guru
                            </span>
                        </div>
                        {{-- Mata Pelajaran --}}
                        @if($guru->mapel)
                            <div class="mt-2">
                                <span class="text-sm text-gray-600">Mata Pelajaran: </span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                    {{ $guru->mapel->mapel_name }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex gap-2">
                        <button wire:click="toggleEditModal" 
                                class="px-4 py-2 bg-lime-600 text-white rounded-lg hover:bg-lime-700 transition">
                            <i class="ri-edit-line mr-1"></i>Edit Profil
                        </button>
                        <button wire:click="togglePasswordModal" 
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                            <i class="ri-lock-line mr-1"></i>Ubah Password
                        </button>
                    </div>
                </div>

                {{-- Guru Stats --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ri-user-star-line text-2xl text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Role</p>
                                <p class="text-lg font-semibold text-gray-900">Guru</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ri-shield-check-line text-2xl text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="text-lg font-semibold text-green-600">Aktif</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ri-user-settings-line text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Akses Level</p>
                                <p class="text-lg font-semibold text-blue-600">Terbatas</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ri-book-open-line text-2xl text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Mata Pelajaran</p>
                                <p class="text-lg font-semibold text-purple-600">
                                    {{ $guru->mapel ? $guru->mapel->mapel_name : 'Belum dipilih' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Approval & Documents Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Approval Status -->
        <div class="lg:col-span-1">
            <x-atoms.card>
                <h3 class="text-lg font-semibold mb-4">Status Persetujuan</h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status:</span>
                        @if($guru->guru_approved)
                            <x-atoms.badge text="Disetujui" variant="emerald" size="sm" />
                        @else
                            <x-atoms.badge text="Belum Disetujui" variant="gold" size="sm" />
                        @endif
                    </div>

                    @if($guru->guru_approved_at)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Tanggal:</span>
                        <span class="text-sm font-medium">{{ $guru->guru_approved_at->format('d M Y') }}</span>
                    </div>
                    @endif

                    <div class="pt-4 border-t space-y-2">
                        @if(!$guru->guru_approved)
                            <button wire:click="approveGuru"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <i class="ri-check-line"></i> Setujui Guru
                            </button>
                        @else
                            <button wire:click="rejectGuru"
                                    onclick="return confirm('Batalkan persetujuan?')"
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                <i class="ri-close-line"></i> Batalkan Persetujuan
                            </button>
                        @endif

                        @if($guru->guru_approved)
                            <button wire:click="toggleSuratKerja"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="ri-file-text-line"></i> {{ $showSuratKerja ? 'Tutup' : 'Lihat' }} Surat Kerja
                            </button>
                        @endif
                    </div>
                </div>
            </x-atoms.card>
        </div>

        <!-- Documents -->
        <div class="lg:col-span-2">
            <x-atoms.card>
                <h3 class="text-lg font-semibold mb-4">Dokumen Administrasi</h3>

                <div class="space-y-3">
                    @forelse($guru->guru_documents as $doc)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="ri-file-text-line text-blue-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium">{{ $doc->document_name }}</h5>
                                    <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($doc->status === 'pending')
                                    <x-atoms.badge text="Pending" variant="gold" size="sm" />
                                @elseif($doc->status === 'approved')
                                    <x-atoms.badge text="Approved" variant="emerald" size="sm" />
                                @else
                                    <x-atoms.badge text="Rejected" variant="danger" size="sm" />
                                @endif
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-download-line text-lg"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">Belum ada dokumen</p>
                    @endforelse
                </div>
            </x-atoms.card>
        </div>
    </div>

    {{-- Surat Kerja --}}
    @if($showSuratKerja && $guru->guru_approved)
    <x-atoms.card className="bg-white border-2 border-gray-300" id="suratKerja">
        <div class="text-center space-y-4 py-6">
            <h4 class="font-bold text-lg">Yayasan Pendidikan Prima Bangsa</h4>
            <p class="text-sm">Jl. Pendidikan No. 123, Cirebon</p>

            <div class="my-6">
                <h3 class="text-xl font-bold underline">SURAT KERJA GURU</h3>
                <p class="text-sm mt-2">Nomor: {{ str_pad($guru->id, 3, '0', STR_PAD_LEFT) }}/SPK-GURU/{{ $guru->guru_approved_at->format('m/Y') }}</p>
            </div>

            <div class="text-left max-w-2xl mx-auto space-y-3 mt-8">
                <p class="text-justify">Yang bertanda tangan di bawah ini menyatakan bahwa:</p>

                <table class="w-full mt-4">
                    <tr>
                        <td class="py-2 w-40">Nama</td>
                        <td class="py-2 w-8">:</td>
                        <td class="py-2 font-medium">{{ $guru->name }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Jabatan</td>
                        <td class="py-2">:</td>
                        <td class="py-2 font-medium">Guru Mata Pelajaran</td>
                    </tr>
                    @if($guru->mapel)
                    <tr>
                        <td class="py-2">Mapel</td>
                        <td class="py-2">:</td>
                        <td class="py-2 font-medium">{{ $guru->mapel->mapel_name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="py-2">Status</td>
                        <td class="py-2">:</td>
                        <td class="py-2 font-medium">Aktif Mengajar</td>
                    </tr>
                    <tr>
                        <td class="py-2">Tanggal Mulai</td>
                        <td class="py-2">:</td>
                        <td class="py-2 font-medium">{{ $guru->guru_approved_at->format('d F Y') }}</td>
                    </tr>
                </table>

                <p class="mt-6 text-justify">Demikian surat kerja ini dibuat untuk digunakan sebagaimana mestinya.</p>

                <div class="mt-12 text-right">
                    <p>Cirebon, {{ now()->format('d F Y') }}</p>
                    <p class="mt-1">Kepala Sekolah</p>
                    <div class="h-20"></div>
                    <p class="font-medium border-t-2 border-black inline-block px-8 pt-1">
                        (______________________)
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t no-print">
                <button onclick="window.print()"
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    <i class="ri-printer-line"></i> Print Surat
                </button>
            </div>
        </div>
    </x-atoms.card>
    @endif

    {{-- Edit Modal --}}
    @if($showEditModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Profil Guru</h3>
                <button wire:click="toggleEditModal" class="text-gray-500 hover:text-gray-700">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <form wire:submit.prevent="updateGuru" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-lime-500 focus:border-lime-500
                                  @error('name') border-red-500 @enderror">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="email" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-lime-500 focus:border-lime-500
                                  @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" wire:model="telp" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-lime-500 focus:border-lime-500">
                    @error('telp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <select wire:model="mapel_id" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-lime-500 focus:border-lime-500
                                   @error('mapel_id') border-red-500 @enderror">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->mapel_name }}</option>
                        @endforeach
                    </select>
                    @error('mapel_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                    <input type="file" wire:model="foto_profile" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                  file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                  file:text-sm file:font-semibold file:bg-lime-50 file:text-lime-700 
                                  hover:file:bg-lime-100 focus:ring-2 focus:ring-lime-500 focus:border-lime-500">
                    @error('foto_profile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-lime-600 text-white rounded-lg hover:bg-lime-700 transition">
                        <i class="ri-save-line mr-1"></i>Simpan
                    </button>
                    <button type="button" wire:click="toggleEditModal"
                            class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Password Modal --}}
    @if($showPasswordModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Ubah Password</h3>
                <button wire:click="togglePasswordModal" class="text-gray-500 hover:text-gray-700">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <form wire:submit.prevent="updatePassword" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" wire:model="password" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500
                                  @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" wire:model="password_confirmation" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                        <i class="ri-lock-line mr-1"></i>Ubah Password
                    </button>
                    <button type="button" wire:click="togglePasswordModal"
                            class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
@media print {
    body * { visibility: hidden; }
    #suratKerja, #suratKerja * { visibility: visible; }
    #suratKerja { position: absolute; left: 0; top: 0; width: 100%; }
    .no-print { display: none !important; }
}
</style>
@endpush