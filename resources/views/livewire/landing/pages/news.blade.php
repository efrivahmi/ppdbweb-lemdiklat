<div class="min-h-screen bg-gray-50">
    {{-- ==================== HERO HEADER ==================== --}}
    <div class="relative bg-gradient-to-br from-lime-600 via-lime-700 to-emerald-800 overflow-hidden">
        {{-- Decorative pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/20 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full bg-emerald-300/30 blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="text-center max-w-2xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/15 backdrop-blur-sm rounded-2xl mb-6 border border-white/20">
                    <x-heroicon-o-newspaper class="w-8 h-8 text-white" />
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3 tracking-tight">
                    Berita & Pengumuman
                </h1>
                <p class="text-lg text-lime-100/90 font-medium">
                    Informasi terkini dari Lemdiklat Taruna Nusantara Indonesia
                </p>
            </div>
        </div>
    </div>

    {{-- ==================== FILTER BAR ==================== --}}
    <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-gray-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <x-molecules.input-field label="" name="search" placeholder="Cari berita..."
                    wire:model.live.debounce.300ms="search" />

                @php
                    $categoryOptions = $categories
                        ->map(function ($cat) {
                            return ['value' => $cat->name, 'label' => $cat->name];
                        })
                        ->toArray();
                @endphp

                <x-molecules.select-field label="" name="selectedCategory" wire:model.live="selectedCategory"
                    placeholder="Semua Kategori" :options="$categoryOptions" />

                @php
                    $sortOptions = [
                        ['value' => 'latest', 'label' => 'Terbaru'],
                        ['value' => 'oldest', 'label' => 'Terlama'],
                        ['value' => 'title', 'label' => 'Judul A-Z'],
                    ];
                @endphp

                <x-molecules.select-field label="" name="sortBy" wire:model.live="sortBy" :options="$sortOptions" />
            </div>

            {{-- Active Filters --}}
            @if ($search || $selectedCategory)
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm text-gray-500 font-medium">Filter:</span>
                        @if ($search)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-lime-100 text-lime-700">
                                🔍 {{ $search }}
                            </span>
                        @endif
                        @if ($selectedCategory)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                📁 {{ $selectedCategory }}
                            </span>
                        @endif
                        <button wire:click="resetFilters" class="text-xs font-semibold text-red-500 hover:text-red-700 hover:underline transition-colors">
                            Reset Semua
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

        {{-- ==================== BERITA UTAMA (Priority News) ==================== --}}
        @if (!$search && !$selectedCategory && $featuredNews->count() > 0)
            <section>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <x-heroicon-s-star class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Berita Utama</h2>
                            <p class="text-sm text-gray-500">Dipilih oleh redaksi</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    @foreach ($featuredNews as $berita)
                        <x-molecules.priority-news-card :berita="$berita" :isPriority="true" :showFullContent="false" />
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ==================== BERITA TERBARU (Latest News) ==================== --}}
        @if (!$search && !$selectedCategory && isset($latestNews) && $latestNews->count() > 0)
            <section>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-lime-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-lime-500/20">
                            <x-heroicon-s-bolt class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Berita Terbaru</h2>
                            <p class="text-sm text-gray-500">Baru saja dipublikasikan</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($latestNews as $berita)
                        <x-molecules.news-card
                            :berita="$berita" 
                            buttonText="Baca Selengkapnya" 
                            :showDebug="false" 
                        />
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ==================== SEMUA BERITA (All News Grid) ==================== --}}
        <section>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl flex items-center justify-center shadow-lg shadow-gray-900/20">
                        <x-heroicon-s-squares-2x2 class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Semua Berita</h2>
                        <p class="text-sm text-gray-500">
                            Menampilkan {{ $news->count() }} dari {{ $news->total() }} berita
                            @if ($search || $selectedCategory)
                                yang sesuai dengan filter
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if ($news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($news as $berita)
                        <x-molecules.news-card
                            :berita="$berita" 
                            buttonText="Baca Selengkapnya" 
                            :showDebug="false" 
                        />
                    @endforeach
                </div>

                <div class="flex justify-center mt-8">
                    {{ $news->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-heroicon-o-document-magnifying-glass class="w-8 h-8 text-gray-400" />
                    </div>

                    @php
                        $hasFilters = $search || $selectedCategory;
                        $emptyTitle = $hasFilters ? 'Tidak ada berita yang ditemukan' : 'Belum ada berita';
                        $emptyDesc = $hasFilters
                            ? 'Coba ubah kata kunci pencarian atau hapus filter yang diterapkan.'
                            : 'Berita akan segera ditambahkan. Silakan kembali lagi nanti.';
                    @endphp

                    <h3 class="text-lg font-bold text-gray-700 mb-2">{{ $emptyTitle }}</h3>
                    <p class="text-gray-500 mb-6">{{ $emptyDesc }}</p>

                    @if ($hasFilters)
                        <button wire:click="resetFilters" class="px-5 py-2.5 bg-lime-600 text-white font-semibold rounded-xl hover:bg-lime-700 transition-colors shadow-md">
                            Reset Filter
                        </button>
                    @endif
                </div>
            @endif
        </section>
    </div>
</div>
