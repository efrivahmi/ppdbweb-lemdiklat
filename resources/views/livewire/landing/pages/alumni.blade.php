<div class="h-full bg-white">
    <div class="bg-gradient-to-br from-lime-500 via-lime-700 h-92 to-emerald-900 shadow-sm">
        <div class="flex items-center justify-center flex-col h-full space-y-2">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-academic-cap class="w-12 h-12 text-white" />
            </div>
            <x-atoms.title text="Alumni Berprestasi" size="3xl" class="text-white" />
            <x-atoms.description class="text-white">
                Bangga dengan para alumni terbaik yang telah mengabdi untuk bangsa dan negara
            </x-atoms.description>
        </div>
    </div>

    <div class="bg-gray-50 py-8">
        <div class="container mx-auto px-4 space-y-6">
            
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="w-full lg:w-1/3">
                    <x-molecules.input-field
                        label="Cari Alumni"
                        name="search"
                        placeholder="Cari alumni..."
                        wire:model.live.debounce.300ms="search"
                    />
                </div>

                <div class="w-full lg:w-auto">
                    <x-molecules.select-field
                        label="Urutkan"
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
                    class="px-5 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm
                        {{ is_null($jurusan_id) ? 'bg-lime-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100' }}"
                >
                    Semua Jurusan
                </button>
                
                @foreach($jurusans as $jurusan)
                    <button 
                        wire:click="filterByJurusan({{ $jurusan->id }})"
                        class="px-5 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm
                            {{ $jurusan_id == $jurusan->id ? 'bg-lime-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100' }}"
                    >
                        {{ $jurusan->nama }}
                    </button>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-4 text-sm text-gray-600 justify-center">
                <span>Total Alumni: <strong>{{ $totalAlumni }}</strong></span>
                <span>Alumni Pilihan: <strong>{{ $selectedAlumni }}</strong></span>
                @if($search)
                    <span>Hasil pencarian: "<strong>{{ $search }}</strong>"</span>
                @endif
                @if($jurusan_id)
                    <span>Filter: <strong>{{ $jurusans->find($jurusan_id)->nama ?? 'Unknown' }}</strong></span>
                @endif
            </div>

            @if($search || $jurusan_id || $sortBy !== 'latest')
                <div class="text-center">
                    <button 
                        wire:click="clearFilters"
                        class="text-sm text-lime-600 hover:text-lime-700 font-medium"
                    >
                        <x-heroicon-o-x-mark class="inline w-4 h-4 mr-1" />
                        Hapus semua filter
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white py-14">
        <div class="container mx-auto px-4">
            @if ($alumnis->count() > 0)
                @php
                $specialAlumnis = $alumnis->where('is_selected', true);
                $normalAlumnis = $alumnis->where('is_selected', false);
                @endphp

                @if ($specialAlumnis->count() > 0)
                    <div class="mb-16">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Alumni Terpilih</h2>
                            <p class="text-gray-600">Alumni berprestasi dengan pencapaian luar biasa</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                            @foreach ($specialAlumnis as $alumni)
                                <x-molecules.alumni-card-special :alumni="$alumni" />
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($normalAlumnis->count() > 0)
                    <div>
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Alumni Lainnya</h2>
                            <p class="text-gray-600">Para alumni yang telah berkontribusi bagi masyarakat</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach ($normalAlumnis as $alumni)
                                <x-molecules.alumni-card-normal :alumni="$alumni" />
                            @endforeach
                        </div>
                    </div>
                @endif

            @else
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <x-heroicon-o-user-group class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                        @if($search || $jurusan_id)
                            Tidak ada alumni yang sesuai dengan filter
                        @else
                            Tidak ada alumni ditemukan
                        @endif
                    </h3>
                    <p class="text-gray-500 text-lg mb-6">
                        @if($search || $jurusan_id)
                            Coba ubah filter atau kata kunci pencarian
                        @else
                            Belum ada data alumni yang tersedia
                        @endif
                    </p>
                    
                    @if($search || $jurusan_id)
                        <button 
                            wire:click="clearFilters"
                            class="px-6 py-3 bg-lime-500 text-white rounded-lg hover:bg-lime-600 transition-colors"
                        >
                            Tampilkan Semua Alumni
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div wire:loading.flex class="fixed inset-0 bg-black/50 items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <x-heroicon-o-arrow-path class="animate-spin h-8 w-8 text-lime-500" />
            <span class="text-gray-700 font-medium">Memuat data...</span>
        </div>
    </div>
</div>
