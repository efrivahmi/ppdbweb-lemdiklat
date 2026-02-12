<div class="min-h-screen bg-gray-50">
    {{-- Hero Header --}}
    <div class="relative bg-gradient-to-br from-lime-600 via-lime-700 to-emerald-800 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/20 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full bg-emerald-300/30 blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="text-center max-w-2xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/15 backdrop-blur-sm rounded-2xl mb-6 border border-white/20">
                    <x-heroicon-o-academic-cap class="w-8 h-8 text-white" />
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3 tracking-tight">
                    Alumni Berprestasi
                </h1>
                <p class="text-lg text-lime-100/90 font-medium">
                    Bangga dengan para alumni terbaik yang telah mengabdi untuk bangsa dan negara
                </p>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-gray-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 space-y-4">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="w-full lg:w-1/3">
                    <x-molecules.input-field
                        label=""
                        name="search"
                        placeholder="Cari alumni..."
                        wire:model.live.debounce.300ms="search"
                    />
                </div>

                <div class="w-full lg:w-auto">
                    <x-molecules.select-field
                        label=""
                        name="sortBy"
                        wire:model.live="sortBy"
                        :options="[
                            ['value' => 'latest', 'label' => 'Terbaru'],
                            ['value' => 'oldest', 'label' => 'Terlama'],
                            ['value' => 'name_asc', 'label' => 'Nama A-Z'],
                            ['value' => 'name_desc', 'label' => 'Nama Z-A'],
                            ['value' => 'tahun_lulus_desc', 'label' => 'Tahun Lulus Terbaru'],
                            ['value' => 'tahun_lulus_asc', 'label' => 'Tahun Lulus Terlama'],
                        ]"
                    />
                </div>
            </div>

            <div class="flex flex-wrap gap-2 justify-center">
                <button 
                    wire:click="$set('jurusan_id', null)"
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200
                        {{ is_null($jurusan_id) ? 'bg-lime-600 text-white shadow-md shadow-lime-600/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                >
                    Semua Jurusan
                </button>
                
                @foreach($jurusans as $jurusan)
                    <button 
                        wire:click="filterByJurusan({{ $jurusan->id }})"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200
                            {{ $jurusan_id == $jurusan->id ? 'bg-lime-600 text-white shadow-md shadow-lime-600/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                    >
                        {{ $jurusan->nama }}
                    </button>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-3 text-sm text-gray-500 justify-center">
                <span>Total: <strong class="text-gray-700">{{ $totalAlumni }}</strong></span>
                <span class="w-1 h-1 rounded-full bg-gray-300 self-center"></span>
                <span>Terpilih: <strong class="text-gray-700">{{ $selectedAlumni }}</strong></span>
                @if($search)
                    <span class="w-1 h-1 rounded-full bg-gray-300 self-center"></span>
                    <span>Pencarian: "<strong class="text-gray-700">{{ $search }}</strong>"</span>
                @endif
                @if($jurusan_id)
                    <span class="w-1 h-1 rounded-full bg-gray-300 self-center"></span>
                    <span>Filter: <strong class="text-gray-700">{{ $jurusans->find($jurusan_id)->nama ?? 'Unknown' }}</strong></span>
                @endif
            </div>

            @if($search || $jurusan_id || $sortBy !== 'latest')
                <div class="text-center">
                    <button wire:click="clearFilters"
                        class="text-sm text-red-500 hover:text-red-700 font-medium hover:underline transition-colors">
                        ✕ Hapus semua filter
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Alumni Grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        @if ($alumnis->count() > 0)
            @php
                $specialAlumnis = $alumnis->where('is_selected', true);
                $normalAlumnis = $alumnis->where('is_selected', false);
            @endphp

            @if ($specialAlumnis->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <x-heroicon-s-star class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Alumni Terpilih</h2>
                            <p class="text-sm text-gray-500">Alumni berprestasi dengan pencapaian luar biasa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                        @foreach ($specialAlumnis as $alumni)
                            <x-molecules.alumni-card-special :alumni="$alumni" />
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($normalAlumnis->count() > 0)
                <section>
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl flex items-center justify-center shadow-lg shadow-gray-900/20">
                            <x-heroicon-s-user-group class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Alumni Lainnya</h2>
                            <p class="text-sm text-gray-500">Para alumni yang telah berkontribusi bagi masyarakat</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                        @foreach ($normalAlumnis as $alumni)
                            <x-molecules.alumni-card-normal :alumni="$alumni" />
                        @endforeach
                    </div>
                </section>
            @endif

        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <x-heroicon-o-user-group class="w-10 h-10 text-gray-400" />
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">
                    @if($search || $jurusan_id)
                        Tidak ada alumni yang sesuai dengan filter
                    @else
                        Tidak ada alumni ditemukan
                    @endif
                </h3>
                <p class="text-gray-500 mb-6">
                    @if($search || $jurusan_id)
                        Coba ubah filter atau kata kunci pencarian
                    @else
                        Belum ada data alumni yang tersedia
                    @endif
                </p>
                
                @if($search || $jurusan_id)
                    <button wire:click="clearFilters"
                        class="px-6 py-2.5 bg-lime-600 text-white font-semibold rounded-xl hover:bg-lime-700 transition-colors shadow-md">
                        Tampilkan Semua Alumni
                    </button>
                @endif
            </div>
        @endif
    </div>

    {{-- Loading Overlay --}}
    <div wire:loading.flex class="fixed inset-0 bg-black/40 backdrop-blur-sm items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-2xl">
            <x-heroicon-o-arrow-path class="animate-spin h-6 w-6 text-lime-600" />
            <span class="text-gray-700 font-medium">Memuat data...</span>
        </div>
    </div>
</div>

