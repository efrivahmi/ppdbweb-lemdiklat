<div class="h-full bg-gray-50">
    <div class="bg-gradient-to-br from-lime-500 via-lime-700 h-92 to-emerald-900 shadow-sm">
        <div class="flex items-center justify-center flex-col h-full space-y-2">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-clipboard-document-check class="w-12 h-12 text-white" />
            </div>
            <x-atoms.title text="Persyaratan Pendaftaran" align="center" size="3xl" class="text-white" />
            <x-atoms.description class="text-white text-center">
                Lengkapi semua persyaratan berikut untuk proses pendaftaran yang lancar
            </x-atoms.description>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Physical Requirements Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 h-fit">
                    <div class="flex items-center gap-2 mb-4">
                        <x-heroicon-o-user class="w-5 h-5 text-blue-600" />
                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Persyaratan Fisik</span>
                    </div>
                    <x-atoms.title text="Standar Fisik Minimal" size="lg" class="mb-4" />
                    <x-atoms.description class="text-gray-600 mb-6">
                        Pastikan memenuhi standar tinggi dan berat badan sesuai kategori
                    </x-atoms.description>

                    @if($physicalRequirements->count() > 0)
                        <div class="space-y-4">
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

                                <div class="{{ $colors['bg'] }} rounded-xl p-4">
                                    <div class="text-center mb-4">
                                        <div class="inline-flex items-center justify-center w-10 h-10 {{ $colors['icon-bg'] }} rounded-xl mb-2">
                                            <x-heroicon-o-user class="w-5 h-5 {{ $colors['icon-text'] }}" />
                                        </div>
                                        <x-atoms.title :text="$requirement['gender']" size="md" class="{{ $colors['title'] }}" />
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="text-center p-3 bg-white rounded-lg">
                                            <x-heroicon-o-arrow-up class="w-4 h-4 mx-auto mb-1 {{ $colors['icon-text'] }}" />
                                            <p class="text-xs font-medium text-gray-500 mb-1">Tinggi Minimal</p>
                                            <p class="text-xl font-bold {{ $colors['value'] }}">{{ $requirement['height'] }}</p>
                                        </div>

                                        <div class="text-center p-3 bg-white rounded-lg">
                                            <x-heroicon-o-scale class="w-4 h-4 mx-auto mb-1 {{ $colors['icon-text'] }}" />
                                            <p class="text-xs font-medium text-gray-500 mb-1">Berat Minimal</p>
                                            <p class="text-xl font-bold {{ $colors['value'] }}">{{ $requirement['weight'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-6 bg-gray-50 rounded-xl">
                            <x-heroicon-o-exclamation-triangle class="w-8 h-8 text-gray-400 mx-auto mb-2" />
                            <p class="text-sm text-gray-500">Data persyaratan fisik belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Document Requirements Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center gap-2 mb-4">
                        <x-heroicon-o-document-text class="w-5 h-5 text-emerald-600" />
                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Kelengkapan Administrasi</span>
                    </div>
                    <x-atoms.title text="Dokumen yang Diperlukan" size="lg" class="mb-4" />
                    <x-atoms.description class="text-gray-600 mb-6">
                        Siapkan semua dokumen berikut dalam kondisi baik dan sesuai dengan jumlah yang ditentukan
                    </x-atoms.description>

                    @if($documents->count() > 0)
                        <div class="space-y-3">
                            @foreach ($documents as $index => $document)
                                <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                                <span class="text-emerald-700 font-bold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <h4 class="text-gray-800 font-medium">
                                                {{ $document['title'] }}
                                            </h4>
                                            @if(isset($document['description']) && $document['description'])
                                                <p class="text-xs text-gray-500 mt-1">{{ $document['description'] }}</p>
                                            @endif
                                            <div class="flex items-center gap-2 mt-1">
                                                <x-heroicon-o-check-circle class="w-3 h-3 text-emerald-500" />
                                                <span class="text-xs text-gray-500">Wajib dilengkapi</span>
                                            </div>
                                        </div>

                                        <div class="flex-shrink-0">
                                            <div class="px-2 py-1 bg-white rounded-lg border">
                                                <span class="text-xs font-semibold text-gray-700">{{ $document['quantity'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-8 bg-gray-50 rounded-xl">
                            <x-heroicon-o-document-text class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                            <x-atoms.title text="Dokumen Persyaratan Belum Tersedia" size="md" class="text-gray-600 mb-2" />
                            <x-atoms.description class="text-gray-500">
                                Daftar dokumen persyaratan akan segera ditambahkan. Silakan kembali lagi nanti.
                            </x-atoms.description>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        @if($physicalRequirements->count() > 0 || $documents->count() > 0)
            <div class="mt-8 bg-gradient-to-r from-lime-50 to-emerald-50 rounded-2xl p-6 border border-lime-200">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-lime-100 rounded-xl flex items-center justify-center">
                            <x-heroicon-o-information-circle class="w-5 h-5 text-lime-600" />
                        </div>
                    </div>
                    <div>
                        <x-atoms.title text="Informasi Penting" size="md" class="text-lime-800 mb-2" />
                        <x-atoms.description class="text-lime-700 mb-3">
                            Pastikan semua persyaratan di atas telah dipenuhi sebelum melakukan pendaftaran. 
                            Dokumen yang tidak lengkap atau tidak sesuai ketentuan dapat menyebabkan pendaftaran ditolak.
                        </x-atoms.description>
                        <div class="flex items-center gap-2 text-sm text-lime-600">
                            <x-heroicon-o-clock class="w-4 h-4" />
                            <span>Data terakhir diperbarui: {{ now()->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>