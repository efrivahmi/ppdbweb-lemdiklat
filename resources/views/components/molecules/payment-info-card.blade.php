<!-- Payment Info Card -->
<x-atoms.card className="border border-gray-200">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
            <i class="ri-money-dollar-circle-line text-green-600 text-xl"></i>
        </div>
        <x-atoms.title text="Informasi Biaya" size="lg" />
    </div>

    @if(count($jalurData) > 0)
        <div class="space-y-4 mb-6">
            @foreach($jalurData as $data)
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <x-atoms.title text="{{ $data['jalur']->nama }}" size="md" className="text-gray-900 mb-2" />
                            <div class="space-y-1">
                                @foreach($data['program_studi'] as $program)
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        <x-atoms.description size="sm" color="gray-600">
                                            {{ $program }}
                                        </x-atoms.description>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right">
                            <x-atoms.badge 
                                text="Rp{{ number_format($data['biaya'], 0, ',', '.') }}"
                                variant="emerald" 
                                size="md"
                            />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total Biaya -->
        <div class="border-t border-gray-200 pt-4">
            <div class="flex justify-between items-center">
                <x-atoms.title text="Total Biaya:" size="lg" className="text-gray-900" />
                <x-atoms.title text="Rp{{ number_format($totalBiaya, 0, ',', '.') }}" size="lg" className="text-green-600" />
            </div>
        </div>

        <!-- Informasi Transfer -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <x-atoms.title text="Informasi Transfer" size="md" className="text-blue-900 mb-3" />
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <x-atoms.description size="sm" color="blue-700" className="font-medium">Bank:</x-atoms.description>
                    <x-atoms.description size="sm" color="blue-900">BCA</x-atoms.description>
                </div>
                <div>
                    <x-atoms.description size="sm" color="blue-700" className="font-medium">No. Rekening:</x-atoms.description>
                    <x-atoms.description size="sm" color="blue-900">1234567890</x-atoms.description>
                </div>
                <div>
                    <x-atoms.description size="sm" color="blue-700" className="font-medium">Atas Nama:</x-atoms.description>
                    <x-atoms.description size="sm" color="blue-900">Yayasan Taruna Nusantara</x-atoms.description>
                </div>
                <div>
                    <x-atoms.description size="sm" color="blue-700" className="font-medium">Jumlah:</x-atoms.description>
                    <x-atoms.description size="sm" color="blue-900" className="font-bold">Rp{{ number_format($totalBiaya, 0, ',', '.') }}</x-atoms.description>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ri-money-dollar-circle-line text-gray-400 text-2xl"></i>
            </div>
            <x-atoms.title text="Belum Ada Pendaftaran" size="md" className="text-gray-500 mb-2" />
            <x-atoms.description color="gray-400">
                Silakan lengkapi pendaftaran terlebih dahulu untuk melihat informasi biaya.
            </x-atoms.description>
        </div>
    @endif
</x-atoms.card>