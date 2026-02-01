<div class="h-full bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-br from-lime-500 via-lime-700 h-92 to-emerald-900 shadow-sm">
        <div class="flex items-center justify-center flex-col h-full space-y-2">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-building-office-2 class="w-12 h-12 text-white" />
            </div>
            <x-atoms.title text="Fasilitas Sekolah" size="3xl" class="text-white" />
            <x-atoms.description class="text-white text-center">
                Jelajahi fasilitas modern dan lengkap yang mendukung kegiatan belajar mengajar
            </x-atoms.description>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <!-- Results Info -->
        @if ($facilities->count() > 0)
            <div class="mb-6">
                <x-atoms.description class="text-gray-600">
                    Menampilkan {{ $facilities->count() }} fasilitas sekolah
                </x-atoms.description>
            </div>
        @endif

        @if ($facilities->count() > 0)
            <div class="space-y-8 mb-8">
                @foreach ($facilities as $index => $facility)
                    @php
                        $isEven = $index % 2 == 0;
                        $imageUrl = $facility->image ? asset('storage/' . $facility->image) : 'https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                    @endphp
                    
                    <div wire:key="facility-{{ $facility->id }}">
                        <article class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="grid grid-cols-1 md:grid-cols-2 {{ $isEven ? '' : 'md:grid-flow-col-dense' }}">
                                <!-- Image Section -->
                                <div class="h-64 md:h-80 overflow-hidden {{ $isEven ? '' : 'md:order-2' }}">
                                    <img
                                        src="{{ $imageUrl }}"
                                        alt="{{ $facility->name }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                        onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'"
                                    />
                                </div>

                                <!-- Content Section -->
                                <div class="p-8 flex flex-col justify-center {{ $isEven ? '' : 'md:order-1' }}">
                                    <x-atoms.title
                                        :text="$facility->name"
                                        size="xl"
                                        class="mb-4"
                                    />

                                    <x-atoms.description class="mb-6 text-gray-600 leading-relaxed">
                                        {{ $facility->description }}
                                    </x-atoms.description>

                                    <div class="space-y-3 text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <x-heroicon-o-calendar class="w-4 h-4 mr-3 text-emerald-600" />
                                            <span>Dibuat: {{ $facility->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        
                                        @if($facility->updated_at && $facility->updated_at != $facility->created_at)
                                            <div class="flex items-center">
                                                <x-heroicon-o-clock class="w-4 h-4 mr-3 text-amber-600" />
                                                <span>Diperbarui: {{ $facility->updated_at->format('d M Y, H:i') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Status indicator
                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="flex items-center text-emerald-600">
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                                            <span class="text-sm font-medium">Fasilitas Aktif</span>
                                        </div>
                                        
                                        <div class="text-xs text-gray-400">
                                            #{{ $facility->id }}
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @else
            <x-atoms.card class="text-center" padding="p-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-building-office-2 class="w-8 h-8 text-gray-400" />
                </div>

                <x-atoms.title text="Belum ada fasilitas" size="lg" class="mb-2 text-gray-600" align="center"/>
                <x-atoms.description class="text-gray-500 mb-6">
                    Fasilitas akan segera ditambahkan. Silakan kembali lagi nanti.
                </x-atoms.description>
            </x-atoms.card>
        @endif
    </div>
</div>