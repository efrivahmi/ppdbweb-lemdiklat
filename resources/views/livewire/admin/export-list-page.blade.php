<div>
    <x-atoms.breadcrumb currentPath="Hasil Ekspor Data" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col gap-4 mb-6">
            <x-atoms.title text="Daftar Hasil Ekspor" size="xl" />
            <p class="text-gray-500 text-sm">
                Proses ekspor data dengan volume besar mungkin memerlukan waktu. Status "Pending" berarti data sedang disiapkan di latar belakang.
            </p>

            <!-- Search -->
            <div class="w-full sm:w-1/3">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari nama file..." className="w-full" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama File</th>
                        <th scope="col" class="px-6 py-3">Tipe</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tanggal dibuat</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $job->filename }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $job->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($job->status === 'completed')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded flex items-center w-fit gap-1">
                                        <x-heroicon-o-check-circle class="w-4 h-4"/> Selesai
                                    </span>
                                @elseif($job->status === 'failed')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded flex items-center w-fit gap-1" title="{{ $job->error_message }}">
                                        <x-heroicon-o-x-circle class="w-4 h-4"/> Gagal
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded flex items-center w-fit gap-1">
                                        <div class="animate-spin rounded-full h-3 w-3 border-2 border-current border-t-transparent"></div>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $job->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($job->status === 'completed' && $job->file_path)
                                        <a href="{{ Storage::url($job->file_path) }}" download class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                                            <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> Download
                                        </a>
                                    @endif
                                    <button wire:click="delete({{ $job->id }})" wire:confirm="Yakin ingin menghapus riwayat ini?" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                                        <x-heroicon-o-trash class="w-4 h-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada riwayat ekspor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    </x-atoms.card>
</div>
