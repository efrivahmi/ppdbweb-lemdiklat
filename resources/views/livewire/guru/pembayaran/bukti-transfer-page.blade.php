<div>
    <x-atoms.breadcrumb currentPath="Verifikasi Transfer" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Verifikasi Bukti Transfer" size="xl" />

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari siswa..." className="md:w-64" />

                <div class="relative">
                    <select wire:model.live="statusFilter"
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="success">Diterima</option>
                        <option value="decline">Ditolak</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Siswa</th>
                        <th scope="col" class="px-6 py-3">Bukti Transfer</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tanggal Upload</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($transfers->count() > 0)
                        @foreach ($transfers as $transfer)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50" x-data="{
                                showFullImage: false,
                                currentStatus: '{{ $transfer->status }}'
                            }">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            @if ($transfer->user->foto_profile)
                                                <img src="{{ asset('storage/' . $transfer->user->foto_profile) }}"
                                                    alt="{{ $transfer->user->name }}"
                                                    class="w-12 h-12 rounded-full object-cover">
                                            @else
                                                <x-heroicon-o-user class="w-6 h-6 text-lime-600" />
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 truncate">{{ $transfer->user->name }}
                                            </p>
                                            <div class="flex items-center gap-1 text-sm text-gray-600">
                                                <x-heroicon-o-identification class="w-3 h-3" />
                                                <span>NISN: {{ $transfer->user->nisn }}</span>
                                            </div>
                                            <div class="flex items-center gap-1 text-sm text-gray-500">
                                                <x-heroicon-o-envelope class="w-3 h-3" />
                                                <span class="truncate">{{ $transfer->user->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="relative w-20 h-20 group">
                                        <img src="{{ asset('storage/' . $transfer->transfer_picture) }}"
                                            alt="Bukti Transfer"
                                            class="w-20 h-20 object-cover rounded-lg border-2 border-gray-200 cursor-pointer hover:border-lime-400 transition-colors"
                                            @click="showFullImage = true">
                                    </div>

                                    <div x-show="showFullImage" x-transition.opacity @click="showFullImage = false"
                                        class="fixed inset-0 flex items-center justify-center z-50 overflow-y-auto"
                                        style="display: none;">
                                        <div class="max-w-4xl max-h-screen p-4" @click.stop>
                                            <img src="{{ asset('storage/' . $transfer->transfer_picture) }}"
                                                alt="Bukti Transfer"
                                                class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                                        </div>
                                        <button @click="showFullImage = false"
                                            class="absolute top-4 right-4 text-black p-2 bg-white bg-opacity-20 rounded-full hover:bg-opacity-30 transition">
                                            <x-heroicon-o-x-mark class="w-6 h-6" />
                                        </button>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div x-show="currentStatus === 'success'">
                                        <x-atoms.badge text="Diterima" variant="emerald" size="sm" />
                                    </div>
                                    <div x-show="currentStatus === 'decline'">
                                        <x-atoms.badge text="Ditolak" variant="danger" size="sm" />
                                    </div>
                                    <div x-show="currentStatus === 'pending'">
                                        <x-atoms.badge text="Pending" variant="gold" size="sm" />
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1 text-sm text-gray-600">
                                        <x-heroicon-o-calendar-days class="w-4 h-4 text-gray-400" />
                                        <span>{{ $transfer->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
                                        <x-heroicon-o-clock class="w-3 h-3" />
                                        <span>{{ $transfer->created_at->format('H:i') }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex gap-1 justify-center">
                                            <x-atoms.button wire:click="updateStatus({{ $transfer->id }}, 'success')"
                                                @click="currentStatus = 'success'" variant="success" size="sm"
                                                heroicon="check" className="!p-2 !min-h-[32px]" title="Terima" />

                                            <x-atoms.button wire:click="updateStatus({{ $transfer->id }}, 'pending')"
                                                @click="currentStatus = 'pending'" variant="warning" size="sm"
                                                heroicon="clock" className="!p-2 !min-h-[32px]" title="Pending" />

                                            <x-atoms.button wire:click="updateStatus({{ $transfer->id }}, 'decline')"
                                                @click="currentStatus = 'decline'"
                                                onclick="return confirm('Yakin ingin menolak transfer ini?')"
                                                variant="danger" size="sm" heroicon="x-mark"
                                                className="!p-2 !min-h-[32px]" title="Tolak" />
                                        </div>

                                        <div class="flex gap-2 mt-3">
                                            <a href="{{ route('admin.siswa.detail', $transfer->user->id) }}"
                                                class="flex-1 flex items-center justify-center gap-2 py-2 px-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200 text-sm">
                                                <x-heroicon-o-user class="w-4 h-4" />
                                                Profil
                                            </a>

                                            <a href="{{ asset('storage/' . $transfer->transfer_picture) }}"
                                                target="_blank"
                                                class="flex-1 flex items-center justify-center gap-2 py-2 px-3 bg-lime-600 hover:bg-lime-700 text-white rounded-lg transition-colors duration-200 text-sm">
                                                <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-12 text-gray-500" colspan="5">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-document-arrow-up class="w-8 h-8 text-gray-300" />
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <x-atoms.title :text="$search || $statusFilter
                                            ? 'Tidak ditemukan transfer sesuai filter'
                                            : 'Belum ada bukti transfer'" size="md" class="text-gray-600 mb-2" />
                                        <x-atoms.description color="gray-500">
                                            @if ($search || $statusFilter)
                                                Coba ubah kata kunci atau filter yang digunakan
                                            @else
                                                Bukti transfer dari siswa akan muncul di sini
                                            @endif
                                        </x-atoms.description>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($transfers->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $transfers->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>
</div>
