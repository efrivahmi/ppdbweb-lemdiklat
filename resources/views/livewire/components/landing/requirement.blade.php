<div class="" id="requirement">
    <div class="flex justify-center flex-col h-full space-y-2 mb-4 md:mb-6">
        <x-atoms.title 
            text="Persyaratan Pendaftaran" 
            highlight="Pendaftaran" 
            align="left" 
            size="2xl"
            mdSize="4xl"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-gray-100 h-fit">
                <div class="flex items-center gap-2 mb-3 md:mb-4">
                    <x-heroicon-o-user class="w-4 h-4 md:w-5 md:h-5 text-blue-600" />
                    <span class="text-xs md:text-sm font-semibold text-gray-600 uppercase tracking-wide">Persyaratan Fisik</span>
                </div>

                <x-atoms.title 
                    text="Standar Fisik Minimal" 
                    size="md"
                    mdSize="lg"
                    class="mb-3 md:mb-4" 
                />

                <x-atoms.description class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">
                    Pastikan memenuhi standar tinggi dan berat badan sesuai kategori
                </x-atoms.description>

                @if($physicalRequirements->count() > 0)
                    <div class="space-y-3 md:space-y-4">
                        @foreach ($physicalRequirements as $requirement)
                            @php
                                $colorClasses = [
                                    'blue' => [
                                        'bg' => 'bg-blue-50',
                                        'icon-bg' => 'bg-blue-100',
                                        'icon-text' => 'text-blue-600',
                                        'title' => 'text-blue-700',
                                        'value' => 'text-blue-700',
                                    ],
                                    'pink' => [
                                        'bg' => 'bg-pink-50',
                                        'icon-bg' => 'bg-pink-100',
                                        'icon-text' => 'text-pink-600',
                                        'title' => 'text-pink-700',
                                        'value' => 'text-pink-700',
                                    ],
                                ];
                                $colors = $colorClasses[$requirement['color']] ?? $colorClasses['blue'];
                            @endphp

                            <div class="{{ $colors['bg'] }} rounded-lg md:rounded-xl p-3 md:p-4">
                                <div class="text-center mb-3 md:mb-4">
                                    <div class="inline-flex items-center justify-center w-8 h-8 md:w-10 md:h-10 {{ $colors['icon-bg'] }} rounded-lg md:rounded-xl mb-2">
                                        <x-heroicon-o-user class="w-4 h-4 md:w-5 md:h-5 {{ $colors['icon-text'] }}" />
                                    </div>
                                    <x-atoms.title 
                                        :text="$requirement['gender']" 
                                        size="sm"
                                        mdSize="md"
                                        class="{{ $colors['title'] }}" 
                                    />
                                </div>

                                <div class="grid grid-cols-2 gap-2 md:gap-3">
                                    <div class="text-center p-2 md:p-3 bg-white rounded-lg">
                                        <x-heroicon-o-arrow-up class="w-3 h-3 md:w-4 md:h-4 mx-auto mb-1 {{ $colors['icon-text'] }}" />
                                        <p class="text-[10px] md:text-xs font-medium text-gray-500 mb-1">Tinggi Minimal</p>
                                        <p class="text-base md:text-xl font-bold {{ $colors['value'] }}">{{ $requirement['height'] }}</p>
                                    </div>

                                    <div class="text-center p-2 md:p-3 bg-white rounded-lg">
                                        <x-heroicon-o-scale class="w-3 h-3 md:w-4 md:h-4 mx-auto mb-1 {{ $colors['icon-text'] }}" />
                                        <p class="text-[10px] md:text-xs font-medium text-gray-500 mb-1">Berat Minimal</p>
                                        <p class="text-base md:text-xl font-bold {{ $colors['value'] }}">{{ $requirement['weight'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-4 md:p-6 bg-gray-50 rounded-lg md:rounded-xl">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 md:w-8 md:h-8 text-gray-400 mx-auto mb-2" />
                        <p class="text-xs md:text-sm text-gray-500">Data persyaratan fisik belum tersedia</p>
                    </div>
                @endif
            </div>

            @if($physicalRequirements->count() > 0 || $documents->count() > 0)
                <div class="mt-4 md:mt-8 bg-gradient-to-r from-lime-50 to-emerald-50 rounded-xl md:rounded-2xl p-4 md:p-6 border border-lime-200">
                    <div class="flex items-start gap-3 md:gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-lime-100 rounded-lg md:rounded-xl flex items-center justify-center">
                                <x-heroicon-o-information-circle class="w-4 h-4 md:w-5 md:h-5 text-lime-600" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <x-atoms.title 
                                text="Informasi Penting" 
                                size="sm"
                                mdSize="md"
                                class="text-lime-800 mb-2" 
                            />
                            <x-atoms.description class="text-lime-700 mb-2 md:mb-3 text-xs md:text-sm leading-relaxed">
                                Pastikan semua persyaratan di atas telah dipenuhi sebelum melakukan pendaftaran.
                                Dokumen yang tidak lengkap atau tidak sesuai ketentuan dapat menyebabkan pendaftaran ditolak.
                            </x-atoms.description>
                            <div class="flex items-center gap-2 text-xs md:text-sm text-lime-600">
                                <x-heroicon-o-clock class="w-3 h-3 md:w-4 md:h-4 flex-shrink-0" />
                                <span class="truncate">Data terakhir diperbarui: {{ now()->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-2 mb-3 md:mb-4">
                    <x-heroicon-o-document-text class="w-4 h-4 md:w-5 md:h-5 text-emerald-600" />
                    <span class="text-xs md:text-sm font-semibold text-gray-600 uppercase tracking-wide">Kelengkapan Administrasi</span>
                </div>

                <x-atoms.title 
                    text="Dokumen yang Diperlukan" 
                    size="md"
                    mdSize="lg"
                    class="mb-3 md:mb-4" 
                />

                <x-atoms.description class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">
                    Siapkan semua dokumen berikut dalam kondisi baik dan sesuai dengan jumlah yang ditentukan
                </x-atoms.description>

                @if($documents->count() > 0)
                    <div class="space-y-2 md:space-y-3">
                        @foreach ($documents as $index => $document)
                            <div class="bg-gray-50 rounded-lg md:rounded-xl p-3 md:p-4 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-3 md:gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-7 h-7 md:w-8 md:h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                            <span class="text-emerald-700 font-bold text-xs md:text-sm">{{ $index + 1 }}</span>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-gray-800 font-medium text-sm md:text-base">
                                            {{ $document['title'] }}
                                        </h4>
                                        @if(isset($document['description']) && $document['description'])
                                            <p class="text-[10px] md:text-xs text-gray-500 mt-0.5 md:mt-1 line-clamp-2">
                                                {{ $document['description'] }}
                                            </p>
                                        @endif
                                        <div class="flex items-center gap-1.5 md:gap-2 mt-1">
                                            <x-heroicon-o-check-circle class="w-3 h-3 text-emerald-500 flex-shrink-0" />
                                            <span class="text-[10px] md:text-xs text-gray-500">{{ $document['quantity'] }}</span>
                                        </div>
                                    </div>

                                    <!-- <div class="flex-shrink-0">
                                        <div class="px-2 py-1 bg-white rounded-lg border">
                                            <span class="text-xs md:text-sm font-semibold text-gray-700">{{ $document['quantity'] }}</span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-6 md:p-8 bg-gray-50 rounded-lg md:rounded-xl">
                        <x-heroicon-o-document-text class="w-10 h-10 md:w-12 md:h-12 text-gray-400 mx-auto mb-3 md:mb-4" />
                        <x-atoms.title 
                            text="Dokumen Persyaratan Belum Tersedia" 
                            size="sm"
                            mdSize="md"
                            class="text-gray-600 mb-2" 
                        />
                        <x-atoms.description class="text-gray-500 text-xs md:text-sm">
                            Daftar dokumen persyaratan akan segera ditambahkan. Silakan kembali lagi nanti.
                        </x-atoms.description>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>