<div>
    <x-atoms.breadcrumb currentPath="Review Jawaban Essay" />

    <x-atoms.card className="mt-3">
        <!-- Header with Navigation -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                @if($currentView === 'tests')
                    <x-atoms.title text="Review Jawaban Essay" size="xl" />
                    <x-atoms.description size="sm" color="gray-600">
                        Pilih test untuk mereview jawaban essay siswa
                    </x-atoms.description>
                @elseif($currentView === 'users')
                    <div class="flex items-center gap-2 mb-2">
                        <button wire:click="backToTests" class="text-gray-500 hover:text-gray-700">
                            <x-heroicon-o-arrow-left class="w-5 h-5" />
                        </button>
                        <x-atoms.title text="{{ $selectedTest->nama_test }}" size="xl" />
                    </div>
                    <x-atoms.description size="sm" color="gray-600">
                        Pilih siswa untuk mereview jawaban essay atau reset test
                    </x-atoms.description>
                @else
                    <div class="flex items-center gap-2 mb-2">
                        <button wire:click="backToUsers" class="text-gray-500 hover:text-gray-700">
                            <x-heroicon-o-arrow-left class="w-5 h-5" />
                        </button>
                        <x-atoms.title text="Review Jawaban - {{ $selectedUser->name }}" size="xl" />
                    </div>
                    <x-atoms.description size="sm" color="gray-600">
                        Test: {{ $selectedTest->nama_test }}
                    </x-atoms.description>
                @endif
            </div>
            
            <!-- Search for users view -->
            @if($currentView === 'users')
            <div class="w-full md:w-64">
                <x-atoms.input
                    type="search"
                    wire:model.live="searchUser"
                    placeholder="Cari siswa..."
                    className="w-full"
                />
            </div>
            @endif
        </div>

        @if($currentView === 'tests')
        <!-- Tests List View -->
        <div class="space-y-4">
            @if(isset($tests) && $tests->count() > 0)
                @foreach($tests as $test)
                <x-atoms.card className="border border-gray-200 hover:shadow-md transition-shadow cursor-pointer" 
                              wire:click="viewTest({{ $test->id }})">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <x-heroicon-o-document-text class="w-6 h-6 text-indigo-600" />
                                    </div>
                                    <div class="flex-1">
                                        <x-atoms.title text="{{ $test->nama_test }}" size="lg" className="mb-2" />
                                        @if($test->deskripsi)
                                        <x-atoms.description color="gray-600" className="mb-3">
                                            {{ Str::limit($test->deskripsi, 150) }}
                                        </x-atoms.description>
                                        @endif
                                        
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                            <div class="flex items-center gap-1">
                                                <x-heroicon-o-users class="w-4 h-4" />
                                                <span>{{ $test->total_participants }} siswa mengerjakan</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <x-heroicon-o-question-mark-circle class="w-4 h-4" />
                                                <span>{{ $test->questions()->whereIn('tipe_soal', ['text', 'checkbox'])->count() }} soal essay/checkbox</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <x-heroicon-o-calendar-days class="w-4 h-4" />
                                                <span>{{ $test->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col lg:items-end gap-3">
                                <div class="flex flex-wrap gap-2">
                                    @if($test->essay_pending > 0)
                                    <x-atoms.badge 
                                        text="{{ $test->essay_pending }} menunggu review"
                                        variant="gold" 
                                        size="sm"
                                    />
                                    @endif
                                    
                                    @if($test->essay_reviewed > 0)
                                    <x-atoms.badge 
                                        text="{{ $test->essay_reviewed }} sudah direview"
                                        variant="emerald" 
                                        size="sm"
                                    />
                                    @endif
                                    
                                    @if($test->essay_pending == 0 && $test->essay_reviewed == 0)
                                    <x-atoms.badge 
                                        text="Tidak ada essay"
                                        variant="gray" 
                                        size="sm"
                                    />
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <span>Klik untuk review</span>
                                    <x-heroicon-o-arrow-right class="w-4 h-4" />
                                </div>
                            </div>
                        </div>
                    </div>
                </x-atoms.card>
                @endforeach
                
                @if($tests->hasPages())
                <div class="mt-6">
                    {{ $tests->links('vendor.pagination.tailwind') }}
                </div>
                @endif
            @else
                <div class="text-center py-16 flex justify-center flex-col items-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-heroicon-o-document-text class="w-10 h-10 text-gray-400" />
                    </div>
                    <x-atoms.title text="Tidak Ada Test" size="xl" className="text-gray-500 mb-3 text-center" />
                    <x-atoms.description color="gray-400" class="text-center max-w-md">
                        Belum ada test yang tersedia untuk direview
                    </x-atoms.description>
                </div>
            @endif
        </div>

        @elseif($currentView === 'users')
        <!-- Users List View -->
        <div class="space-y-4">
            @if(isset($users) && $users->count() > 0)
                @foreach($users as $user)
                <x-atoms.card className="border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                            <div class="flex items-start gap-4 flex-1" 
                                 wire:click="viewUserAnswers({{ $user->id }})" 
                                 style="cursor: pointer;">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <x-heroicon-o-user class="w-6 h-6 text-green-600" />
                                </div>
                                <div class="flex-1">
                                    <x-atoms.title text="{{ $user->name }}" size="lg" className="mb-1" />
                                    <x-atoms.description color="gray-600" className="mb-2">
                                        {{ $user->email }}
                                    </x-atoms.description>
                                    
                                    @if($user->nisn)
                                    <x-atoms.description color="gray-500" size="sm">
                                        NISN: {{ $user->nisn }}
                                    </x-atoms.description>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex flex-col lg:items-end gap-3">
                                <div class="flex flex-wrap gap-2">
                                    <x-atoms.badge 
                                        text="{{ $user->total_answers }} total jawaban"
                                        variant="sky" 
                                        size="sm"
                                    />
                                    
                                    @if($user->essay_pending > 0)
                                    <x-atoms.badge 
                                        text="{{ $user->essay_pending }} essay pending"
                                        variant="gold" 
                                        size="sm"
                                    />
                                    @endif
                                    
                                    @if($user->essay_reviewed > 0)
                                    <x-atoms.badge 
                                        text="{{ $user->essay_reviewed }} essay direview"
                                        variant="emerald" 
                                        size="sm"
                                    />
                                    @endif
                                    
                                    @if($user->essay_approved > 0)
                                    <x-atoms.badge 
                                        text="{{ $user->essay_approved }} essay benar"
                                        variant="emerald" 
                                        size="sm"
                                    />
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <button wire:click="viewUserAnswers({{ $user->id }})"
                                            class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-1">
                                        <x-heroicon-o-eye class="w-4 h-4" />
                                        <span>Review</span>
                                    </button>
                                    
                                    <button wire:click="resetTestForUserFromList({{ $user->id }})"
                                            wire:confirm="Yakin ingin mereset test untuk {{ $user->name }}? Siswa akan dapat mengerjakan test lagi dari awal."
                                            class="px-3 py-2 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition-colors flex items-center gap-1">
                                        <x-heroicon-o-arrow-path class="w-4 h-4" />
                                        <span>Reset Test</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-atoms.card>
                @endforeach
                
                @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-heroicon-o-users class="w-10 h-10 text-gray-400" />
                    </div>
                    <x-atoms.title text="Tidak Ada Siswa" size="xl" className="text-gray-500 mb-3" />
                    <x-atoms.description color="gray-400" class="text-center max-w-md">
                        @if($searchUser)
                            Tidak ditemukan siswa sesuai pencarian "{{ $searchUser }}"
                        @else
                            Belum ada siswa yang mengerjakan test ini
                        @endif
                    </x-atoms.description>
                </div>
            @endif
        </div>

        @else
        <!-- User Answers Detail View -->
        <div class="space-y-6">
            <!-- User Stats -->
            @if(isset($userStats))
            <x-atoms.card className="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
                <div class="p-6">
                    <x-atoms.title text="Statistik Jawaban" size="lg" className="mb-4" />
                    
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $userStats['total_score'] }}</div>
                            <div class="text-sm text-gray-600">Total Benar</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $userStats['radio_correct'] }}/{{ $userStats['radio_total'] }}</div>
                            <div class="text-sm text-gray-600">Pilihan Ganda</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $userStats['checkbox_approved'] }}/{{ $userStats['checkbox_total'] }}</div>
                            <div class="text-sm text-gray-600">Checkbox</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $userStats['essay_pending'] + $userStats['checkbox_pending'] }}</div>
                            <div class="text-sm text-gray-600">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-emerald-600">{{ $userStats['essay_approved'] + $userStats['checkbox_approved'] }}</div>
                            <div class="text-sm text-gray-600">Disetujui</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-blue-200">
                        @if(($userStats['essay_pending'] + $userStats['checkbox_pending']) > 0)
                        <x-atoms.button
                            wire:click="approveAllEssayForUser"
                            wire:confirm="Yakin ingin menyetujui semua jawaban essay dan checkbox yang pending?"
                            variant="success"
                            theme="light"
                            size="sm"
                            heroicon="check-badge"
                        >
                            Setujui Semua
                        </x-atoms.button>
                        <x-atoms.button
                            wire:click="rejectAllEssayForUser"
                            wire:confirm="Yakin ingin menolak semua jawaban essay dan checkbox yang pending?"
                            variant="danger"
                            theme="light"
                            size="sm"
                            heroicon="x-circle"
                        >
                            Tolak Semua
                        </x-atoms.button>
                        @endif
                        
                        <!-- Reset Test Button -->
                        <x-atoms.button
                            wire:click="resetTestForUser"
                            wire:confirm="Yakin ingin mereset test untuk {{ $selectedUser->name }}? Semua jawaban akan dihapus dan siswa dapat mengerjakan test lagi dari awal."
                            variant="danger"
                            theme="dark"
                            size="sm"
                            heroicon="arrow-path"
                        >
                            Reset Test
                        </x-atoms.button>
                    </div>
                </div>
            </x-atoms.card>
            @endif
            
            <!-- Answers by Type -->
            @if(isset($userAnswers))
                <!-- Radio Questions -->
                @if($userAnswers->has('radio') && $userAnswers['radio']->count() > 0)
                <x-atoms.card className="border border-gray-200">
                    <div class="bg-blue-50 px-6 py-4 border-b border-gray-200 rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-list-bullet class="w-6 h-6 text-blue-600" />
                            </div>
                            <x-atoms.title text="Soal Pilihan Ganda" size="lg" />
                            <x-atoms.badge 
                                text="{{ $userAnswers['radio']->where('is_correct', true)->count() }}/{{ $userAnswers['radio']->count() }} benar"
                                variant="blue" 
                                size="sm"
                            />
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @foreach($userAnswers['radio'] as $index => $answer)
                        @php
                            $options = $answer->customTestQuestion->options ?? [];
                            $userAnswer = $answer->jawaban;
                            $correctAnswer = $answer->customTestQuestion->jawaban_benar;
                        @endphp
                        <div class="border rounded-lg p-4 {{ $answer->is_correct ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                            <div class="flex justify-between items-start mb-3">
                                <x-atoms.title text="Soal {{ $index + 1 }}" size="sm" />
                                @if($answer->is_correct)
                                    <x-atoms.badge text="Benar" variant="emerald" size="sm" />
                                @else
                                    <x-atoms.badge text="Salah" variant="danger" size="sm" />
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <x-atoms.description color="gray-700" size="sm" className="mb-3">
                                    {{ $answer->customTestQuestion->pertanyaan }}
                                </x-atoms.description>
                                
                                <!-- All Options -->
                                @if(!empty($options))
                                <div class="bg-white rounded-lg p-3 mb-3 border border-gray-200">
                                    <div class="text-xs font-semibold text-gray-500 mb-2">Pilihan Jawaban:</div>
                                    <div class="space-y-1">
                                        @foreach($options as $key => $value)
<div class="flex items-start gap-2 text-sm">
    <span class="font-semibold text-gray-600 min-w-[20px]">
        {{ chr(65 + $key) }}.
    </span>
    <span class="text-gray-700">{{ $value }}</span>
</div>
@endforeach

                                    </div>
                                </div>
                                @endif
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="bg-white rounded-lg p-3 border {{ $answer->is_correct ? 'border-blue-300' : 'border-red-300' }}">
                                        <div class="text-xs font-semibold text-gray-500 mb-2">Jawaban siswa:</div>
                                        <div class="flex items-start gap-2">
                                            <span class="px-2 py-1 bg-blue-600 text-white rounded text-xs font-bold min-w-[24px] text-center">
                                                {{ $userAnswer }}
                                            </span>
                                            <span class="text-blue-900 text-sm flex-1">
                                                {{ $options[$userAnswer] ?? $userAnswer }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 border border-green-300">
                                        <div class="text-xs font-semibold text-gray-500 mb-2">Jawaban benar:</div>
                                        <div class="flex items-start gap-2">
                                            <span class="px-2 py-1 bg-green-600 text-white rounded text-xs font-bold min-w-[24px] text-center">
                                                {{ $correctAnswer }}
                                            </span>
                                            <span class="text-green-900 text-sm flex-1">
                                                {{ $options[$correctAnswer] ?? $correctAnswer }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </x-atoms.card>
                @endif
                
                                                <!-- Checkbox Questions -->
                @if($userAnswers->has('checkbox') && $userAnswers['checkbox']->count() > 0)
                <x-atoms.card className="border border-gray-200">
                    <div class="bg-purple-50 px-6 py-4 border-b border-gray-200 rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-check-circle class="w-6 h-6 text-purple-600" />
                            </div>
                            <x-atoms.title text="Soal Checkbox (Pilihan Ganda Kompleks)" size="lg" />
                            <x-atoms.badge 
                                text="{{ $userAnswers['checkbox']->whereNull('is_correct')->count() }} menunggu review"
                                variant="gold" 
                                size="sm"
                            />
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($userAnswers['checkbox'] as $index => $answer)
                        @php
                            $userCheckboxAnswers = is_string($answer->jawaban) 
                                ? json_decode($answer->jawaban, true) 
                                : (is_array($answer->jawaban) ? $answer->jawaban : [$answer->jawaban]);
                            $correctAnswers = is_string($answer->customTestQuestion->jawaban_benar)
                                ? json_decode($answer->customTestQuestion->jawaban_benar, true)
                                : (is_array($answer->customTestQuestion->jawaban_benar) ? $answer->customTestQuestion->jawaban_benar : [$answer->customTestQuestion->jawaban_benar]);
                            
                            // Get options for mapping
                            $options = $answer->customTestQuestion->options ?? [];
                            
                            // Helper function to get full answer text
                            $getAnswerText = function($key) use ($options) {
                                if (isset($options[$key])) {
                                    return $key . '. ' . $options[$key];
                                }
                                return $key;
                            };
                        @endphp
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <x-atoms.title text="Checkbox {{ $index + 1 }}" size="md" />
                                @if($answer->is_correct === null)
                                    <x-atoms.badge text="Pending Review" variant="gold" size="sm" />
                                @elseif($answer->is_correct)
                                    <x-atoms.badge text="Disetujui" variant="emerald" size="sm" />
                                @else
                                    <x-atoms.badge text="Ditolak" variant="danger" size="sm" />
                                @endif
                            </div>
                            
                            <!-- Question -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <x-atoms.title text="Pertanyaan:" size="sm" className="mb-2" />
                                <x-atoms.description color="gray-700">
                                    {{ $answer->customTestQuestion->pertanyaan }}
                                </x-atoms.description>
                            </div>
                            
                            <!-- All Options -->
                            @if(!empty($options))
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <x-atoms.title text="Pilihan Jawaban:" size="sm" className="mb-3" />
                                <div class="space-y-2">
                                    @foreach($options as $key => $value)
<div class="flex items-start gap-2 text-sm">
    <span class="font-semibold text-gray-600 min-w-[20px]">
        {{ chr(65 + $key) }}.
    </span>
    <span class="text-gray-700">{{ $value }}</span>
</div>
@endforeach

                                </div>
                            </div>
                            @endif
                            
                            <!-- Answers Comparison -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- User Answers -->
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <x-atoms.title text="Jawaban Siswa:" size="sm" className="mb-3" />
                                    <div class="space-y-2">
                                        @foreach($userCheckboxAnswers as $ans)
                                        <div class="flex items-start gap-2 bg-blue-100 rounded-lg p-2">
                                            <span class="px-2 py-1 bg-blue-600 text-white rounded text-xs font-bold min-w-[28px] text-center">
                                                {{ $ans }}
                                            </span>
                                            <span class="text-blue-900 text-sm flex-1">
                                                {{ $options[$ans] ?? $ans }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Correct Answers -->
                                <div class="bg-green-50 rounded-lg p-4">
                                    <x-atoms.title text="Jawaban Benar:" size="sm" className="mb-3" />
                                    <div class="space-y-2">
                                        @foreach($correctAnswers as $ans)
                                        <div class="flex items-start gap-2 bg-green-100 rounded-lg p-2">
                                            <span class="px-2 py-1 bg-green-600 text-white rounded text-xs font-bold min-w-[28px] text-center">
                                                {{ $ans }}
                                            </span>
                                            <span class="text-green-900 text-sm flex-1">
                                                {{ $options[$ans] ?? $ans }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            @if($answer->is_correct === null)
                            <div class="flex gap-3">
                                <x-atoms.button
                                    wire:click="approveAnswer({{ $answer->id }})"
                                    variant="success"
                                    theme="light"
                                    heroicon="check"
                                    size="sm"
                                >
                                    Setujui
                                </x-atoms.button>
                                <x-atoms.button
                                    wire:click="rejectAnswer({{ $answer->id }})"
                                    variant="danger"
                                    theme="light"
                                    heroicon="x-mark"
                                    size="sm"
                                >
                                    Tolak
                                </x-atoms.button>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </x-atoms.card>
                @endif
                
                <!-- Essay Questions -->
                @if($userAnswers->has('text') && $userAnswers['text']->count() > 0)
                <x-atoms.card className="border border-gray-200">
                    <div class="bg-green-50 px-6 py-4 border-b border-gray-200 rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-document-text class="w-6 h-6 text-green-600" />
                            </div>
                            <x-atoms.title text="Soal Essay" size="lg" />
                            <x-atoms.badge 
                                text="{{ $userAnswers['text']->whereNull('is_correct')->count() }} menunggu review"
                                variant="gold" 
                                size="sm"
                            />
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($userAnswers['text'] as $index => $answer)
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <x-atoms.title text="Essay {{ $index + 1 }}" size="md" />
                                @if($answer->is_correct === null)
                                    <x-atoms.badge text="Pending Review" variant="gold" size="sm" />
                                @elseif($answer->is_correct)
                                    <x-atoms.badge text="Disetujui" variant="emerald" size="sm" />
                                @else
                                    <x-atoms.badge text="Ditolak" variant="danger" size="sm" />
                                @endif
                            </div>
                            
                            <!-- Question -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <x-atoms.title text="Pertanyaan:" size="sm" className="mb-2" />
                                <x-atoms.description color="gray-700">
                                    {{ $answer->customTestQuestion->pertanyaan }}
                                </x-atoms.description>
                            </div>
                            
                            <!-- Answer -->
                            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                <x-atoms.title text="Jawaban Siswa:" size="sm" className="mb-2" />
                                <x-atoms.description color="gray-700" className="whitespace-pre-wrap">
                                    {{ $answer->jawaban }}
                                </x-atoms.description>
                            </div>
                            
                            <!-- Actions -->
                            @if($answer->is_correct === null)
                            <div class="flex gap-3">
                                <x-atoms.button
                                    wire:click="approveAnswer({{ $answer->id }})"
                                    variant="success"
                                    theme="light"
                                    heroicon="check"
                                    size="sm"
                                >
                                    Setujui
                                </x-atoms.button>
                                <x-atoms.button
                                    wire:click="rejectAnswer({{ $answer->id }})"
                                    variant="danger"
                                    theme="light"
                                    heroicon="x-mark"
                                    size="sm"
                                >
                                    Tolak
                                </x-atoms.button>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </x-atoms.card>
                @endif
                
                @if((!$userAnswers->has('radio') || $userAnswers['radio']->count() == 0) && 
                    (!$userAnswers->has('checkbox') || $userAnswers['checkbox']->count() == 0) &&
                    (!$userAnswers->has('text') || $userAnswers['text']->count() == 0))
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-heroicon-o-document-text class="w-10 h-10 text-gray-400" />
                    </div>
                    <x-atoms.title text="Tidak Ada Jawaban" size="xl" className="text-gray-500 mb-3" />
                    <x-atoms.description color="gray-400" class="text-center max-w-md">
                        Siswa ini belum mengerjakan test atau data tidak ditemukan
                    </x-atoms.description>
                </div>
                @endif
            @endif
        </div>
        @endif
    </x-atoms.card>

    {{-- Loading overlays --}}
    <div wire:loading.flex wire:target="approveAnswer,rejectAnswer,approveAllEssayForUser,rejectAllEssayForUser,resetTestForUser,resetTestForUserFromList" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">Memproses...</span>
        </div>
    </div>
</div>

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
</script>
@endpush