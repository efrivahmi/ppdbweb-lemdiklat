<div>
    <x-atoms.breadcrumb currentPath="Visi & Misi" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col lg:flex-row lg:justify-between w-full items-center gap-3 mb-6">
            <x-atoms.title text="Manajemen Visi & Misi" size="xl" class="text-gray-900" />
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <x-atoms.card className="bg-lime-50 border-lime-200" padding="p-4">
                <div class="flex items-center">
                    <x-heroicon-o-eye class="w-8 h-8 text-lime-600 mr-3" />
                    <div>
                        <x-atoms.description size="sm" class="text-lime-600 font-medium mb-1">
                            VISI UTAMA
                        </x-atoms.description>
                        <x-atoms.title text="{{ $visiMainCount }} Item" size="lg" class="text-lime-800" />
                    </div>
                </div>
            </x-atoms.card>

            <x-atoms.card className="bg-blue-50 border-blue-200" padding="p-4">
                <div class="flex items-center">
                    <x-heroicon-o-list-bullet class="w-8 h-8 text-blue-600 mr-3" />
                    <div>
                        <x-atoms.description size="sm" class="text-blue-600 font-medium mb-1">
                            ITEM VISI
                        </x-atoms.description>
                        <x-atoms.title text="{{ $visiItemCount }} Item" size="lg" class="text-blue-800" />
                    </div>
                </div>
            </x-atoms.card>

            <x-atoms.card className="bg-purple-50 border-purple-200" padding="p-4">
                <div class="flex items-center">
                    <x-heroicon-o-flag class="w-8 h-8 text-purple-600 mr-3" />
                    <div>
                        <x-atoms.description size="sm" class="text-purple-600 font-medium mb-1">
                            MISI UTAMA
                        </x-atoms.description>
                        <x-atoms.title text="{{ $misiMainCount }} Item" size="lg" class="text-purple-800" />
                    </div>
                </div>
            </x-atoms.card>

            <x-atoms.card className="bg-orange-50 border-orange-200" padding="p-4">
                <div class="flex items-center">
                    <x-heroicon-o-check-badge class="w-8 h-8 text-orange-600 mr-3" />
                    <div>
                        <x-atoms.description size="sm" class="text-orange-600 font-medium mb-1">
                            ITEM MISI
                        </x-atoms.description>
                        <x-atoms.title text="{{ $misiItemCount }} Item" size="lg" class="text-orange-800" />
                    </div>
                </div>
            </x-atoms.card>
        </div>

        <!-- Search and Filter -->
        <x-atoms.card className="bg-gray-50" padding="p-4 mb-6">
            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input 
                    type="search" 
                    wire:model.live="search" 
                    placeholder="Cari berdasarkan judul atau konten..."
                    className="md:w-64"
                />

                <div class="relative">
                    <select wire:model.live="filterType" 
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Tipe</option>
                        <option value="visi">Visi</option>
                        <option value="misi">Misi</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>

                <div class="relative">
                    <select wire:model.live="filterContentType" 
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Jenis</option>
                        <option value="main">Konten Utama</option>
                        <option value="item">Item/Poin</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>

                <x-atoms.button wire:click="create" variant="success" heroicon="plus" className="whitespace-nowrap">
                    Tambah Konten
                </x-atoms.button>
            </div>
        </x-atoms.card>

        <!-- Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Tipe</th>
                        <th scope="col" class="px-6 py-3">Jenis</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Konten</th>
                        <th scope="col" class="px-6 py-3">Urutan</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($visimisis->count() > 0)
                        @foreach ($visimisis as $visimisi)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <x-atoms.badge 
                                        :text="strtoupper($visimisi->type)" 
                                        :variant="$visimisi->type === 'visi' ? 'emerald' : 'sky'" 
                                        size="sm"
                                        class="inline-flex items-center"
                                    >
                                        @if ($visimisi->type === 'visi')
                                            <x-heroicon-o-eye class="w-3 h-3 mr-1" />
                                        @else
                                            <x-heroicon-o-flag class="w-3 h-3 mr-1" />
                                        @endif
                                        {{ strtoupper($visimisi->type) }}
                                    </x-atoms.badge>
                                </td>
                                <td class="px-6 py-4">
                                    @if($visimisi->isMainContent())
                                        <x-atoms.badge text="UTAMA" variant="gold" size="sm">
                                            <x-heroicon-o-star class="w-3 h-3 mr-1" />
                                            UTAMA
                                        </x-atoms.badge>
                                    @else
                                        <x-atoms.badge text="ITEM" variant="light" size="sm">
                                            <x-heroicon-o-list-bullet class="w-3 h-3 mr-1" />
                                            ITEM
                                        </x-atoms.badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <x-atoms.title size="sm" class="text-gray-900 font-medium mb-1">
                                            @if($visimisi->isMainContent())
                                                {{ $visimisi->title }}
                                            @else
                                                {{ $visimisi->item_title }}
                                            @endif
                                        </x-atoms.title>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-md">
                                        <x-atoms.description size="sm" class="text-gray-600 leading-relaxed">
                                            @if($visimisi->isMainContent())
                                                {{ Str::limit($visimisi->content, 100) }}
                                            @else
                                                {{ Str::limit($visimisi->item_description, 100) }}
                                            @endif
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($visimisi->isMainContent())
                                            <x-atoms.badge text="UTAMA" variant="gold" size="sm" />
                                        @else
                                            <input 
                                                type="number" 
                                                wire:blur="updateOrder({{ $visimisi->id }}, $event.target.value)"
                                                value="{{ $visimisi->order }}"
                                                min="0"
                                                class="w-16 px-2 py-1 text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-lime-500"
                                            />
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button 
                                        wire:click="toggleActive({{ $visimisi->id }})"
                                        class="inline-flex items-center"
                                    >
                                        @if($visimisi->is_active)
                                            <x-atoms.badge text="AKTIF" variant="emerald" size="sm">
                                                <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                                                AKTIF
                                            </x-atoms.badge>
                                        @else
                                            <x-atoms.badge text="NONAKTIF" variant="danger" size="sm">
                                                <x-heroicon-o-x-circle class="w-3 h-3 mr-1" />
                                                NONAKTIF
                                            </x-atoms.badge>
                                        @endif
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $visimisi->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $visimisi->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button 
                                            wire:click="edit({{ $visimisi->id }})" 
                                            variant="outline"
                                            theme="dark" 
                                            size="sm" 
                                            heroicon="pencil"
                                            class="text-lime-600 border-lime-600 hover:bg-lime-600 hover:text-white"
                                        >
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button 
                                            wire:click="delete({{ $visimisi->id }})"
                                            onclick="return confirm('Yakin ingin menghapus {{ $visimisi->type }} ini?')"
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
                            <td class="text-center px-6 py-8 text-gray-500" colspan="8">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-document-text class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2" text="Belum ada data visi misi" />
                                    <x-atoms.description class="text-gray-500">
                                        Mulai dengan menambahkan konten visi atau misi sekolah
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($visimisis->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $visimisis->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <!-- Modal Form -->
    <x-atoms.modal name="visi-misi-modal" maxWidth="3xl" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title 
                :text="$editMode ? 'Edit Visi/Misi' : 'Tambah Visi/Misi'" 
                size="lg" 
                class="text-gray-900" 
            />
            <button 
                wire:click="cancel" 
                class="text-gray-400 hover:text-gray-600 transition-colors"
                aria-label="Close modal"
            >
                <x-heroicon-o-x-mark class="w-6 h-6" />
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto">
            @if($editMode)
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500 mr-2" />
                        <span class="text-sm text-blue-700">
                            Mode Edit - ID: {{ $selectedId }} | Tipe: {{ $type }} | Jenis: {{ $content_type }}
                        </span>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-6">
                
                <!-- Type Selection -->
                <div class="space-y-3">
                    <x-atoms.label>Tipe <span class="text-red-500">*</span></x-atoms.label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model.live="type" 
                                value="visi"
                                class="text-lime-600 focus:ring-lime-500 border-gray-300"
                            >
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <x-heroicon-o-eye class="w-4 h-4 text-lime-600 mr-1" />
                                Visi
                            </span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model.live="type" 
                                value="misi"
                                class="text-lime-600 focus:ring-lime-500 border-gray-300"
                            >
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <x-heroicon-o-flag class="w-4 h-4 text-lime-600 mr-1" />
                                Misi
                            </span>
                        </label>
                    </div>
                    @error('type')
                        <x-atoms.description size="xs" class="text-red-500">{{ $message }}</x-atoms.description>
                    @enderror
                </div>

                <!-- Content Type Selection -->
                <div class="space-y-3">
                    <x-atoms.label>Jenis Konten <span class="text-red-500">*</span></x-atoms.label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model.live="content_type" 
                                value="main"
                                class="text-lime-600 focus:ring-lime-500 border-gray-300"
                            >
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <x-heroicon-o-star class="w-4 h-4 text-yellow-500 mr-1" />
                                Konten Utama
                            </span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model.live="content_type" 
                                value="item"
                                class="text-lime-600 focus:ring-lime-500 border-gray-300"
                            >
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <x-heroicon-o-list-bullet class="w-4 h-4 text-blue-500 mr-1" />
                                Item/Poin
                            </span>
                        </label>
                    </div>
                    @error('content_type')
                        <x-atoms.description size="xs" class="text-red-500">{{ $message }}</x-atoms.description>
                    @enderror
                </div>

                @if($content_type === 'main')
                    <!-- Main Content Fields -->
                    <x-molecules.input-field 
                        label="Judul {{ ucfirst($type) }}" 
                        name="title" 
                        :placeholder="'Masukan judul ' . strtolower($type) . '...'"
                        wire:model="title" 
                        :error="$errors->first('title')" 
                        required 
                    />

                    <x-molecules.textarea-field 
                        :label="'Deskripsi ' . ucfirst($type)" 
                        name="content" 
                        :placeholder="'Masukan deskripsi ' . strtolower($type) . '...'" 
                        :rows="6"
                        wire:model="content" 
                        :error="$errors->first('content')" 
                        required 
                    />
                @else
                    <!-- Item Content Fields -->
                    <x-molecules.input-field 
                        label="Judul Item" 
                        name="item_title" 
                        placeholder="Masukan judul item..."
                        wire:model="item_title" 
                        :error="$errors->first('item_title')" 
                        required 
                    />

                    <x-molecules.textarea-field 
                        label="Deskripsi Item" 
                        name="item_description" 
                        placeholder="Masukan deskripsi item..." 
                        :rows="4"
                        wire:model="item_description" 
                        :error="$errors->first('item_description')" 
                        required 
                    />

                    <x-molecules.input-field 
                        label="Urutan" 
                        inputType="number"
                        name="order" 
                        placeholder="0"
                        wire:model="order" 
                        :error="$errors->first('order')" 
                        required 
                    />
                @endif

                <!-- Status Active -->
                <div class="space-y-3">
                    <x-atoms.label>Status</x-atoms.label>
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model="is_active"
                            class="text-lime-600 focus:ring-lime-500 border-gray-300 rounded"
                        >
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                </div>

            </form>
        </div>

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