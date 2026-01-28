<div class="space-y-4 sm:space-y-6 px-4 sm:px-0">
    <x-atoms.breadcrumb current-path="Detail Siswa" />

    {{-- Header Profil --}}
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow border">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                <img src="{{ $user->profile_photo_url }}"
                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-indigo-500">
            </div>
            <div class="flex-1 text-center sm:text-left w-full">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-gray-600 text-base sm:text-lg">{{ $user->email }}</p>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mt-2 text-sm text-gray-600">
                    <span class="flex items-center justify-center sm:justify-start">
                        <i class="ri-phone-line mr-1"></i> {{ $user->telp ?? 'Tidak ada' }}
                    </span>
                    <span class="flex items-center justify-center sm:justify-start">
                        <i class="ri-id-card-line mr-1"></i> NISN: {{ $user->nisn ?? 'Tidak ada' }}
                    </span>
                    <span class="flex items-center justify-center sm:justify-start">
                        <i class="ri-user-star-line mr-1"></i> {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="w-full border-b border-b-gray-300 my-4"></div>

        <div class="mt-2">
            <h1 class="text-lg sm:text-xl font-semibold">Ganti Password</h1>
            <form class="space-y-4 mt-4" wire:submit.prevent='changePassword'>
                <x-molecules.input-field label="Password" inputType="password" name="password" id="password"
                    placeholder="Masukkan Password terbaru" wire:model.defer="password" :error="$errors->first('password')"
                    className="transition-all duration-200 focus:scale-[1.02]" required />
                <x-molecules.input-field label="Konfirmasi Password" inputType="password" name="password_confirmation"
                    id="password_confirmation" placeholder="Masukkan Password lagi"
                    wire:model.defer="password_confirmation" :error="$errors->first('password_confirmation')"
                    className="transition-all duration-200 focus:scale-[1.02]" required />

                <div class="w-full flex justify-end">
                    <x-atoms.button type="submit" variant="success" rounded="full" shadow="lg"
                        class="w-full sm:w-auto transform transition-all duration-200 hover:scale-[1.02] hover:shadow-xl">
                        Ganti Password
                    </x-atoms.button>
                </div>
            </form>
        </div>
    </div>

    {{-- Status Pendaftaran --}}
    @if ($user->pendaftaranMurids->count() > 0)
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow border">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Status Pendaftaran</h2>

        @foreach ($user->pendaftaranMurids as $pendaftaran)
        <div class="border rounded-lg p-3 sm:p-4 mb-4 last:mb-0">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-3 mb-3">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 flex-1">
                    <div>
                        <span class="text-xs sm:text-sm text-gray-500">Jalur Pendaftaran</span>
                        <p class="font-medium text-sm sm:text-base">{{ $pendaftaran->jalurPendaftaran->nama }}</p>
                    </div>
                    <div>
                        <span class="text-xs sm:text-sm text-gray-500">Tipe Sekolah</span>
                        <p class="font-medium text-sm sm:text-base">{{ $pendaftaran->tipeSekolah->nama }}</p>
                    </div>
                    <div>
                        <span class="text-xs sm:text-sm text-gray-500">Jurusan</span>
                        <p class="font-medium text-sm sm:text-base">{{ $pendaftaran->jurusan->nama }}</p>
                    </div>
                </div>

                {{-- Status Buttons --}}
                <div class="flex gap-2 flex-wrap lg:ml-4">
                    @foreach (['pending', 'diterima', 'ditolak'] as $status)
                    <button
                        wire:click="updateStatusPendaftaran({{ $pendaftaran->id }}, '{{ $status }}')"
                        class="px-3 py-1.5 text-xs font-semibold rounded-full transition flex-1 sm:flex-none
                                {{ $pendaftaran->status === $status
                                    ? ($status === 'diterima'
                                        ? 'bg-green-500 text-white'
                                        : ($status === 'ditolak'
                                            ? 'bg-red-500 text-white'
                                            : 'bg-yellow-500 text-white'))
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ ucfirst($status) }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Prestasi Section --}}
            @if($pendaftaran->jalurPendaftaran->nama === 'Prestasi')
            <div class="mt-4 p-3 sm:p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex flex-col sm:flex-row items-start gap-3">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-trophy-line text-yellow-600"></i>
                    </div>
                    <div class="flex-1 w-full">
                        <h4 class="font-semibold text-yellow-900 mb-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <span class="flex items-center">
                                <i class="ri-award-line mr-2"></i>
                                Bukti Prestasi
                            </span>
                            <span class="text-xs text-yellow-700">
                                {{ $pendaftaran->buktiPrestasis->count() }}/3 File
                            </span>
                        </h4>

                        @if($pendaftaran->has_prestasi && $pendaftaran->prestasi_detail)
                        <div class="bg-white border border-yellow-200 rounded-lg p-3 mb-3">
                            <p class="text-sm text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $pendaftaran->prestasi_detail }}</p>
                        </div>
                        @endif

                        {{-- Bukti Prestasi List --}}
                        @if($pendaftaran->buktiPrestasis->count() > 0)
                        <div class="space-y-2 mb-3">
                            @foreach($pendaftaran->buktiPrestasis as $bukti)
                            <div class="bg-white border border-yellow-200 rounded-lg p-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                                <div class="flex items-center gap-2 flex-1 min-w-0 w-full sm:w-auto">
                                    <i class="ri-file-{{ str_contains($bukti->file_type, 'pdf') ? 'pdf' : 'image' }}-line text-yellow-600 flex-shrink-0"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $bukti->file_name }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($bukti->file_size / 1024, 2) }} KB</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                    <a href="{{ asset('storage/' . $bukti->file_path) }}" target="_blank"
                                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded hover:bg-blue-200 transition">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <button wire:click="deleteBuktiPrestasi({{ $bukti->id }})"
                                        wire:confirm="Yakin ingin menghapus bukti prestasi ini?"
                                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-2 py-1 bg-red-100 text-red-700 text-xs rounded hover:bg-red-200 transition">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Upload Button --}}
                        @if($pendaftaran->canUploadMoreBuktiPrestasi())
                        <button wire:click="openBuktiPrestasiModal({{ $pendaftaran->id }})"
                            class="w-full inline-flex items-center justify-center px-3 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition">
                            <i class="ri-upload-line mr-2"></i>Upload Bukti Prestasi
                        </button>
                        @else
                        <div class="text-center text-xs text-yellow-700 bg-yellow-100 py-2 rounded">
                            <i class="ri-information-line mr-1"></i>
                            Maksimal 3 bukti prestasi sudah tercapai
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif


            {{-- Tahfidz Section --}}
            @if($pendaftaran->jalurPendaftaran->nama === 'Tahfidz Quran')
            <div class="mt-4 p-3 sm:p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex flex-col sm:flex-row items-start gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-book-open-line text-green-600"></i>
                    </div>
                    <div class="flex-1 w-full">
                        <h4 class="font-semibold text-green-900 mb-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <span class="flex items-center">
                                <i class="ri-quill-pen-line mr-2"></i>
                                Bukti Tahfidz
                            </span>
                            <span class="text-xs text-green-700">
                                {{ $pendaftaran->buktiTahfidzs->count() }}/3 File
                            </span>
                        </h4>

                        {{-- Bukti Tahfidz List --}}
                        @if($pendaftaran->buktiTahfidzs->count() > 0)
                        <div class="space-y-2 mb-3">
                            @foreach($pendaftaran->buktiTahfidzs as $bukti)
                            <div class="bg-white border border-green-200 rounded-lg p-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                                <div class="flex items-center gap-2 flex-1 min-w-0 w-full sm:w-auto">
                                    <i class="ri-file-{{ str_contains($bukti->file_type, 'pdf') ? 'pdf' : 'image' }}-line text-green-600 flex-shrink-0"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $bukti->file_name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ number_format($bukti->file_size / 1024, 1) }} KB
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-2 flex-shrink-0 w-full sm:w-auto">
                                    <a href="{{ asset('storage/' . $bukti->file_path) }}"
                                        target="_blank"
                                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-1.5 bg-green-100 text-green-700 text-xs rounded-lg hover:bg-green-200 transition">
                                        <i class="ri-eye-line mr-1"></i>Lihat
                                    </a>
                                    <button wire:click="deleteBuktiTahfidz({{ $bukti->id }})"
                                        onclick="return confirm('Yakin ingin menghapus bukti ini?')"
                                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-1.5 bg-red-100 text-red-700 text-xs rounded-lg hover:bg-red-200 transition">
                                        <i class="ri-delete-bin-line mr-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="bg-white border border-green-200 rounded-lg p-3 text-center">
                            <i class="ri-inbox-line text-green-300 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-500 italic">Belum ada bukti tahfidz</p>
                        </div>
                        @endif

                        {{-- Upload Button --}}
                        @if($pendaftaran->buktiTahfidzs->count() < 3)
                            <button wire:click="openBuktiTahfidzModal({{ $pendaftaran->id }})"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2 text-sm">
                            <i class="ri-upload-line"></i>
                            <span>Upload Bukti Tahfidz</span>
                            </button>
                            @else
                            <div class="text-center p-2 bg-green-100 rounded-lg">
                                <p class="text-xs text-green-700 font-medium">
                                    <i class="ri-checkbox-circle-line mr-1"></i>
                                    Maksimal 3 file telah tercapai
                                </p>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="text-xs sm:text-sm text-gray-500 mt-3">
                Tanggal Daftar: {{ $pendaftaran->created_at->format('d M Y H:i') }}
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Hasil Test --}}
    @if (count($testResults) > 0)
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow border">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Hasil Test</h2>

        <div class="space-y-4 sm:space-y-6">
            @foreach ($testResults as $result)
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                {{-- Test Header --}}
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-3 sm:gap-4">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ri-file-text-line text-indigo-600 text-lg sm:text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                                    {{ $result['test']->nama_test }}
                                </h3>
                                @if ($result['test']->deskripsi)
                                <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $result['test']->deskripsi }}</p>
                                @endif
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-2 text-xs sm:text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <i class="ri-calendar-line mr-1"></i>
                                        {{ $result['stats']['completed_at']->format('d M Y H:i') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="ri-question-line mr-1"></i>
                                        {{ $result['stats']['radio_total'] + $result['stats']['essay_total'] }} soal total
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Overall Score --}}
                        <div class="text-center bg-white rounded-lg p-3 sm:p-0 sm:bg-transparent">
                            <div class="text-2xl sm:text-3xl font-bold text-indigo-600">
                                {{ $result['stats']['percentage'] }}%
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500">Skor Keseluruhan</div>
                        </div>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-6">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xl sm:text-2xl font-bold text-green-600">
                                {{ $result['stats']['total_correct'] }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500">Total Benar</div>
                        </div>

                        @if ($result['stats']['radio_total'] > 0)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xl sm:text-2xl font-bold text-blue-600">
                                {{ $result['stats']['radio_correct'] }}/{{ $result['stats']['radio_total'] }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500">Pilihan Ganda</div>
                        </div>
                        @endif

                        @if ($result['stats']['essay_total'] > 0)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xl sm:text-2xl font-bold text-purple-600">
                                {{ $result['stats']['essay_correct'] }}/{{ $result['stats']['essay_reviewed'] }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500">Essay Direview</div>
                        </div>

                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xl sm:text-2xl font-bold text-yellow-600">
                                {{ $result['stats']['essay_pending'] }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500">Essay Pending</div>
                        </div>
                        @endif
                    </div>

                    {{-- Essay Review Section --}}
                    @if ($result['stats']['essay_pending'] > 0)
                    <div class="border-t pt-4">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                            <h4 class="font-semibold text-gray-900">Review Jawaban Essay</h4>
                            <button wire:click="approveAllEssayForTest({{ $result['test']->id }})"
                                wire:confirm="Yakin ingin menyetujui semua jawaban essay?"
                                class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                <i class="ri-check-double-line mr-1"></i>
                                Setujui Semua Essay
                            </button>
                        </div>

                        <div class="space-y-3">
                            @foreach ($result['answers']->where('customTestQuestion.tipe_soal', 'text')->whereNull('is_correct') as $answer)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-4">
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-2 mb-3">
                                    <h5 class="font-medium text-gray-900 text-sm sm:text-base flex-1">
                                        {{ $answer->customTestQuestion->pertanyaan }}
                                    </h5>
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full whitespace-nowrap">Pending</span>
                                </div>

                                <div class="bg-white border rounded-lg p-3 mb-3">
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap break-words">
                                        {{ $answer->jawaban }}
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    <button wire:click="approveEssayAnswer({{ $answer->id }})"
                                        class="flex-1 sm:flex-none px-3 py-1.5 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition">
                                        <i class="ri-check-line mr-1"></i>Setujui
                                    </button>
                                    <button wire:click="rejectEssayAnswer({{ $answer->id }})"
                                        class="flex-1 sm:flex-none px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                        <i class="ri-close-line mr-1"></i>Tolak
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Reviewed Essays --}}
                    @php
                    $reviewedEssays = $result['answers']
                    ->where('customTestQuestion.tipe_soal', 'text')
                    ->whereNotNull('is_correct');
                    @endphp

                    @if ($reviewedEssays->count() > 0)
                    <div class="border-t pt-4 mt-4">
                        <h4 class="font-semibold text-gray-900 mb-4">Essay yang Sudah Direview</h4>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4">
                            @foreach ($reviewedEssays as $answer)
                            <div class="border rounded-lg p-3 {{ $answer->is_correct ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <h6 class="text-sm font-medium text-gray-900 line-clamp-2 flex-1">
                                        {{ Str::limit($answer->customTestQuestion->pertanyaan, 60) }}
                                    </h6>
                                    <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap {{ $answer->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <i class="{{ $answer->is_correct ? 'ri-check-line' : 'ri-close-line' }} mr-1"></i>
                                        {{ $answer->is_correct ? 'Disetujui' : 'Ditolak' }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 line-clamp-3">
                                    {{ Str::limit($answer->jawaban, 100) }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Bukti Transfer --}}
    @if ($user->buktiTransfer)
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow border">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Bukti Transfer</h2>

        <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
            {{-- Image Preview --}}
            <div class="w-full lg:w-1/3">
                <div class="border rounded-lg p-4">
                    <h3 class="font-medium text-gray-900 mb-3">Gambar Bukti Transfer</h3>
                    <img src="{{ asset('storage/' . $user->buktiTransfer->transfer_picture) }}"
                        alt="Bukti Transfer"
                        class="w-full rounded-lg shadow-md cursor-pointer hover:opacity-90 transition"
                        onclick="window.open(this.src, '_blank')">
                    <p class="text-xs text-gray-500 mt-2 text-center">Klik untuk memperbesar</p>
                </div>
            </div>

            {{-- Transfer Info & Status --}}
            <div class="w-full lg:w-2/3">
                <div class="space-y-4">
                    {{-- Current Status --}}
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Status Saat Ini</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                            {{ match ($user->buktiTransfer->status) {
                                'success' => 'bg-green-100 text-green-800',
                                'decline' => 'bg-red-100 text-red-800',
                                default => 'bg-yellow-100 text-yellow-800',
                            } }}">
                            <i class="{{ match ($user->buktiTransfer->status) {
                                    'success' => 'ri-check-circle-line',
                                    'decline' => 'ri-close-circle-line',
                                    default => 'ri-time-line',
                                } }} mr-1"></i>
                            {{ match ($user->buktiTransfer->status) {
                                    'success' => 'Diterima',
                                    'decline' => 'Ditolak',
                                    default => 'Menunggu Verifikasi',
                                } }}
                        </span>
                    </div>

                    {{-- Status Actions --}}
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Ubah Status</h3>
                        <div class="flex gap-2 flex-wrap">
                            @foreach (['pending', 'success', 'decline'] as $status)
                            <button wire:click="updateStatusTransfer('{{ $status }}')"
                                class="flex-1 sm:flex-none px-4 py-2 text-sm font-semibold rounded-lg transition
                                        {{ $user->buktiTransfer->status === $status
                                            ? match ($status) {
                                                'success' => 'bg-green-500 text-white',
                                                'decline' => 'bg-red-500 text-white',
                                                default => 'bg-yellow-500 text-white',
                                            }
                                            : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                <i class="{{ match ($status) {
                                            'success' => 'ri-check-circle-line',
                                            'decline' => 'ri-close-circle-line',
                                            default => 'ri-time-line',
                                        } }} mr-1"></i>
                                {{ match ($status) {
                                            'success' => 'Terima',
                                            'decline' => 'Tolak',
                                            default => 'Pending',
                                        } }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Keterangan</h3>
                        <p class="text-sm sm:text-base text-gray-800 rounded-lg">
                            Atas Nama: <span class="font-medium">{{ $user->buktiTransfer->atas_nama }}</span>
                        </p>
                        <p class="text-sm sm:text-base text-gray-800 rounded-lg">
                            No Rekening: <span class="font-medium">{{ $user->buktiTransfer->no_rek }}</span>
                        </p>
                    </div>

                    {{-- Upload Date --}}
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Tanggal Upload</h3>
                        <p class="text-sm text-gray-600">
                            <i class="ri-calendar-line mr-1"></i>
                            {{ $user->buktiTransfer->created_at->format('d M Y H:i') }}
                        </p>
                        @if ($user->buktiTransfer->updated_at != $user->buktiTransfer->created_at)
                        <p class="text-sm text-gray-500">
                            <i class="ri-refresh-line mr-1"></i>
                            Terakhir diperbarui: {{ $user->buktiTransfer->updated_at->format('d M Y H:i') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Data Murid --}}
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow border">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Data Murid</h2>
            <button wire:click="toggleEditData"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="ri-edit-line mr-1"></i>
                {{ $showEditData ? 'Batal' : 'Edit' }}
            </button>
        </div>

        @if ($showEditData)
        {{-- Form Edit Data Murid --}}
        <form wire:submit.prevent="updateDataMurid" class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu Keluarga</label>
                <input type="text" wire:model="nomor_kartu_keluarga" maxlength="16"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    placeholder="Masukkan 16 digit nomor KK">
                @error('nomor_kartu_keluarga')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                <input type="text" wire:model="tempat_lahir"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('tempat_lahir')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" wire:model="tgl_lahir"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('tgl_lahir')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                <select wire:model="agama"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
                @error('agama')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                <input type="text" wire:model="whatsapp"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('whatsapp')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Asal Sekolah</label>
                <input type="text" wire:model="asal_sekolah"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('asal_sekolah')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Berat Badan (kg)</label>
                <input type="number" wire:model="berat_badan" step="0.1" min="1" max="999"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('berat_badan')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tinggi Badan (cm)</label>
                <input type="number" wire:model="tinggi_badan" step="0.1" min="1" max="999"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('tinggi_badan')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Riwayat Penyakit (kosongkan jika tidak ada)</label>
                <input type="text" wire:model="riwayat_penyakit"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('riwayat_penyakit')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-atoms.label for="jenis_kelamin">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </x-atoms.label>
                <div class="mt-2 space-y-2">
                    @foreach ($jenisKelaminOptions as $value => $label)
                    <label class="flex items-center cursor-pointer group">
                        <input type="radio" wire:model.blur="jenis_kelamin" value="{{ $value }}"
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
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                @error('alamat')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="md:col-span-2 flex flex-col sm:flex-row gap-2 sm:gap-3">
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="ri-save-line mr-1"></i> Simpan
                </button>
                <button type="button" wire:click="toggleEditData"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Batal
                </button>
            </div>
        </form>
        @else
        {{-- Display Data Murid --}}
        @if ($user->dataMurid)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-sm">
            <div>
                <span class="text-gray-500">Nomor Kartu Keluarga:</span>
                <p class="font-medium">{{ $user->dataMurid->nomor_kartu_keluarga ?? 'Belum diisi' }}</p>
            </div>
            <div>
                <span class="text-gray-500">Tempat Lahir:</span>
                <p class="font-medium">{{ $user->dataMurid->tempat_lahir ?? 'Belum diisi' }}</p>
            </div>
            <div>
                <span class="text-gray-500">Tanggal Lahir:</span>
                <p class="font-medium">{{ $user->dataMurid->getFormattedTglLahirAttribute() ?? 'Belum diisi' }}</p>
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
        @else
        <p class="text-gray-500 italic">Data murid belum diisi</p>
        @endif
        @endif
    </div>

    {{-- Data Orang Tua --}}
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow border">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Data Orang Tua</h2>
            <button wire:click="toggleEditOrangTua"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="ri-edit-line mr-1"></i>
                {{ $showEditOrangTua ? 'Batal' : 'Edit' }}
            </button>
        </div>

        @if ($showEditOrangTua)
        {{-- Form Edit Data Orang Tua --}}
        <form wire:submit.prevent="updateDataOrangTua" class="space-y-4 sm:space-y-6">
            {{-- Data Ayah --}}
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-indigo-700 mb-3">Data Ayah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                        <input type="text" wire:model="nama_ayah"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ayah</label>
                        <input type="text" wire:model="pendidikan_ayah"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon Ayah</label>
                        <input type="text" wire:model="telp_ayah"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                        <input type="text" wire:model="pekerjaan_ayah"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <x-molecules.select-field label="Penghasilan Ayah" name="penghasilan_ayah"
                        wire:model.defer="penghasilan_ayah" :options="collect($this->getPenghasilanOptions())
                                ->map(fn($label, $value) => ['value' => $value, 'label' => $label])
                                ->values()
                                ->toArray()"
                        placeholder="-- Pilih Range Penghasilan --" :error="$errors->first('penghasilan_ayah')" />
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Ayah</label>
                        <textarea wire:model="alamat_ayah" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                    </div>
                </div>
            </div>

            {{-- Data Ibu --}}
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-indigo-700 mb-3">Data Ibu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                        <input type="text" wire:model="nama_ibu"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ibu</label>
                        <input type="text" wire:model="pendidikan_ibu"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon Ibu</label>
                        <input type="text" wire:model="telp_ibu"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                        <input type="text" wire:model="pekerjaan_ibu"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <x-molecules.select-field label="Penghasilan Ibu" name="penghasilan_ibu"
                        wire:model.defer="penghasilan_ibu" :options="collect($this->getPenghasilanOptions())
                                ->map(fn($label, $value) => ['value' => $value, 'label' => $label])
                                ->values()
                                ->toArray()"
                        placeholder="-- Pilih Range Penghasilan --" :error="$errors->first('penghasilan_ibu')" />
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Ibu</label>
                        <textarea wire:model="alamat_ibu" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                    </div>
                </div>
            </div>

            {{-- Data Wali --}}
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-indigo-700 mb-3">Data Wali (Opsional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Wali</label>
                        <input type="text" wire:model="nama_wali"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Wali</label>
                        <input type="text" wire:model="pendidikan_wali"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon Wali</label>
                        <input type="text" wire:model="telp_wali"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Wali</label>
                        <input type="text" wire:model="pekerjaan_wali"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <x-molecules.select-field label="Penghasilan Wali" name="penghasilan_wali"
                        wire:model.defer="penghasilan_wali" :options="collect($this->getPenghasilanOptions())
                                ->map(fn($label, $value) => ['value' => $value, 'label' => $label])
                                ->values()
                                ->toArray()"
                        placeholder="-- Pilih Range Penghasilan --" :error="$errors->first('penghasilan_wali')" />
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Wali</label>
                        <textarea wire:model="alamat_wali" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="ri-save-line mr-1"></i> Simpan
                </button>
                <button type="button" wire:click="toggleEditOrangTua"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Batal
                </button>
            </div>
        </form>
        @else
        {{-- Display Data Orang Tua --}}
        @if ($user->dataOrangTua)
        <div class="space-y-4 sm:space-y-6">
            {{-- Data Ayah --}}
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-indigo-700 mb-3">Data Ayah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-sm">
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
                <h3 class="text-base sm:text-lg font-semibold text-indigo-700 mb-3">Data Ibu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-sm">
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
            @if ($user->dataOrangTua->nama_wali)
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-indigo-700 mb-3">Data Wali</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-sm">
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
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow border">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Berkas Murid</h2>
            <button wire:click="toggleUploadBerkas"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="ri-upload-line mr-1"></i>
                {{ $showUploadBerkas ? 'Batal' : 'Upload Berkas' }}
            </button>
        </div>

        @if ($showUploadBerkas)
        {{-- Form Upload Berkas --}}
        <form wire:submit.prevent="uploadBerkas" class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
            @php
            $berkasFields = [
            ['label' => 'Kartu Keluarga', 'name' => 'kartu_kelurga'],
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
                                file:mr-2 sm:file:mr-4 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4 
                                file:rounded-lg file:border-0 file:text-xs sm:file:text-sm 
                                file:font-semibold file:bg-indigo-50 file:text-indigo-700 
                                hover:file:bg-indigo-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error($field['name'])
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            @endforeach

            <div class="md:col-span-2 flex flex-col sm:flex-row gap-2 sm:gap-3">
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="ri-upload-line mr-1"></i> Upload
                </button>
                <button type="button" wire:click="toggleUploadBerkas"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Batal
                </button>
            </div>
        </form>
        @else
        {{-- Display Berkas --}}
        @if ($user->berkasMurid)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            @php
            $berkasFields = [
            ['label' => 'Kartu Keluarga', 'name' => 'kk'],
            ['label' => 'KTP Ortu', 'name' => 'ktp_ortu'],
            ['label' => 'Akte Kelahiran', 'name' => 'akte'],
            ['label' => 'Surat Sehat', 'name' => 'surat_sehat'],
            ['label' => 'Pas Foto', 'name' => 'pas_foto'],
            ];
            @endphp

            @foreach ($berkasFields as $field)
            <div class="border rounded-lg p-3 sm:p-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-medium text-gray-900 text-sm sm:text-base">{{ $field['label'] }}</h4>
                    @if ($user->berkasMurid->{$field['name']})
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">
                        <i class="ri-check-line mr-1"></i>Tersedia
                    </span>
                    @else
                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-semibold">
                        <i class="ri-close-line mr-1"></i>Belum
                    </span>
                    @endif
                </div>

                @if ($user->berkasMurid->{$field['name']})
                <div class="flex gap-2">
                    <a href="{{ asset('storage/' . $user->berkasMurid->{$field['name']}) }}"
                        target="_blank"
                        class="flex-1 inline-flex items-center justify-center px-3 py-1.5 bg-blue-100 text-blue-700 text-xs rounded-lg hover:bg-blue-200 transition">
                        <i class="ri-eye-line mr-1"></i>Lihat
                    </a>
                    <button wire:click="deleteBerkas('{{ $field['name'] }}')"
                        onclick="return confirm('Yakin ingin menghapus file ini?')"
                        class="flex-1 inline-flex items-center justify-center px-3 py-1.5 bg-red-100 text-red-700 text-xs rounded-lg hover:bg-red-200 transition">
                        <i class="ri-delete-bin-line mr-1"></i>Hapus
                    </button>
                </div>
                @else
                <p class="text-gray-500 text-xs sm:text-sm italic">File belum diupload</p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 italic">Belum ada berkas yang diupload</p>
        @endif
        @endif
    </div>

    {{-- Modal Upload Bukti Prestasi --}}
    @if($showBuktiPrestasiModal)
    @php
    $selectedPendaftaran = $user->pendaftaranMurids->firstWhere('id', $selectedPendaftaranId);
    @endphp
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        x-data
        @click.self="$wire.closeBuktiPrestasiModal()">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
                <div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900">
                        <i class="ri-trophy-line mr-2 text-yellow-600"></i>
                        Bukti Prestasi
                    </h3>
                    @if($selectedPendaftaran)
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        {{ $selectedPendaftaran->buktiPrestasis->count() }}/3 file terupload
                    </p>
                    @endif
                </div>
                <button wire:click="closeBuktiPrestasiModal"
                    class="text-gray-400 hover:text-gray-600 transition">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-4 sm:p-6">
                {{-- Existing Files --}}
                @if($selectedPendaftaran && $selectedPendaftaran->buktiPrestasis->count() > 0)
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">
                        <i class="ri-file-list-line mr-1"></i>
                        File yang Sudah Diupload
                    </h4>
                    <div class="space-y-2">
                        @foreach($selectedPendaftaran->buktiPrestasis as $bukti)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3 flex-1 min-w-0 w-full sm:w-auto">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="ri-file-{{ str_contains($bukti->file_type, 'pdf') ? 'pdf' : 'image' }}-line text-yellow-600 text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $bukti->file_name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ number_format($bukti->file_size / 1024, 2) }} KB
                                        • {{ $bukti->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <a href="{{ asset('storage/' . $bukti->file_path) }}" target="_blank"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-1.5 bg-blue-100 text-blue-700 text-xs rounded-lg hover:bg-blue-200 transition">
                                    <i class="ri-eye-line mr-1"></i>Lihat
                                </a>
                                <button wire:click="deleteBuktiPrestasi({{ $bukti->id }})"
                                    wire:confirm="Yakin ingin menghapus bukti prestasi ini?"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-1.5 bg-red-100 text-red-700 text-xs rounded-lg hover:bg-red-200 transition">
                                    <i class="ri-delete-bin-line mr-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Upload Form --}}
                @if($selectedPendaftaran && $selectedPendaftaran->canUploadMoreBuktiPrestasi())
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">
                        <i class="ri-upload-2-line mr-1"></i>
                        Upload File Baru
                    </h4>
                    <form wire:submit.prevent="uploadBuktiPrestasi">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih File Bukti Prestasi
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="file"
                                wire:model="bukti_prestasi"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                          file:mr-2 sm:file:mr-4 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4 
                                          file:rounded-lg file:border-0 file:text-xs sm:file:text-sm 
                                          file:font-semibold file:bg-yellow-50 file:text-yellow-700
                                          hover:file:bg-yellow-100 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="ri-information-line mr-1"></i>
                                Format: PDF, JPG, JPEG, PNG (Max: 2MB)
                            </p>
                            @error('bukti_prestasi')
                            <p class="mt-1 text-sm text-red-600">
                                <i class="ri-error-warning-line mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Upload Preview --}}
                        <div wire:loading wire:target="bukti_prestasi" class="mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                                <span>Memuat file...</span>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition flex items-center justify-center gap-2">
                            <i class="ri-upload-line"></i>
                            <span wire:loading.remove wire:target="uploadBuktiPrestasi">Upload Bukti Prestasi</span>
                            <span wire:loading wire:target="uploadBuktiPrestasi">Mengupload...</span>
                        </button>
                    </form>
                </div>
                @else
                <div class="text-center py-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <i class="ri-information-line text-yellow-600 text-2xl mb-2"></i>
                    <p class="text-sm text-yellow-800 font-medium">
                        Maksimal 3 bukti prestasi sudah tercapai
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Upload Bukti Tahfidz --}}
    @if($showBuktiTahfidzModal)
    @php
    $selectedPendaftaran = $user->pendaftaranMurids->firstWhere('id', $selectedPendaftaranId);
    @endphp
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        x-data
        @click.self="$wire.closeBuktiTahfidzModal()">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
                <div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900">
                        <i class="ri-book-open-line mr-2 text-green-600"></i>
                        Bukti Tahfidz
                    </h3>
                    @if($selectedPendaftaran)
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        {{ $selectedPendaftaran->buktiTahfidzs->count() }}/3 file terupload
                    </p>
                    @endif
                </div>
                <button wire:click="closeBuktiTahfidzModal"
                    class="text-gray-400 hover:text-gray-600 transition">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-4 sm:p-6">
                {{-- Existing Files --}}
                @if($selectedPendaftaran && $selectedPendaftaran->buktiTahfidzs->count() > 0)
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">
                        <i class="ri-file-list-line mr-1"></i>
                        File yang Sudah Diupload
                    </h4>
                    <div class="space-y-2">
                        @foreach($selectedPendaftaran->buktiTahfidzs as $bukti)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3 flex-1 min-w-0 w-full sm:w-auto">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="ri-file-{{ str_contains($bukti->file_type, 'pdf') ? 'pdf' : 'image' }}-line text-green-600 text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $bukti->file_name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ number_format($bukti->file_size / 1024, 1) }} KB •
                                        {{ \Carbon\Carbon::parse($bukti->created_at)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <a href="{{ asset('storage/' . $bukti->file_path) }}"
                                    target="_blank"
                                    class="px-3 py-1.5 bg-green-100 text-green-700 text-xs rounded-lg hover:bg-green-200 transition flex items-center gap-1">
                                    <i class="ri-eye-line"></i>
                                    <span class="hidden sm:inline">Lihat</span>
                                </a>
                                <button wire:click="deleteBuktiTahfidz({{ $bukti->id }})"
                                    onclick="return confirm('Yakin ingin menghapus file ini?')"
                                    class="px-3 py-1.5 bg-red-100 text-red-700 text-xs rounded-lg hover:bg-red-200 transition flex items-center gap-1">
                                    <i class="ri-delete-bin-line"></i>
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Upload Form --}}
                @if(!$selectedPendaftaran || $selectedPendaftaran->buktiTahfidzs->count() < 3)
                    <div>
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="ri-information-line text-green-600 mt-0.5"></i>
                            <div class="text-xs text-green-700">
                                <p class="font-medium mb-1">Format file yang diterima:</p>
                                <ul class="list-disc ml-4 space-y-0.5">
                                    <li>PDF, JPG, JPEG, atau PNG</li>
                                    <li>Maksimal 2MB per file</li>
                                    <li>Maksimal 3 file</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="uploadBuktiTahfidz">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ri-upload-cloud-line mr-1"></i>
                                Upload Bukti Tahfidz
                            </label>
                            <input type="file"
                                wire:model="bukti_tahfidz"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                file:mr-4 file:py-2 file:px-4 
                                file:rounded-lg file:border-0 file:text-sm 
                                file:font-semibold file:bg-green-50 file:text-green-700 
                                hover:file:bg-green-100 focus:ring-2 focus:ring-green-500 focus:border-green-500">

                            @error('bukti_tahfidz')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Loading Indicator --}}
                            <div wire:loading wire:target="bukti_tahfidz" class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memuat file...</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2"
                                wire:loading.attr="disabled"
                                wire:target="uploadBuktiTahfidz">
                                <i class="ri-upload-line"></i>
                                <span>Upload</span>
                            </button>
                            <button type="button"
                                wire:click="closeBuktiTahfidzModal"
                                class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                Batal
                            </button>
                        </div>
                    </form>
            </div>
            @else
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                <i class="ri-checkbox-circle-line text-green-500 text-3xl mb-2"></i>
                <p class="text-sm text-gray-700 font-medium">Maksimal 3 file telah tercapai</p>
                <p class="text-xs text-gray-500 mt-1">Hapus file yang ada untuk mengunggah file baru</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endif


{{-- Loading Overlay --}}
<div wire:loading.flex wire:target="approveEssayAnswer,rejectEssayAnswer,approveAllEssayForTest,uploadBuktiPrestasi,deleteBuktiPrestasi"
    class="fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white rounded-lg p-4 sm:p-6 flex items-center gap-3">
        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
        <span class="text-gray-700">Memproses...</span>
    </div>
</div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<style>
    /* Custom scrollbar for modal */
    @media (min-width: 640px) {
        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    window.addEventListener('success', event => {
        console.log('Success:', event.detail.message);
    });

    window.addEventListener('error', event => {
        console.log('Error:', event.detail.message);
    });

    window.addEventListener('info', event => {
        console.log('Info:', event.detail.message);
    });

    // Format Nomor Kartu Keluarga input - only allow numbers
    document.addEventListener('input', function(e) {
        if (e.target.name === 'nomor_kartu_keluarga') {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value.length > 16) {
                value = value.slice(0, 16);
            }
            e.target.value = value;
        }
    });
</script>
@endpush