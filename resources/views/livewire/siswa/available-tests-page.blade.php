<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Test</h1>

            {{-- Payment Warning --}}
            @if (!$paymentApproved)
            <div class="w-full bg-red-50 rounded-xl shadow-md p-4 border border-red-200 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="ri-error-warning-line text-xl text-red-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-red-800">Pembayaran Belum Diverifikasi</h2>
                        <p class="text-sm text-red-600">Silakan selesaikan pembayaran dan tunggu verifikasi admin untuk mengakses ujian.</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Urgent Schedule Badge --}}
            @if ($hasUrgentSchedule && $paymentApproved)
            <div class="w-full bg-orange-50 rounded-xl shadow-md p-4 border border-orange-200 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="ri-timer-flash-line text-xl text-orange-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-orange-800">Jadwal Ujian Khusus Aktif</h2>
                        @foreach($activeUrgentSchedules as $schedule)
                        <p class="text-sm text-orange-600">
                            {{ $schedule->nama }} - sampai {{ $schedule->waktu_selesai->format('d M Y H:i') }}
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if ($gelombangActive)
                @if (!$regularScheduleActive && !$hasUrgentSchedule && $paymentApproved)
                    <div class="w-full bg-white rounded-xl shadow-md p-4 border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">📅 Jadwal Ujian</h2>
                        <div class="space-y-2">
                            <p class="text-gray-600">
                                Ujian dimulai:
                                <span class="font-medium text-lime-600">{{ $gelombangActive->ujian_mulai->format('d M Y H:i') }}</span>
                            </p>
                            <p class="text-gray-600">
                                Berakhir:
                                <span class="font-medium text-lime-600">{{ $gelombangActive->ujian_selesai->format('d M Y H:i') }}</span>
                            </p>
                        </div>
                    </div>
                @elseif($canAccessTest)
                    <p class="text-green-600 font-semibold">✅ Sudah bisa dimulai</p>
                @endif
            @else
                <p class="text-red-500 font-medium">⚠️ Belum ada gelombang aktif saat ini</p>
            @endif

            <div class="mt-3">
                @if ($userRegistration)
                    <p class="text-gray-600">
                        Test untuk jalur pendaftaran:
                        <span class="font-semibold text-lime-600">{{ $userRegistration->jalurPendaftaran->nama }}</span>
                    </p>
                @else
                    <p class="text-red-500 font-medium">Anda belum terdaftar di jalur pendaftaran manapun</p>
                @endif
            </div>
            
            {{-- PDF Verification Download - Shows when all tests completed --}}
            @if ($allTestsCompleted && $paymentApproved)
            <div class="mt-6 w-full bg-gradient-to-r from-green-50 to-lime-50 rounded-xl shadow-md p-6 border border-green-200">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="ri-checkbox-circle-fill text-3xl text-green-600"></i>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-xl font-bold text-green-800">🎉 Selamat! Semua Test Selesai</h2>
                        <p class="text-sm text-green-600 mt-1">Anda telah menyelesaikan semua test. Silakan unduh formulir verifikasi pendaftaran Anda.</p>
                    </div>
                    <a href="{{ route('siswa.pdf.verifikasi') }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all shadow-md hover:shadow-lg">
                        <i class="ri-file-pdf-line text-lg"></i>
                        <span class="font-medium">Unduh Formulir Verifikasi</span>
                    </a>
                </div>
            </div>
            @endif
        </div>

        {{-- ====================== TES JALUR PENDAFTARAN ====================== --}}
        @php
            $tesJalur = collect($availableTests)->where('test.category', 'custom_test')->values();
        @endphp

        @if($userRegistration && $tesJalur->count() > 0)
        <div class="mb-12">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tes Jalur Pendaftaran</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tesJalur as $testData)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $testData['test']->nama_test }}
                            </h3>

                            @if($testData['has_completed'])
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="ri-check-line mr-1"></i> Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="ri-time-line mr-1"></i> Belum
                                </span>
                            @endif
                        </div>

                        <!-- Deskripsi -->
                        @if($testData['test']->deskripsi)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $testData['test']->deskripsi }}
                            </p>
                        @endif

                        <!-- Info Soal -->
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="ri-question-line mr-2"></i>
                                <span>{{ $testData['question_count'] }} soal total</span>
                            </div>

                            @if($testData['radio_count'] > 0 && $testData['essay_count'] > 0)
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="ri-list-check mr-2"></i>
                                    <span>{{ $testData['radio_count'] }} pilihan ganda, {{ $testData['essay_count'] }} essay</span>
                                </div>
                            @elseif($testData['radio_count'] > 0)
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="ri-list-check mr-2"></i>
                                    <span>{{ $testData['radio_count'] }} soal pilihan ganda</span>
                                </div>
                            @else
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="ri-file-text-line mr-2"></i>
                                    <span>{{ $testData['essay_count'] }} soal essay</span>
                                </div>
                            @endif
                        </div>

                        <!-- Aksi -->
                        <div class="pt-4 border-t border-gray-100">
                            @if($testData['has_completed'])
                                <a href="{{ route('siswa.test.take', $testData['test']->id) }}"
                                   class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                                    <i class="ri-eye-line mr-1"></i> Lihat Hasil
                                </a>
                            @elseif(!$paymentApproved)
                                <div class="space-y-2">
                                    <button disabled
                                       class="block w-full text-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                                        <i class="ri-lock-line mr-1"></i> Mulai Test
                                    </button>
                                    <p class="text-xs text-red-500 text-center">
                                        <i class="ri-error-warning-line mr-1"></i> Silakan selesaikan pembayaran terlebih dahulu
                                    </p>
                                </div>
                            @elseif(!$canAccessTest)
                                <div class="space-y-2">
                                    <button disabled
                                       class="block w-full text-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                                        <i class="ri-time-line mr-1"></i> Mulai Test
                                    </button>
                                    <p class="text-xs text-orange-500 text-center">
                                        <i class="ri-calendar-line mr-1"></i> Menunggu jadwal ujian
                                    </p>
                                </div>
                            @else
                                <a href="{{ route('siswa.test.take', $testData['test']->id) }}"
                                   class="block w-full text-center px-4 py-2 bg-lime-600 text-white rounded-lg hover:bg-lime-700 transition-colors text-sm">
                                    <i class="ri-play-line mr-1"></i> Mulai Test
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @elseif($userRegistration && $tesJalur->count() === 0)
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ri-file-list-line text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Test Jalur</h3>
                <p class="text-gray-600 max-w-md mx-auto">
                    Saat ini belum ada test yang tersedia untuk jalur pendaftaran Anda.
                </p>
            </div>
        @endif

        {{-- ====================== KUESIONER ORANG TUA ====================== --}}
        @php
            $kuesionerOrtu = collect($availableTests)->where('test.category', 'kuesioner_ortu')->values();
        @endphp

        @if($kuesionerOrtu->count() > 0)
        <div class="mt-16">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Kuesioner Orang Tua</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kuesionerOrtu as $testData)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $testData['test']->nama_test }}
                            </h3>

                            @if($testData['has_completed'])
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="ri-check-line mr-1"></i> Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="ri-time-line mr-1"></i> Belum
                                </span>
                            @endif
                        </div>

                        <!-- Deskripsi -->
                        @if($testData['test']->deskripsi)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $testData['test']->deskripsi }}
                            </p>
                        @endif

                        <!-- Info Soal -->
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="ri-question-line mr-2"></i>
                                <span>{{ $testData['question_count'] }} soal total</span>
                            </div>

                            @if($testData['radio_count'] > 0 && $testData['essay_count'] > 0)
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="ri-list-check mr-2"></i>
                                    <span>{{ $testData['radio_count'] }} pilihan ganda, {{ $testData['essay_count'] }} essay</span>
                                </div>
                            @elseif($testData['radio_count'] > 0)
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="ri-list-check mr-2"></i>
                                    <span>{{ $testData['radio_count'] }} soal pilihan ganda</span>
                                </div>
                            @else
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="ri-file-text-line mr-2"></i>
                                    <span>{{ $testData['essay_count'] }} soal essay</span>
                                </div>
                            @endif
                        </div>

                        <!-- Aksi -->
                        <div class="pt-4 border-t border-gray-100">
                            @if($testData['has_completed'])
                                <a href="{{ route('siswa.test.take', $testData['test']->id) }}"
                                   class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                                    <i class="ri-eye-line mr-1"></i> Lihat Jawaban
                                </a>
                            @elseif(!$paymentApproved)
                                {{-- Unpaid - Disabled button --}}
                                <div class="space-y-2">
                                    <button disabled
                                            class="block w-full text-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                                        <i class="ri-lock-line mr-1"></i> Isi Kuesioner
                                    </button>
                                    <p class="text-xs text-red-500 text-center">
                                        <i class="ri-error-warning-line mr-1"></i> Silakan selesaikan pembayaran terlebih dahulu
                                    </p>
                                </div>
                            @elseif(!$canAccessTest)
                                {{-- Schedule not active - Disabled button --}}
                                <div class="space-y-2">
                                    <button disabled
                                            class="block w-full text-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                                        <i class="ri-calendar-line mr-1"></i> Isi Kuesioner
                                    </button>
                                    <p class="text-xs text-orange-500 text-center">
                                        <i class="ri-calendar-line mr-1"></i> Menunggu jadwal ujian
                                    </p>
                                </div>
                            @else
                                <a href="{{ route('siswa.test.take', $testData['test']->id) }}"
                                   class="block w-full text-center px-4 py-2 bg-lime-600 text-white rounded-lg hover:bg-lime-700 transition-colors text-sm">
                                    <i class="ri-play-line mr-1"></i> Isi Kuesioner
                                </a>

                                <div class="mt-2 p-2 bg-yellow-50 rounded-lg text-center">
                                    <p class="text-xs text-yellow-600">
                                        <i class="ri-alert-line mr-1"></i> Kuesioner hanya bisa diisi sekali.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</div>

