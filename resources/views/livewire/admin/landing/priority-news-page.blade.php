<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Berita Prioritas</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola berita yang ditampilkan sebagai highlight di halaman utama</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Left: Priority News List --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-yellow-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-star-fill text-amber-500"></i>
                    Berita Prioritas ({{ count($priorityNewsList) }}/4)
                </h2>
                <p class="text-sm text-gray-500 mt-1">#1 = Highlight utama, #2-4 = Berita di bawahnya</p>
            </div>
            <div class="p-4">
                @if(count($priorityNewsList) > 0)
                    <div class="space-y-3">
                        @foreach($priorityNewsList as $index => $news)
                            <div class="flex items-center gap-3 p-4 bg-amber-50 rounded-xl border border-amber-200">
                                {{-- Order Number --}}
                                <div class="flex-shrink-0 w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                
                                {{-- Thumbnail --}}
                                @if($news->thumbnail)
                                    <img src="{{ asset('storage/' . $news->thumbnail) }}" 
                                         alt="{{ $news->title }}" 
                                         class="w-16 h-12 object-cover rounded-lg flex-shrink-0">
                                @else
                                    <div class="w-16 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="ri-image-line text-gray-400"></i>
                                    </div>
                                @endif
                                
                                {{-- Title --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 truncate">{{ $news->title }}</h3>
                                    <p class="text-xs text-gray-500">{{ $news->kategori->name ?? 'Tanpa Kategori' }}</p>
                                </div>
                                
                                {{-- Actions --}}
                                <div class="flex items-center gap-1 flex-shrink-0">
                                    {{-- Move Up --}}
                                    <button wire:click="updateOrder({{ $news->id }}, 'up')"
                                            class="p-2 text-gray-500 hover:text-lime-600 hover:bg-lime-50 rounded-lg transition-colors {{ $index === 0 ? 'opacity-30 cursor-not-allowed' : '' }}"
                                            {{ $index === 0 ? 'disabled' : '' }}>
                                        <i class="ri-arrow-up-line"></i>
                                    </button>
                                    {{-- Move Down --}}
                                    <button wire:click="updateOrder({{ $news->id }}, 'down')"
                                            class="p-2 text-gray-500 hover:text-lime-600 hover:bg-lime-50 rounded-lg transition-colors {{ $index === count($priorityNewsList) - 1 ? 'opacity-30 cursor-not-allowed' : '' }}"
                                            {{ $index === count($priorityNewsList) - 1 ? 'disabled' : '' }}>
                                        <i class="ri-arrow-down-line"></i>
                                    </button>
                                    {{-- Remove --}}
                                    <button wire:click="removePriority({{ $news->id }})"
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <i class="ri-close-line"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <i class="ri-star-line text-4xl text-gray-300 mb-3"></i>
                        <p class="text-sm">Belum ada berita prioritas.</p>
                        <p class="text-xs text-gray-400 mt-1">Pilih berita dari daftar di sebelah kanan</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right: Available News --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ri-newspaper-line text-lime-600"></i>
                    Berita Tersedia
                </h2>
                <p class="text-sm text-gray-500 mt-1">Klik untuk menambahkan ke prioritas</p>
            </div>
            <div class="p-4">
                {{-- Search --}}
                <div class="mb-4">
                    <input type="text" wire:model.live.debounce.300ms="search" 
                           placeholder="Cari berita..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors">
                </div>
                
                @if(count($availableNews) > 0)
                    <div class="space-y-2 max-h-[500px] overflow-y-auto">
                        @foreach($availableNews as $news)
                            <button wire:click="togglePriority({{ $news->id }})"
                                    class="w-full flex items-center gap-3 p-3 bg-gray-50 hover:bg-lime-50 rounded-lg border border-gray-200 hover:border-lime-300 transition-all text-left group">
                                {{-- Thumbnail --}}
                                @if($news->thumbnail)
                                    <img src="{{ asset('storage/' . $news->thumbnail) }}" 
                                         alt="{{ $news->title }}" 
                                         class="w-14 h-10 object-cover rounded-lg flex-shrink-0">
                                @else
                                    <div class="w-14 h-10 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="ri-image-line text-gray-400 text-sm"></i>
                                    </div>
                                @endif
                                
                                {{-- Title --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 truncate group-hover:text-lime-700">{{ $news->title }}</h3>
                                    <p class="text-xs text-gray-500">{{ $news->kategori->name ?? 'Tanpa Kategori' }} • {{ $news->created_at->diffForHumans() }}</p>
                                </div>
                                
                                {{-- Add Icon --}}
                                <div class="flex-shrink-0 w-8 h-8 bg-lime-100 text-lime-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="ri-add-line"></i>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-file-list-line text-3xl text-gray-300 mb-2"></i>
                        <p class="text-sm">Tidak ada berita tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Info Box --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <i class="ri-information-line text-blue-500 text-xl mt-0.5"></i>
            <div>
                <h4 class="font-medium text-blue-900">Cara Menggunakan</h4>
                <ul class="text-sm text-blue-700 mt-1 space-y-1">
                    <li>• Klik berita dari daftar <strong>Berita Tersedia</strong> untuk menambahkannya ke prioritas</li>
                    <li>• Gunakan tombol panah <i class="ri-arrow-up-line"></i> <i class="ri-arrow-down-line"></i> untuk mengubah urutan</li>
                    <li>• Klik tombol <i class="ri-close-line"></i> untuk menghapus berita dari prioritas</li>
                    <li>• Berita prioritas akan ditampilkan sebagai highlight di halaman beranda</li>
                </ul>
            </div>
        </div>
    </div>
</div>
