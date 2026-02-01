<div class="h-full bg-gray-50">
    <div class="bg-gradient-to-br from-lime-500 via-lime-700 h-92 to-emerald-900 shadow-sm">
        <div class="flex items-center justify-center flex-col h-full space-y-2">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-trophy class="w-12 h-12 text-white " />
            </div>
            <x-atoms.title text="Prestasi & Pencapaian" size="3xl" color="white" />
            <x-atoms.description color="white">
                Membanggakan pencapaian siswa-siswi terbaik
            </x-atoms.description>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-molecules.input-field label="Cari Prestasi" name="search" placeholder="Masukkan kata kunci..."
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
                        <x-atoms.badge text="Pencarian: {{ $search }}" variant="gold" size="sm" />
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



        @if ($achievements->count() > 0)
            <div class="mb-4">
                <x-atoms.description class="text-gray-600">
                    Menampilkan {{ $achievements->count() }} dari {{ $achievements->total() }} prestasi
                    @if ($search || $selectedCategory)
                        yang sesuai dengan filter
                    @endif
                </x-atoms.description>
            </div>
        @endif

        @if ($achievements->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($achievements as $index => $prestasi)
                    <div wire:key="achievement-{{ $prestasi->id }}">
                        @php
                            $achievement = [
                                'id' => $prestasi->id,
                                'title' => $prestasi->title,
                                'description' => $prestasi->description,
                                'image' => $prestasi->image,
                                'category' => 'Prestasi',
                                'created_at' => $prestasi->created_at->format('d M Y'),
                            ];
                        @endphp
                        <x-molecules.achivement-card
                            :achievement="$achievement"
                            :index="$index"
                            buttonText="Lihat Detail"
                            className="h-full"
                        />
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $achievements->links() }}
            </div>
        @else
            <x-atoms.card class="text-center flex flex-col item-center" padding="p-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-magnifying-glass class="w-8 h-8 text-gray-400" />
                </div>

                @php
                    $hasFilters = $search || $selectedCategory;
                    $emptyTitle = $hasFilters ? 'Tidak ada prestasi yang ditemukan' : 'Belum ada prestasi';
                    $emptyDesc = $hasFilters
                        ? 'Coba ubah kata kunci pencarian atau hapus filter yang diterapkan.'
                        : 'Prestasi akan segera ditambahkan. Silakan kembali lagi nanti.';
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