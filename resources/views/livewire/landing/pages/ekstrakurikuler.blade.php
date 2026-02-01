<div class="h-full bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-lime-500 via-lime-700 to-emerald-900 shadow-sm">
        <div class="flex items-center justify-center flex-col h-92 space-y-2">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-academic-cap class="w-12 h-12 text-white" />
            </div>
            <x-atoms.title text="Ekstrakurikuler" size="3xl" color="white" />
            <x-atoms.description color="white">
                Wadah pengembangan minat, bakat, dan kreativitas siswa
            </x-atoms.description>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-molecules.input-field 
                label="Cari Ekstrakurikuler" 
                name="search" 
                placeholder="Masukkan kata kunci..."
                wire:model.live.debounce.300ms="search" 
            />

            @php
                $sortOptions = [
                    ['value' => 'latest', 'label' => 'Terbaru'],
                    ['value' => 'oldest', 'label' => 'Terlama'],
                    ['value' => 'title', 'label' => 'Judul A-Z'],
                ];
            @endphp

            <x-molecules.select-field 
                label="Urutkan" 
                name="sortBy" 
                wire:model.live="sortBy" 
                :options="$sortOptions" 
            />
        </div>

        @if ($search || $sortBy !== 'latest')
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm text-gray-600">Filter aktif:</span>
                    @if ($search)
                        <x-atoms.badge text="Pencarian: {{ $search }}" variant="gold" size="sm" />
                    @endif
                    @if ($sortBy !== 'latest')
                        <x-atoms.badge text="Urutkan: {{ ucfirst($sortBy) }}" variant="emerald" size="sm" />
                    @endif
                    <x-atoms.button 
                        variant="ghost" 
                        size="sm" 
                        wire:click="resetFilters"
                        class="text-red-600 hover:text-red-800"
                    >
                        Reset Semua
                    </x-atoms.button>
                </div>
            </div>
        @endif

        <!-- Info jumlah -->
        @if ($ekskul->count() > 0)
            <div class="mb-4">
                <x-atoms.description class="text-gray-600">
                    Menampilkan {{ $ekskul->count() }} dari {{ $ekskul->total() }} ekstrakurikuler
                    @if ($search)
                        yang sesuai dengan pencarian
                    @endif
                </x-atoms.description>
            </div>
        @endif

        <!-- List Ekstrakurikuler -->
        @if ($ekskul->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($ekskul as $index => $item)
                    <div wire:key="ekskul-{{ $item->id }}">
                        @php
                            $data = [
                                'id' => $item->id,
                                'title' => $item->title,
                                'desc' => $item->desc,
                                'img' => $item->img,
                            ];
                        @endphp
                        <x-molecules.eskul-card
                            :ekskul="$data"
                            :index="$index"
                            buttonText="Lihat Detail"
                            className="h-full"
                        />
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $ekskul->links() }}
            </div>
        @else
            <x-atoms.card class="text-center flex flex-col items-center" padding="p-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-magnifying-glass class="w-8 h-8 text-gray-400" />
                </div>

                <x-atoms.title text="Tidak ada ekstrakurikuler" size="lg" class="mb-2 text-gray-600" align="center"/>
                <x-atoms.description class="text-gray-500 mb-6">
                    Coba ubah kata kunci pencarian atau reset filter.
                </x-atoms.description>

                <x-atoms.button variant="primary" wire:click="resetFilters" class="mx-auto">
                    Reset Filter
                </x-atoms.button>
            </x-atoms.card>
        @endif
    </div>
</div>
