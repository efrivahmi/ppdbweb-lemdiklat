<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4">
        @if(!$showResult)
        <!-- Header Test -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $customTest->nama_test }}</h1>
                    @if($customTest->deskripsi)
                    <p class="text-gray-600">{{ $customTest->deskripsi }}</p>
                    @endif
                </div>
                <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                    <div class="text-center lg:text-right">
                        <div class="text-sm text-gray-500">Soal</div>
                        <div class="text-lg font-semibold text-lime-600">
                            {{ $currentQuestionIndex + 1 }} / {{ $totalQuestions }}
                        </div>
                    </div>
                    <div class="text-center lg:text-right">
                        <div class="text-sm text-gray-500">Terjawab</div>
                        <div class="text-lg font-semibold text-green-600">
                            {{ $answeredCount }} / {{ $totalQuestions }}
                        </div>
                    </div>
                    @if($timeElapsed > 0)
                    <div class="text-center lg:text-right">
                        <div class="text-sm text-gray-500">Waktu</div>
                        <div class="text-lg font-semibold text-purple-600">
                            {{ $timeElapsed }} menit
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-6">
                <div class="flex justify-between text-sm text-gray-500 mb-2">
                    <span>Progress</span>
                    <span>{{ number_format($progress, 1) }}%</span>
                </div>
                <div class="bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-lime-500 to-green-600 h-3 rounded-full transition-all duration-500 ease-out" 
                         style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>

        <!-- Question Navigation -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-sm font-medium text-gray-700">Navigasi Soal</h3>
                <div class="flex items-center gap-4 text-xs">
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 bg-lime-600 rounded"></div>
                        <span class="text-gray-600">Sedang dikerjakan</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 bg-green-100 border border-green-300 rounded"></div>
                        <span class="text-gray-600">Sudah dijawab</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 bg-gray-100 border border-gray-300 rounded"></div>
                        <span class="text-gray-600">Belum dijawab</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($questions as $index => $question)
                @php
                    $status = $this->getQuestionStatus($index);
                @endphp
                <button wire:click="goToQuestion({{ $index }})" 
                        class="relative w-10 h-10 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-opacity-50
                               @if($status === 'current')
                                   bg-lime-600 text-white shadow-lg
                               @elseif($status === 'answered')
                                   bg-green-100 text-green-700 border-2 border-green-300 hover:bg-green-200
                               @else
                                   bg-gray-100 text-gray-700 border-2 border-gray-300 hover:bg-gray-200
                               @endif">
                    {{ $index + 1 }}
                    @if($status === 'answered')
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                    @endif
                </button>
                @endforeach
            </div>
        </div>

        <!-- Current Question -->
        @if($currentQuestion)
        <div class="bg-white rounded-lg shadow-sm p-8 mb-6" wire:key="question-{{ $currentQuestionId }}">
            <div class="mb-8">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-lime-500 to-green-600 text-white rounded-full text-sm font-bold">
                            {{ $currentQuestionIndex + 1 }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900 leading-relaxed mb-4">
                            {{ $currentQuestion['pertanyaan'] }}
                        </h3>
                        
                        <!-- Question Image -->
                        @if(!empty($currentQuestion['image']))
                        <div class="mt-4 mb-6">
                            <img src="{{ asset('storage/' . $currentQuestion['image']) }}" 
                                 alt="Gambar soal {{ $currentQuestionIndex + 1 }}" 
                                 class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm">
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Answer Input -->
            <div class="ml-14">
                @if($currentQuestion['tipe_soal'] === 'radio')
                    <!-- Radio Options -->
                    <div class="space-y-3">
                        @foreach($currentQuestion['options'] as $optionIndex => $option)
                        @php
                            $optionValue = chr(65 + $optionIndex);
                            $isSelected = ($answers[$currentQuestionId] ?? '') === $optionValue;
                        @endphp
                        <div class="flex items-start gap-4 p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 hover:shadow-sm {{ $isSelected ? 'border-lime-500 bg-lime-50 shadow-sm' : 'border-gray-200 hover:border-gray-300' }}"
                             wire:click="selectAnswer({{ $currentQuestionId }}, '{{ $optionValue }}')">
                            <div class="flex items-center">
                                <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center {{ $isSelected ? 'border-lime-500 bg-lime-500' : 'border-gray-300' }}">
                                    @if($isSelected)
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-100 text-gray-600 rounded-full text-sm font-medium flex-shrink-0 {{ $isSelected ? 'bg-lime-100 text-lime-600' : '' }}">
                                        {{ $optionValue }}
                                    </span>
                                    <span class="text-gray-900 leading-relaxed">{{ $option }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                @elseif($currentQuestion['tipe_soal'] === 'checkbox')
                    <!-- Checkbox Options -->
                    <div class="space-y-3">
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <i class="ri-information-line text-blue-600 mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-blue-700">
                                    <strong>Pilih satu atau lebih jawaban</strong> yang sesuai menurut Anda
                                </span>
                            </div>
                        </div>

                        @foreach($currentQuestion['options'] as $optionIndex => $option)
                        @php
                            $optionValue = chr(65 + $optionIndex);
                            $currentAnswers = $answers[$currentQuestionId] ?? [];
                            $isChecked = in_array($optionValue, $currentAnswers);
                        @endphp
                        <div class="flex items-start gap-4 p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 hover:shadow-sm {{ $isChecked ? 'border-lime-500 bg-lime-50 shadow-sm' : 'border-gray-200 hover:border-gray-300' }}"
                             wire:click="toggleCheckbox({{ $currentQuestionId }}, '{{ $optionValue }}')">
                            <div class="flex items-center">
                                <div class="w-5 h-5 border-2 rounded flex items-center justify-center {{ $isChecked ? 'border-lime-500 bg-lime-500' : 'border-gray-300' }}">
                                    @if($isChecked)
                                    <i class="ri-check-line text-white text-sm font-bold"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-100 text-gray-600 rounded-full text-sm font-medium flex-shrink-0 {{ $isChecked ? 'bg-lime-100 text-lime-600' : '' }}">
                                        {{ $optionValue }}
                                    </span>
                                    <span class="text-gray-900 leading-relaxed">{{ $option }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                @else
                    <!-- Textarea -->
                    <div class="space-y-3">
                        <textarea wire:model.blur="answers.{{ $currentQuestionId }}" 
                                  id="answer_{{ $currentQuestionId }}"
                                  name="answer_{{ $currentQuestionId }}"
                                  autocomplete="off"
                                  rows="8"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors resize-none"
                                  placeholder="Tuliskan jawaban Anda di sini dengan lengkap dan jelas..."></textarea>
                        <div class="flex items-start gap-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <i class="ri-information-line text-green-600 mt-0.5 flex-shrink-0"></i>
                            <div class="text-sm text-green-700">
                                <p class="font-medium mb-1">Tips untuk jawaban essay:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>Jawab dengan lengkap dan jelas</li>
                                    <li>Gunakan bahasa yang baik dan benar</li>
                                    <li>Jawaban akan direview oleh admin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <button wire:click="previousQuestion" 
                        @if($currentQuestionIndex === 0) disabled @endif
                        class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <i class="ri-arrow-left-line"></i>
                    <span>Sebelumnya</span>
                </button>

                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    @if($currentQuestionIndex === count($questions) - 1)
                    <button wire:click="submitTest" 
                            wire:confirm="Yakin ingin mengirim jawaban? Test hanya bisa dikerjakan SEKALI dan tidak bisa diulang!"
                            wire:loading.attr="disabled"
                            wire:target="submitTest"
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50">
                        <span wire:loading.remove wire:target="submitTest">
                            <i class="ri-send-plane-line"></i>
                            <span>Kirim Jawaban</span>
                        </span>
                        <span wire:loading wire:target="submitTest" class="flex items-center gap-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                            <span>Mengirim...</span>
                        </span>
                    </button>
                    @else
                    <button wire:click="nextQuestion" 
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-lime-600 to-green-600 text-white rounded-lg hover:from-lime-700 hover:to-green-700 transition-all duration-200 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-lime-500">
                        <span>Selanjutnya</span>
                        <i class="ri-arrow-right-line"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        
        @else
        <!-- Result Page -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="mb-8">
                @if($scoreData['percentage'] >= 70)
                <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="ri-check-line text-4xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold text-green-600 mb-3">Selamat!</h2>
                <p class="text-gray-600 text-lg">Anda telah menyelesaikan test dengan baik</p>
                @else
                <div class="w-24 h-24 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="ri-information-line text-4xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold text-orange-600 mb-3">Test Selesai</h2>
                <p class="text-gray-600 text-lg">Anda telah menyelesaikan test</p>
                @endif
            </div>

            <div class="bg-gray-50 rounded-xl p-8 mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Hasil Test</h3>
                
                @if($scoreData['total_reviewed'] > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-green-600 mb-2">{{ $scoreData['total_correct'] }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Total Benar</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-red-500 mb-2">{{ $scoreData['total_reviewed'] - $scoreData['total_correct'] }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Total Salah</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-lime-600 mb-2">{{ number_format($scoreData['percentage'], 1) }}%</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Persentase</div>
                    </div>
                </div>
                
                <!-- Info bahwa test sudah selesai -->
                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center justify-center gap-2 text-green-700">
                        <i class="ri-information-line"></i>
                        <span class="font-medium">Test sudah selesai dikerjakan</span>
                    </div>
                    <p class="text-sm text-green-600 mt-2">
                        Test hanya bisa dikerjakan sekali. Untuk mengulang, silakan hubungi admin.
                    </p>
                </div>
                @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-file-text-line text-2xl text-yellow-600"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Menunggu Review</h4>
                    <p class="text-gray-600">Test ini hanya berisi soal essay/checkbox yang sedang menunggu review admin.</p>
                </div>
                @endif
            </div>

            <!-- Hanya tombol kembali ke dashboard, tidak ada tombol ulangi -->
            <div class="flex justify-center">
                <a href="{{ route('siswa.dashboard') }}" 
                   class="px-8 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <i class="ri-home-line"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Loading Overlay -->
    <div wire:loading.flex wire:target="submitTest" 
         class="fixed inset-0 bg-black bg-opacity-50 z-40 items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg p-8 flex flex-col items-center gap-4 shadow-2xl">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-lime-600 border-t-transparent"></div>
            <span class="text-gray-700 font-medium">Mengirim jawaban...</span>
            <p class="text-sm text-gray-500 text-center">Mohon tunggu, jangan tutup halaman ini</p>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
    // Prevent accidental page refresh during test
    window.addEventListener('beforeunload', function (e) {
        if (!@json($showResult)) {
            e.preventDefault();
            e.returnValue = 'Anda sedang mengerjakan test. Yakin ingin meninggalkan halaman?';
        }
    });

    // Toast notifications
    window.addEventListener('success', event => {
        alert('Success: ' + event.detail.message);
    });
    
    window.addEventListener('error', event => {
        alert('Error: ' + event.detail.message);
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (!@json($showResult)) {
            if (e.key === 'ArrowLeft' && e.ctrlKey) {
                e.preventDefault();
                @this.call('previousQuestion');
            } else if (e.key === 'ArrowRight' && e.ctrlKey) {
                e.preventDefault();
                @this.call('nextQuestion');
            }
        }
    });
</script>
@endpush