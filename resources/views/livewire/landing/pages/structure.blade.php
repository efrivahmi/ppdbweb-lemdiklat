<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-br from-lime-500 via-lime-700 h-92 to-emerald-900 shadow-sm">
        <div class="flex items-center justify-center flex-col h-full space-y-2 py-16">
            <div class="bg-gray-900/20 p-5 rounded-full">
                <x-heroicon-o-building-office-2 class="w-12 h-12 text-white" />
            </div>
            <x-atoms.title text="Struktur Organisasi" size="3xl" align="center" color="white" />
            <x-atoms.description color="white" class="text-center max-w-2xl px-4">
                Struktur organisasi menunjukkan hierarki kepemimpinan dan pembagian tugas 
                dalam mengelola kegiatan sekolah secara efektif dan efisien
            </x-atoms.description>
        </div>
    </div>

    <div class="container mx-auto px-2 md:px-4 py-8">
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($struktur as $person)
                    <x-molecules.struktur-card :person="$person" />
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-heroicon-o-users class="w-10 h-10 text-gray-400" />
                            </div>
                            <x-atoms.title text="Struktur Belum Tersedia" size="lg" align="center" class="text-gray-600 mb-2" />
                            <x-atoms.description class="text-gray-500">
                                Data struktur organisasi belum tersedia saat ini
                            </x-atoms.description>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        @if($fotoStruktur && $fotoStruktur->img)
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="text-center mb-8">
                <x-atoms.title text="Bagan Organisasi" size="2xl" align="center" class="text-gray-800" />
                <x-atoms.description class="text-gray-600">
                    {{ $fotoStruktur->nama }}
                </x-atoms.description>
            </div>

            <div class="flex justify-center">
                <img 
                    src="{{ $fotoStruktur->image_url }}" 
                    alt="{{ $fotoStruktur->nama }}"
                    class="max-w-full h-auto rounded-lg shadow-lg border border-gray-200"
                />
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="text-center">
                <x-heroicon-o-photo class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                <x-atoms.title text="Bagan Organisasi Belum Tersedia" size="xl" align="center" class="text-gray-500" />
                <x-atoms.description class="text-gray-400">
                    Gambar bagan organisasi belum diupload
                </x-atoms.description>
            </div>
        </div>
        @endif
    </div>
</div>