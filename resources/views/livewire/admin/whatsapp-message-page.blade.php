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
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama, email, atau NISN..."
                            class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-lime-500 focus:border-lime-500">
                        
                        {{-- Search Icon (Left) --}}
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400" />
                        </div>

                        {{-- Filter Button (Right) --}}
                        <button 
                            @click="showFilters = !showFilters"
                            class="absolute inset-y-0 right-0 px-3 flex items-center hover:bg-gray-50 rounded-r-lg transition-colors border-l border-gray-200"
                            :class="{ 'text-lime-600 bg-lime-50': showFilters, 'text-gray-400': !showFilters }"
                            title="Filter Data">
                            <x-heroicon-o-funnel class="w-5 h-5" />
                        </button>
                    </div>

                    {{-- Collapsible Filters --}}
                    <div x-show="showFilters" x-transition class="mt-2 grid grid-cols-2 gap-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
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

                {{-- Student Table --}}
                <div class="relative overflow-x-auto border rounded-lg">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-white uppercase bg-lime-600">
                            <tr>
                                <th scope="col" class="p-4 w-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox" wire:model.live="selectAll" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3 text-right">Kontak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" value="{{ $student->id }}" wire:model.live="selectedStudents" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-base">{{ $student->name }}</span>
                                        <span class="text-xs text-gray-500 font-mono">{{ $student->nisn }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @php
                                            $pendaftaranDiterima = $student->pendaftaranMurids->where('status', 'diterima')->count() > 0;
                                            $transferStatus = $student->buktiTransfer?->status;
                                        @endphp
                                        
                                        @if($pendaftaranDiterima)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">Diterima</span>
                                        @endif
                                        
                                        @if($transferStatus)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium border
                                                {{ $transferStatus == 'success' ? 'bg-blue-50 text-blue-700 border-blue-200' : 
                                                  ($transferStatus == 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 'bg-red-50 text-red-700 border-red-200') }}">
                                                {{ ucfirst($transferStatus) }}
                                            </span>
                                        @endif
                                        
                                        @if(!$pendaftaranDiterima && !$transferStatus)
                                            <span class="text-xs text-gray-400 italic">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col items-end gap-1">
                                        @php
                                            $phones = [
                                                'S' => $student->dataMurid?->whatsapp ?? $student->telp,
                                                'A' => $student->dataOrangTua?->telp_ayah,
                                                'I' => $student->dataOrangTua?->telp_ibu,
                                                'W' => $student->dataOrangTua?->telp_wali,
                                            ];
                                        @endphp
                                        <div class="flex gap-1 justify-end">
                                            @foreach($phones as $label => $phone)
                                                <span 
                                                    title="{{ $label == 'S' ? 'Siswa' : ($label == 'A' ? 'Ayah' : ($label == 'I' ? 'Ibu' : 'Wali')) }}: {{ $phone ?? 'Kosong' }}"
                                                    class="text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-bold cursor-help border
                                                    {{ $phone ? 'bg-green-100 text-green-700 border-green-200' : 'bg-gray-50 text-gray-400 border-gray-200' }}">
                                                    {{ $label }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <x-heroicon-o-users class="w-10 h-10 text-gray-400 mb-2" />
                                        <p>Tidak ada siswa ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($students->hasPages())
                <div class="mt-4">
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
