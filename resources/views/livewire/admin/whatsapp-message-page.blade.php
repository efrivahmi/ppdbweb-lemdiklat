<div>
    <x-atoms.breadcrumb currentPath="WhatsApp Message" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
        {{-- Left Panel: Student Selection --}}
        <div class="lg:col-span-2">
            <x-atoms.card>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <div>
                        <x-atoms.title text="Pilih Siswa" size="lg" />
                        <x-atoms.description size="sm" color="gray-500">
                            Pilih siswa untuk mengirim pesan WhatsApp
                        </x-atoms.description>
                    </div>

                    <div class="flex items-center gap-2">
                        @if(count($selectedStudents) > 0)
                        <span class="px-3 py-1 bg-lime-100 text-lime-700 rounded-full text-sm font-medium">
                            {{ count($selectedStudents) }} dipilih
                        </span>
                        <button wire:click="clearSelection" class="text-sm text-red-600 hover:text-red-700">
                            Hapus Pilihan
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="mb-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama, email, atau NISN..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-lime-500 focus:border-lime-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400" />
                        </div>
                    </div>
                </div>

                {{-- Select All --}}
                <div class="flex items-center gap-2 mb-4 pb-4 border-b">
                    <input 
                        type="checkbox" 
                        wire:model.live="selectAll"
                        id="selectAll"
                        class="rounded border-gray-300 text-lime-600 focus:ring-lime-500">
                    <label for="selectAll" class="text-sm text-gray-700">Pilih Semua (halaman ini)</label>
                </div>

                {{-- Student List --}}
                <div class="space-y-2 max-h-[500px] overflow-y-auto">
                    @forelse($students as $student)
                    <label 
                        for="student-{{ $student->id }}"
                        class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-colors
                            {{ in_array($student->id, $selectedStudents) ? 'border-lime-500 bg-lime-50' : 'border-gray-200 hover:bg-gray-50' }}">
                        <input 
                            type="checkbox" 
                            wire:model.live="selectedStudents"
                            value="{{ $student->id }}"
                            id="student-{{ $student->id }}"
                            class="rounded border-gray-300 text-lime-600 focus:ring-lime-500">
                        
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-gray-600 font-medium">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $student->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $student->email }}</p>
                        </div>
                        
                        <div class="text-right flex-shrink-0">
                            @php
                                $phone = $student->dataMurid?->whatsapp ?? $student->telp;
                            @endphp
                            @if($phone)
                            <span class="text-sm text-green-600 flex items-center gap-1">
                                <x-heroicon-s-check-circle class="w-4 h-4" />
                                {{ $phone }}
                            </span>
                            @else
                            <span class="text-sm text-red-500 flex items-center gap-1">
                                <x-heroicon-s-x-circle class="w-4 h-4" />
                                No WA
                            </span>
                            @endif
                        </div>
                    </label>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <x-heroicon-o-users class="w-12 h-12 mx-auto mb-2 text-gray-300" />
                        <p>Tidak ada siswa ditemukan</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($students->hasPages())
                <div class="mt-4 pt-4 border-t">
                    {{ $students->links('vendor.pagination.tailwind') }}
                </div>
                @endif
            </x-atoms.card>
        </div>

        {{-- Right Panel: Message Composer --}}
        <div class="lg:col-span-1">
            <x-atoms.card className="sticky top-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <x-heroicon-s-chat-bubble-left-right class="w-5 h-5 text-green-600" />
                    </div>
                    <div>
                        <x-atoms.title text="Tulis Pesan" size="lg" />
                        <x-atoms.description size="sm" color="gray-500">
                            Kirim ke {{ count($selectedStudents) }} siswa
                        </x-atoms.description>
                    </div>
                </div>

                {{-- Template Selection --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Template Pesan</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($templates as $key => $template)
                        <button 
                            wire:click="selectTemplate('{{ $key }}')"
                            class="px-3 py-2 text-xs rounded-lg border transition-colors text-left
                                {{ $selectedTemplate === $key ? 'border-lime-500 bg-lime-50 text-lime-700' : 'border-gray-200 hover:bg-gray-50' }}">
                            {{ $template['name'] }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Message Input --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pesan <span class="text-gray-400 font-normal">(gunakan {nama} untuk nama siswa)</span>
                    </label>
                    <textarea 
                        wire:model="customMessage"
                        rows="8"
                        placeholder="Tulis pesan WhatsApp di sini..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-lime-500 focus:border-lime-500 text-sm"></textarea>
                    <p class="text-xs text-gray-400 mt-1">{{ strlen($customMessage) }} karakter</p>
                </div>

                {{-- Send Button --}}
                <button 
                    wire:click="sendMessages"
                    wire:loading.attr="disabled"
                    wire:target="sendMessages"
                    @if(count($selectedStudents) === 0 || empty($customMessage)) disabled @endif
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="sendMessages">
                        <x-heroicon-s-paper-airplane class="w-5 h-5" />
                    </span>
                    <span wire:loading wire:target="sendMessages">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="sendMessages">Kirim WhatsApp</span>
                    <span wire:loading wire:target="sendMessages">Mengirim...</span>
                </button>

                @if(count($selectedStudents) === 0)
                <p class="text-xs text-center text-gray-400 mt-2">Pilih siswa terlebih dahulu</p>
                @endif

                {{-- Info --}}
                <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start gap-2">
                        <x-heroicon-s-exclamation-triangle class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" />
                        <div class="text-xs text-yellow-700">
                            <p class="font-medium mb-1">Perhatian!</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <li>Pastikan Fonnte API token sudah dikonfigurasi</li>
                                <li>Pesan dikirim satu per satu ke nomor WhatsApp siswa</li>
                                <li>Siswa tanpa nomor WhatsApp akan dilewati</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </x-atoms.card>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="sendMessages" class="fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"></div>
            <span class="text-gray-700">Mengirim pesan WhatsApp...</span>
        </div>
    </div>
</div>
