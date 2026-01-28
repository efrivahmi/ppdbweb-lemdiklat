<div>
    {{-- Breadcrumb --}}
    <x-atoms.breadcrumb currentPath="Link Youtube" />

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-lime-100 border border-lime-400 text-lime-700 rounded-lg flex items-center">
            <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
            <x-heroicon-o-x-circle class="w-5 h-5 mr-2" />
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Card Container --}}
    <x-atoms.card className="mt-3">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <x-atoms.title text="Tabel Link Youtube" size="xl" />
                <x-atoms.description size="sm" class="text-gray-600 mt-1">
                    Kelola video YouTube untuk ditampilkan di halaman landing
                </x-atoms.description>
            </div>

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input 
                    type="search" 
                    wire:model.live="search" 
                    placeholder="Cari video youtube..."
                    className="md:w-64" 
                />

                <x-atoms.button 
                    wire:click="create" 
                    variant="success" 
                    heroicon="plus" 
                    className="whitespace-nowrap"
                >
                    Tambah Video Youtube
                </x-atoms.button>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start gap-3">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" />
                <div>
                    <x-atoms.title text="Informasi" size="sm" class="text-blue-900 mb-1" />
                    <x-atoms.description size="xs" class="text-blue-800">
                        Video YouTube akan ditampilkan maksimal 4 item di halaman landing. Pastikan URL YouTube valid dan video dapat diakses publik.
                    </x-atoms.description>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Thumbnail</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">URL</th>
                        <th scope="col" class="px-6 py-3 text-center">Urutan</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($youtubeVideos->count() > 0)
                        @foreach ($youtubeVideos as $video)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if ($video->thumbnail)
                                        <div class="relative group">
                                            <img 
                                                src="{{ $video->thumbnail }}" 
                                                alt="{{ $video->title }}"
                                                class="w-32 h-20 object-cover rounded-lg border border-gray-200"
                                                onerror="this.src='https://via.placeholder.com/320x180/ef4444/ffffff?text=YouTube'; this.onerror=null;"
                                            >
                                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-lg transition-opacity">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-32 h-20 bg-gradient-to-br from-red-100 to-red-200 rounded-lg flex items-center justify-center border border-red-200">
                                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <x-atoms.title 
                                            text="{{ $video->title }}" 
                                            size="sm" 
                                            class="text-gray-900 line-clamp-2" 
                                        />
                                        @if($video->description)
                                            <x-atoms.description size="xs" class="text-gray-500 mt-1 line-clamp-2">
                                                {{ $video->description }}
                                            </x-atoms.description>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <a 
                                            href="{{ $video->watch_url }}" 
                                            target="_blank" 
                                            rel="noopener noreferrer"
                                            class="text-blue-600 hover:text-blue-800 hover:underline text-sm break-all flex items-center gap-1"
                                        >
                                            <x-heroicon-o-link class="w-4 h-4 flex-shrink-0" />
                                            <span class="line-clamp-2">{{ $video->url }}</span>
                                        </a>
                                        @if($video->video_id)
                                            <x-atoms.description size="xs" class="text-gray-500 mt-1 font-mono">
                                                ID: {{ $video->video_id }}
                                            </x-atoms.description>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <x-atoms.badge 
                                        :text="$video->order" 
                                        variant="light"
                                        size="sm"
                                    />
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button 
                                        wire:click="toggleStatus({{ $video->id }})"
                                        class="inline-flex items-center gap-2"
                                    >
                                        @if($video->is_active)
                                            <x-atoms.badge 
                                                text="Aktif" 
                                                variant="emerald"
                                                size="sm"
                                            />
                                        @else
                                            <x-atoms.badge 
                                                text="Nonaktif" 
                                                variant="black"
                                                size="sm"
                                            />
                                        @endif
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $video->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $video->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button 
                                            wire:click="edit({{ $video->id }})" 
                                            variant="outline"
                                            theme="dark" 
                                            size="sm" 
                                            heroicon="pencil"
                                            class="text-lime-600 border-lime-600 hover:bg-lime-600 hover:text-white"
                                        >
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button 
                                            wire:click="delete({{ $video->id }})"
                                            onclick="return confirm('Yakin ingin menghapus video youtube ini?')"
                                            variant="outline" 
                                            theme="dark" 
                                            size="sm" 
                                            heroicon="trash"
                                            class="text-red-600 border-red-600 hover:bg-red-600 hover:text-white"
                                        >
                                            Hapus
                                        </x-atoms.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-8 text-gray-500" colspan="7">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                    <x-atoms.title 
                                        size="md" 
                                        class="text-gray-700 mb-2" 
                                        :text="$search ? 'Tidak ditemukan video youtube sesuai pencarian' : 'Belum ada data video youtube'" 
                                    />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search)
                                            Coba ubah kata kunci pencarian
                                        @else
                                            Mulai dengan menambahkan video youtube baru
                                        @endif
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($youtubeVideos->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $youtubeVideos->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal --}}
    <x-atoms.modal name="youtube-video-modal" maxWidth="2xl" :closeable="true">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title 
                :text="$editMode ? 'Edit Video Youtube' : 'Tambah Video Youtube'" 
                size="lg" 
                class="text-gray-900" 
            />
        </div>

        {{-- Modal Content --}}
        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- URL Field --}}
                <div>
                    <x-molecules.input-field 
                        label="URL YouTube" 
                        inputType="url"
                        name="url" 
                        placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..."
                        wire:model="url" 
                        :error="$errors->first('url')" 
                        required 
                    />
                    <x-atoms.description size="xs" class="text-gray-500 mt-1">
                        Format yang didukung: youtube.com/watch?v=..., youtu.be/..., youtube.com/embed/...
                    </x-atoms.description>
                </div>

                {{-- Preview URL --}}
                @if($url && !$errors->has('url'))
                    @php
                        $tempVideo = new \App\Models\YoutubeVideo(['url' => $url]);
                    @endphp
                    @if($tempVideo->video_id)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <x-atoms.description size="sm" class="text-gray-700 mb-2 font-medium">
                                Preview Video:
                            </x-atoms.description>
                            <div class="aspect-video rounded-lg overflow-hidden">
                                <img 
                                    src="{{ $tempVideo->thumbnail }}" 
                                    alt="Video Preview"
                                    class="w-full h-full object-cover"
                                    onerror="this.src='https://via.placeholder.com/640x360/ef4444/ffffff?text=Video+Not+Found'"
                                >
                            </div>
                            <x-atoms.description size="xs" class="text-gray-500 mt-2">
                                Video ID: {{ $tempVideo->video_id }}
                            </x-atoms.description>
                        </div>
                    @endif
                @endif

                {{-- Title Field --}}
                <x-molecules.input-field 
                    label="Judul" 
                    name="title" 
                    placeholder="Masukan judul video"
                    wire:model="title" 
                    :error="$errors->first('title')" 
                    required 
                />

                {{-- Description Field --}}
                <x-molecules.textarea-field 
                    label="Deskripsi" 
                    name="description" 
                    placeholder="Masukan deskripsi video (opsional)"
                    rows="3"
                    wire:model="description" 
                    :error="$errors->first('description')" 
                />

                {{-- Order Field --}}
                <x-molecules.input-field 
                    label="Urutan Tampil" 
                    inputType="number"
                    name="order" 
                    placeholder="0"
                    wire:model="order" 
                    :error="$errors->first('order')" 
                    required 
                />

                {{-- Status Field --}}
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model="is_active" 
                            class="sr-only peer"
                        >
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-lime-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-lime-600"></div>
                    </label>
                    <div>
                        <x-atoms.label>Status Aktif</x-atoms.label>
                        <x-atoms.description size="xs" class="text-gray-500">
                            Video akan ditampilkan di halaman landing jika aktif
                        </x-atoms.description>
                    </div>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button 
                wire:click="save" 
                variant="primary" 
                theme="dark" 
                heroicon="check" 
                isFullWidth
                class="bg-lime-600 hover:bg-lime-700"
            >
                {{ $editMode ? 'Update' : 'Simpan' }}
            </x-atoms.button>
            <x-atoms.button 
                wire:click="cancel" 
                variant="secondary" 
                theme="dark" 
                heroicon="x-mark" 
                isFullWidth
                class="bg-gray-500 hover:bg-gray-600"
            >
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>