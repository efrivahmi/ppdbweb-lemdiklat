<div>
    <x-atoms.breadcrumb currentPath="Alumni Section" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Alumni" size="xl" />

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto lg:items-center">
                <x-atoms.input type="search" wire:model.live="search" placeholder="Cari alumni..." className="md:w-48" />

                <div class="relative">
                    <select wire:model.live="jurusanFilter"
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>

                <div class="relative">
                    <select wire:model.live="selectedFilter"
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none bg-white">
                        <option value="">Semua Status</option>
                        <option value="1">Alumni Terpilih</option>
                        <option value="0">Alumni Biasa</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400" />
                    </div>
                </div>

                <x-atoms.button wire:click="create" variant="success" heroicon="plus" className="whitespace-nowrap">
                    Tambah Alumni
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Foto</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Jurusan</th>
                        <th scope="col" class="px-6 py-3">Tahun Lulus</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($alumnis->count() > 0)
                        @foreach ($alumnis as $alumni)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if ($alumni->image)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $alumni->image) }}" alt="Foto Alumni"
                                                class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-lg transition-opacity">
                                                <x-atoms.button wire:click="deleteImage({{ $alumni->id }})"
                                                    onclick="return confirm('Yakin ingin menghapus foto?')"
                                                    variant="ghost" size="sm" heroicon="trash"
                                                    class="text-white hover:text-red-300" />
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <x-heroicon-o-user class="w-6 h-6 text-gray-400" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <x-atoms.title text="{{ $alumni->name }}" size="sm"
                                            class="text-gray-900 mb-1" />
                                        <x-atoms.description size="sm" class="text-gray-600">
                                            {{ Str::limit($alumni->desc, 80) }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-atoms.badge text="{{ $alumni->jurusan->nama }}" variant="light" size="sm"
                                        class="inline-flex items-center">
                                        <x-heroicon-o-academic-cap class="w-3 h-3 mr-1" />
                                        {{ $alumni->jurusan->nama }}
                                    </x-atoms.badge>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-heroicon-o-calendar class="w-4 h-4 text-gray-400" />
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $alumni->tahun_lulus }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleSelected({{ $alumni->id }})"
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold transition cursor-pointer
                                            {{ $alumni->is_selected
                                                ? 'bg-amber-100 text-amber-800 hover:bg-amber-200'
                                                : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                        @if ($alumni->is_selected)
                                            <x-heroicon-o-star class="w-3 h-3 mr-1" />
                                        @else
                                            <x-heroicon-o-user class="w-3 h-3 mr-1" />
                                        @endif
                                        {{ $alumni->is_selected ? 'Terpilih' : 'Biasa' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <x-atoms.description size="sm" class="text-gray-900 font-medium">
                                            {{ $alumni->created_at->format('d M Y') }}
                                        </x-atoms.description>
                                        <x-atoms.description size="xs" class="text-gray-500">
                                            {{ $alumni->created_at->format('H:i') }}
                                        </x-atoms.description>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button wire:click="edit({{ $alumni->id }})" variant="outline"
                                            theme="primary" size="sm" heroicon="pencil">
                                            Edit
                                        </x-atoms.button>
                                        <x-atoms.button wire:click="delete({{ $alumni->id }})"
                                            onclick="return confirm('Yakin ingin menghapus alumni ini?')"
                                            variant="danger" theme="dark" size="sm" heroicon="trash">
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
                                    <x-heroicon-o-academic-cap class="w-16 h-16 text-gray-300 mb-4" />
                                    <x-atoms.title size="md" class="text-gray-700 mb-2" :text="($search || $jurusanFilter || $selectedFilter !== '') ? 'Tidak ditemukan alumni sesuai filter' : 'Belum ada alumni'" />
                                    <x-atoms.description class="text-gray-500">
                                        @if ($search || $jurusanFilter || $selectedFilter !== '')
                                            Coba ubah kata kunci atau filter yang digunakan
                                        @else
                                            Mulai dengan menambahkan alumni pertama
                                        @endif
                                    </x-atoms.description>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($alumnis->hasPages())
            <div class="mt-4 w-full flex justify-center items-center">
                {{ $alumnis->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal Form - Fixed version --}}
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        {{-- Backdrop --}}
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="$wire.closeModal()">
        </div>

        {{-- Modal Content --}}
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                
                {{-- Modal Header --}}
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <x-atoms.title :text="$editMode ? 'Edit Alumni' : 'Tambah Alumni'" size="lg" class="text-gray-900" />
                    <button @click="$wire.closeModal()" 
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 max-h-[70vh] overflow-y-auto">
                    <form wire:submit.prevent="save" class="space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <x-molecules.input-field label="Nama Alumni" name="name" placeholder="Masukan nama alumni"
                                wire:model="name" :error="$errors->first('name')" required />

                            <x-molecules.input-field label="Tahun Lulus" name="tahun_lulus" type="number" min="1970" max="2030"
                                placeholder="Contoh: {{ date('Y') }}" wire:model="tahun_lulus" :error="$errors->first('tahun_lulus')" required />
                        </div>

                        <x-molecules.select-field label="Jurusan" name="jurusan_id" wire:model="jurusan_id"
                            :options="collect([['value' => '', 'label' => '-- Pilih Jurusan --']])
                                ->concat($allJurusans->map(fn($j) => ['value' => $j->id, 'label' => $j->nama]))
                                ->toArray()" :error="$errors->first('jurusan_id')" required />

                        <x-molecules.textarea-field label="Deskripsi Alumni" name="desc"
                            placeholder="Masukan deskripsi prestasi, pengalaman kerja, atau pencapaian alumni..." :rows="6" wire:model="desc" :error="$errors->first('desc')"
                            required />

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <x-atoms.label for="new_image">
                                    Foto Alumni
                                </x-atoms.label>

                                @if ($editMode && $image)
                                    <div class="mb-3">
                                        <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                            Foto saat ini:
                                        </x-atoms.description>
                                        <img src="{{ asset('storage/' . $image) }}" alt="Current Image"
                                            class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                    </div>
                                @endif

                                <x-molecules.file-field name="new_image" accept="image/*" maxSize="2MB"
                                    wire:model="new_image" :error="$errors->first('new_image')" className="mb-0" />

                                @if ($new_image)
                                    <div class="mt-2">
                                        <x-atoms.description size="sm" class="text-gray-600 mb-2">
                                            Preview foto baru:
                                        </x-atoms.description>
                                        <img src="{{ $new_image->temporaryUrl() }}" alt="Preview"
                                            class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                    </div>
                                @endif

                                <x-atoms.description size="xs" class="text-gray-500">
                                    Format: JPG, PNG. Maksimal 2MB. Disarankan ukuran persegi (1:1).
                                </x-atoms.description>
                            </div>

                            <div class="space-y-3">
                                <x-atoms.label>
                                    Status Alumni
                                </x-atoms.label>
                                <div class="space-y-3 mt-4">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="radio" wire:model="is_selected" value="0"
                                            class="text-lime-600 focus:ring-lime-500 border-gray-300 mt-1">
                                        <div class="ml-3">
                                            <div class="flex items-center text-sm text-gray-700">
                                                <x-heroicon-o-user class="w-4 h-4 text-gray-600 mr-1" />
                                                Alumni Biasa
                                            </div>
                                            <x-atoms.description size="xs" class="text-gray-500 mt-1">
                                                Alumni akan ditampilkan di bagian "Alumni Lainnya"
                                            </x-atoms.description>
                                        </div>
                                    </label>
                                    <label class="flex items-start cursor-pointer">
                                        <input type="radio" wire:model="is_selected" value="1"
                                            class="text-lime-600 focus:ring-lime-500 border-gray-300 mt-1">
                                        <div class="ml-3">
                                            <div class="flex items-center text-sm text-gray-700">
                                                <x-heroicon-o-star class="w-4 h-4 text-amber-500 mr-1" />
                                                Alumni Terpilih
                                            </div>
                                            <x-atoms.description size="xs" class="text-gray-500 mt-1">
                                                Alumni akan ditampilkan di bagian khusus "Alumni Terpilih"
                                            </x-atoms.description>
                                        </div>
                                    </label>
                                </div>
                                @error('is_selected')
                                    <x-atoms.description size="xs" class="text-red-500">
                                        {{ $message }}
                                    </x-atoms.description>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Modal Footer --}}
                <div class="flex gap-3 p-6 border-t border-gray-200">
                    <x-atoms.button wire:click="save" variant="primary" theme="dark" heroicon="check" isFullWidth
                        class="bg-lime-600 hover:bg-lime-700">
                        {{ $editMode ? 'Update' : 'Simpan' }}
                    </x-atoms.button>
                    <x-atoms.button wire:click="cancel" variant="secondary" theme="dark" heroicon="x-mark" isFullWidth
                        class="bg-gray-500 hover:bg-gray-600">
                        Batal
                    </x-atoms.button>
                </div>
            </div>
        </div>
    </div>

   

</div>