<div x-data="{
    refreshInterval: null,
    mounted() {
        this.refreshInterval = setInterval(() => {
            $wire.$refresh();
        }, 60000);
    },
    unmounted() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
}" x-init="mounted()" x-destroy="unmounted()">
    <x-atoms.breadcrumb current-path="Dashboard" />

    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 border border-gray-300 shadow-md rounded-md mt-4 text-white">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-emerald-100">Dashboard Guru - Sistem Penerimaan Peserta Didik Baru</p>
                    <p class="text-emerald-200 text-sm">{{ now()->format('d F Y, H:i') }} WIB</p>
                </div>
                <div class="hidden md:block">
                    <i class="ri-user-star-line text-6xl text-teal-200"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Stats Cards -->
    <div class="grid grid-cols-1  gap-4 mt-6">
        <x-atoms.card className="bg-gradient-to-r w-full from-blue-500 to-blue-600 text-white border-0">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="text-2xl font-bold">{{ number_format($totalStats['total_siswa']) }}</div>
                    <div class="text-blue-100 text-sm">Total Siswa</div>
                </div>
                <div class="w-12 h-12 bg-blue-400 bg-opacity-30 rounded-full flex items-center justify-center">
                    <i class="ri-user-line text-xl"></i>
                </div>
            </div>
        </x-atoms.card>

    </div>



    <div class="grid grid-cols-1  gap-6 mt-6">
        <!-- Status Pendaftaran -->
        <x-atoms.card className="border w-full border-gray-200">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="ri-file-list-3-line text-blue-600 text-xl"></i>
                </div>
                <x-atoms.title text="Status Pendaftaran" size="lg" />
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-time-line text-yellow-600"></i>
                        <span class="text-sm font-medium text-yellow-800">Menunggu Verifikasi</span>
                    </div>
                    <x-atoms.badge text="{{ $pendaftaranStats['pending'] }}" variant="gold" size="sm" />
                </div>

                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-check-line text-green-600"></i>
                        <span class="text-sm font-medium text-green-800">Diterima</span>
                    </div>
                    <x-atoms.badge text="{{ $pendaftaranStats['diterima'] }}" variant="emerald" size="sm" />
                </div>

                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-close-line text-red-600"></i>
                        <span class="text-sm font-medium text-red-800">Ditolak</span>
                    </div>
                    <x-atoms.badge text="{{ $pendaftaranStats['ditolak'] }}" variant="danger" size="sm" />
                </div>
            </div>

            
        </x-atoms.card>


    </div>

    <!-- Upload Dokumen Guru -->
    @if(auth()->user()->isGuru())
    <div class="grid grid-cols-1 gap-6 mt-6">
        <x-atoms.card className="border w-full border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="ri-file-upload-line text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <x-atoms.title text="Dokumen Administrasi" size="lg" />
                        @if(auth()->user()->mapel)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                <i class="ri-book-line mr-1"></i> {{ auth()->user()->mapel->mapel_name }} - {{ auth()->user()->guru_approved_at ? 'Terverifikasi' : 'Belum di verifikasi' }}
                            </span>
                        @endif
                    </div>
                </div>
                <button wire:click="toggleUploadForm"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm flex items-center gap-2">
                    <i class="ri-add-line"></i>
                    Upload Dokumen
                </button>
            </div>

            @if(session()->has('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Upload -->
            @if($showUploadForm)
            <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <h4 class="font-medium text-gray-900 mb-4">Upload Dokumen Baru</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Dokumen</label>
                        <input type="text" wire:model="document_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Contoh: CV Terbaru">
                        @error('document_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen</label>
                        <select wire:model="document_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Jenis</option>
                            <option value="cv">CV</option>
                            <option value="sertifikat">Sertifikat</option>
                            <option value="surat_lamaran">Surat Lamaran</option>
                            <option value="ijazah">Ijazah</option>
                            <option value="transkrip">Transkrip</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        @error('document_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">File (PDF/JPG/PNG, Max 5MB)</label>
                        <input type="file" wire:model="file"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-2">
                        <button wire:click="uploadDocument"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                            Simpan
                        </button>
                        <button wire:click="toggleUploadForm"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- List Dokumen -->
            <div class="space-y-3">
                @forelse($documents as $doc)
                    <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="ri-file-text-line text-gray-600"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-900">{{ $doc['document_name'] }}</h5>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                    <span class="capitalize">{{ str_replace('_', ' ', $doc['document_type']) }}</span>
                                    <span>•</span>
                                    <span>{{ \Carbon\Carbon::parse($doc['created_at'])->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($doc['status'] === 'pending')
                                <x-atoms.badge text="Pending" variant="gold" size="sm" />
                            @elseif($doc['status'] === 'approved')
                                <x-atoms.badge text="Approved" variant="emerald" size="sm" />
                            @else
                                <x-atoms.badge text="Rejected" variant="danger" size="sm" />
                            @endif

                            <a href="{{ asset('storage/' . $doc['file_path']) }}" target="_blank"
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <i class="ri-download-line"></i>
                            </a>

                            @if($doc['status'] === 'pending')
                            <button wire:click="deleteDocument({{ $doc['id'] }})"
                                    wire:confirm="Hapus dokumen ini?"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-file-line text-4xl mb-2"></i>
                        <p class="text-sm">Belum ada dokumen yang diupload</p>
                    </div>
                @endforelse
            </div>
        </x-atoms.card>
    </div>
    @endif



    <!-- Quick Actions -->
    <x-atoms.card className="mt-6 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                <i class="ri-links-line text-gray-600 text-xl"></i>
            </div>
            <div>
                <x-atoms.title text="Aksi Cepat" size="lg" />
                <x-atoms.description size="sm" color="gray-600">
                    Navigasi cepat ke halaman yang sering digunakan
                </x-atoms.description>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <!-- Review Test -->
            <a href="{{ route('guru.review-answers') }}"
               class="flex flex-col items-center p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow group">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-purple-200 transition-colors">
                    <i class="ri-file-text-line text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-900 text-center">Review Test</span>
                <span class="text-xs text-gray-500 text-center mt-1">Jawaban essay</span>
            </a>

            <!-- Kelola Test -->
            <a href="{{ route('guru.pendaftaran.custom-test') }}"
               class="flex flex-col items-center p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow group">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-orange-200 transition-colors">
                    <i class="ri-questionnaire-line text-orange-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-900 text-center">Kelola Test</span>
                <span class="text-xs text-gray-500 text-center mt-1">Custom test</span>
            </a>
        </div>
    </x-atoms.card>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush
