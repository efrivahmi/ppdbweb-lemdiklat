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
                {{-- Search & Filters --}}
                <div x-data="{ showFilters: false }" class="mb-4">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="flex-1">
                            <x-atoms.input
                                type="search"
                                wire:model.live="search"
                                placeholder="Cari siswa..."
                                class="w-full"
                            />
                        </div>
                        <button 
                            @click="showFilters = !showFilters"
                            class="p-2 border rounded-lg hover:bg-gray-50 text-gray-600 transition-colors"
                            :class="{ 'bg-lime-50 text-lime-600 border-lime-200': showFilters }"
                            title="Filter Data">
                            <x-heroicon-o-funnel class="w-5 h-5" />
                        </button>
                    </div>

                    {{-- Collapsible Filters --}}
                    <div x-show="showFilters" x-transition class="grid grid-cols-2 gap-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <select wire:model.live="statusFilter" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lime-500 focus:border-lime-500">
                            <option value="">Semua Status</option>
                            <option value="lengkap">Lengkap</option>
                            <option value="belum_lengkap">Belum Lengkap</option>
                            <option value="pendaftaran_diterima">Diterima</option>
                        </select>

                        <select wire:model.live="transferFilter" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lime-500 focus:border-lime-500">
                            <option value="">Semua Transfer</option>
                            <option value="pending">Transfer Pending</option>
                            <option value="success">Transfer Diterima</option>
                            <option value="decline">Transfer Ditolak</option>
                            <option value="no_transfer">Belum Upload</option>
                        </select>
                    </div>
                </div>

                {{-- Select All --}}
                <div class="flex items-center gap-2 mb-4 pb-4 border-b">
                    <input 
                        type="checkbox" 
                        id="selectAll"
                        wire:model.live="selectAll"
                        class="rounded border-gray-300 text-green-600 focus:ring-green-600"
                    >
                    <label for="selectAll" class="text-sm text-gray-700 cursor-pointer select-none">
                        Pilih Semua (halaman ini)
                    </label>
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
                        <div class="text-right flex-shrink-0 flex flex-col items-end gap-1">
                            @php
                                $phones = [
                                    'S' => $student->dataMurid?->whatsapp ?? $student->telp,
                                    'A' => $student->dataOrangTua?->telp_ayah,
                                    'I' => $student->dataOrangTua?->telp_ibu,
                                    'W' => $student->dataOrangTua?->telp_wali,
                                ];
                            @endphp
                            
                            {{-- Phone Indicators --}}
                            <div class="flex gap-1">
                                @foreach($phones as $label => $phone)
                                    <span 
                                        title="{{ $label == 'S' ? 'Siswa' : ($label == 'A' ? 'Ayah' : ($label == 'I' ? 'Ibu' : 'Wali')) }}: {{ $phone ?? 'Kosong' }}"
                                        class="text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-bold cursor-help
                                        {{ $phone ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-300' }}">
                                        {{ $label }}
                                    </span>
                                @endforeach
                            </div>
                            
                            
                            {{-- Selected Target Status --}}
                            <div class="text-xs mt-1 flex flex-col items-end gap-0.5">
                                @foreach($targetTypes as $type)
                                    @php
                                        $label = match($type) { 'ayah' => 'A', 'ibu' => 'I', 'wali' => 'W', default => 'S' };
                                        $targetPhone = match($type) {
                                            'ayah' => $phones['A'],
                                            'ibu' => $phones['I'],
                                            'wali' => $phones['W'],
                                            default => $phones['S'],
                                        };
                                    @endphp
                                    @if($targetPhone)
                                        <div class="flex items-center gap-1 text-[10px] text-green-600 font-medium">
                                            <span class="w-3 h-3 bg-green-100 rounded-full flex items-center justify-center text-[8px]">{{ $label }}</span>
                                            {{ $targetPhone }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
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

                {{-- Target Selection --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kirim Ke (Pilih satu atau lebih)</label>
                    <div class="flex p-1 bg-gray-100 rounded-lg gap-1">
                        @foreach(['siswa' => 'Siswa', 'ayah' => 'Ayah', 'ibu' => 'Ibu', 'wali' => 'Wali'] as $key => $label)
                        <button 
                            wire:click="toggleTargetType('{{ $key }}')"
                            class="flex-1 py-1.5 text-xs font-medium rounded-md transition-all flex items-center justify-center gap-1
                            {{ in_array($key, $targetTypes) ? 'bg-white text-green-700 shadow-sm ring-1 ring-green-100' : 'text-gray-500 hover:text-gray-700' }}">
                            @if(in_array($key, $targetTypes))
                                <x-heroicon-s-check class="w-3 h-3" />
                            @endif
                            {{ $label }}
                        </button>
                        @endforeach
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

                {{-- Attachment --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lampiran <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <div 
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        class="w-full">
                        
                        <input 
                            type="file" 
                            wire:model="attachment"
                            accept="image/*,application/pdf"
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-lime-50 file:text-lime-700
                                hover:file:bg-lime-100
                            "/>
                        
                        {{-- Upload Progress Info --}}
                        <div x-show="isUploading" class="mt-2 w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-lime-600 h-2.5 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                        </div>

                        @if($attachment)
                            <div class="mt-2 flex items-center gap-2 text-sm text-lime-600">
                                <x-heroicon-s-paper-clip class="w-4 h-4" />
                                <span>File terpilih: {{ $attachment->getClientOriginalName() }}</span>
                                <button type="button" wire:click="$set('attachment', null)" class="text-red-500 hover:text-red-700">
                                    <x-heroicon-s-x-mark class="w-4 h-4" />
                                </button>
                            </div>
                        @endif
                        
                        @error('attachment') 
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> 
                        @enderror
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
