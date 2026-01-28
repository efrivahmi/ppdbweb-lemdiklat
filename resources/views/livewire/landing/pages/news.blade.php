<div class="h-full bg-gray-50">
    <div class="bg-gradient-to-br from-lime-500 via-lime-700 h-92 to-emerald-900 shadow-sm">
        <div class="flex items-center justify-center flex-col h-full space-y-2">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-newspaper class="w-12 h-12 text-white " />
            </div>
            <x-atoms.title text="Berita & Pengumuman" size="3xl" class=" text-white" />
            <x-atoms.description class="text-white">
                Informasi terkini dari sekolah
            </x-atoms.description>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-molecules.input-field label="Cari Berita" name="search" placeholder="Masukkan kata kunci..."
                wire:model.live.debounce.300ms="search" />

            @php
                $categoryOptions = $categories
                    ->map(function ($cat) {
                        return ['value' => $cat->name, 'label' => $cat->name];
                    })
                    ->toArray();
            @endphp

            <x-molecules.select-field label="Kategori" name="selectedCategory" wire:model.live="selectedCategory"
                placeholder="Semua Kategori" :options="$categoryOptions" />

            @php
                $sortOptions = [
                    ['value' => 'latest', 'label' => 'Terbaru'],
                    ['value' => 'oldest', 'label' => 'Terlama'],
                    ['value' => 'title', 'label' => 'Judul A-Z'],
                ];
            @endphp

            <x-molecules.select-field label="Urutkan" name="sortBy" wire:model.live="sortBy" :options="$sortOptions" />
        </div>

        @if ($search || $selectedCategory)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm text-gray-600">Filter aktif:</span>
                    @if ($search)
                        <x-atoms.badge text="Pencarian: {{ $search }}" variant="sky" size="sm" />
                    @endif
                    @if ($selectedCategory)
                        <x-atoms.badge text="{{ $selectedCategory }}" variant="emerald" size="sm" />
                    @endif
                    <x-atoms.button variant="ghost" size="sm" wire:click="resetFilters"
                        class="text-red-600 hover:text-red-800">
                        Reset Semua
                    </x-atoms.button>
                </div>
            </div>
        @endif

        @if ($featuredNews->count() > 0)
            @php $showFeatured = !$search && !$selectedCategory; @endphp
            @if ($showFeatured)
                <div class="mb-8">
                    <x-atoms.title text="Berita Utama" size="2xl" class="mb-6" />
                    @foreach ($featuredNews as $berita)
                        <x-molecules.priority-news-card :berita="$berita" :isPriority="true" :showFullContent="false" />
                    @endforeach
                </div>
            @endif
        @endif

        @if ($news->count() > 0)
            <div class="mb-4">
                <x-atoms.description class="text-gray-600">
                    Menampilkan {{ $news->count() }} dari {{ $news->total() }} berita
                    @if ($search || $selectedCategory)
                        yang sesuai dengan filter
                    @endif
                </x-atoms.description>
            </div>
        @endif

        @if ($news->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($news as $berita)
                    <x-molecules.news-card
                        :berita="$berita" 
                        buttonText="Baca Selengkapnya" 
                        :showDebug="false" 
                    />
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $news->links() }}
            </div>
        @else
            <x-atoms.card class="text-center flex flex-col item-center" padding="p-12">
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

                <x-atoms.title :text="$emptyTitle" size="lg" class="mb-2 text-gray-600" align="center"/>
                <x-atoms.description class="text-gray-500 mb-6">
                    {{ $emptyDesc }}
                </x-atoms.description>

                @if ($hasFilters)
                    <x-atoms.button variant="primary" wire:click="resetFilters" class="mx-auto">
                        Reset Filter
                    </x-atoms.button>
                @endif
            </x-atoms.card>
        @endif
    </div>
</div>
