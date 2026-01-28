<div>
    <x-atoms.breadcrumb currentPath="Persyaratan" />
    
    <!-- Search Bar -->
    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <x-atoms.title 
                text="Kelola Persyaratan" 
                size="xl" 
                class="text-gray-900"
            />
            
            <x-atoms.input
                type="search"
                wire:model.live="search"
                placeholder="Cari persyaratan..."
                className="md:w-64"
            />
        </div>
    </x-atoms.card>

    <!-- Tab Navigation -->
    <div class="mt-6 flex space-x-1 bg-gray-100 p-1 rounded-lg">
        <button 
            wire:click="setActiveTab('physical')"
            class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors {{ $activeTab === 'physical' ? 'bg-white text-blue-600 shadow' : 'text-gray-600 hover:text-blue-600' }}"
        >
            Persyaratan Fisik
        </button>
        <button 
            wire:click="setActiveTab('document')"
            class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors {{ $activeTab === 'document' ? 'bg-white text-emerald-600 shadow' : 'text-gray-600 hover:text-emerald-600' }}"
        >
            Persyaratan Dokumen
        </button>
    </div>

    <!-- Physical Requirements Table -->
    @if($activeTab === 'physical')
        <x-atoms.card className="mt-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-user class="w-5 h-5 text-blue-600" />
                    <x-atoms.title text="Persyaratan Fisik" size="lg" class="text-gray-900" />
                </div>
                <x-atoms.button
                    wire:click="createPhysical"
                    variant="primary"
                    theme="light"
                    heroicon="plus"
                >
                    Tambah Persyaratan Fisik
                </x-atoms.button>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-white uppercase bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Judul</th>
                            <th scope="col" class="px-6 py-3">Nilai</th>
                            <th scope="col" class="px-6 py-3">Gender</th>
                            <th scope="col" class="px-6 py-3">Urutan</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($physicalRequirements->count() > 0)
                            @foreach ($physicalRequirements as $index => $persyaratan)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <x-atoms.badge
                                            text="{{ ($physicalRequirements->currentPage() - 1) * $physicalRequirements->perPage() + $loop->iteration }}"
                                            variant="light"
                                            size="sm"
                                        />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <x-atoms.title 
                                                text="{{ $persyaratan->title }}" 
                                                size="sm" 
                                                class="text-gray-900 mb-1"
                                            />
                                            @if($persyaratan->description)
                                                <x-atoms.description 
                                                    size="sm" 
                                                    class="text-gray-500"
                                                >
                                                    {{ Str::limit($persyaratan->description, 60) }}
                                                </x-atoms.description>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $persyaratan->formatted_value }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($persyaratan->gender)
                                            <x-atoms.badge
                                                text="{{ $persyaratan->gender_display }}"
                                                variant="{{ $persyaratan->gender === 'male' ? 'sky' : 'danger' }}"
                                                size="sm"
                                            />
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-atoms.badge
                                            text="{{ $persyaratan->order }}"
                                            variant="light"
                                            size="sm"
                                        />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2 justify-center">
                                            <x-atoms.button
                                                wire:click="edit({{ $persyaratan->id }})"
                                                variant="primary"
                                                theme="dark"
                                                size="sm"
                                                heroicon="pencil"
                                            >
                                                Edit
                                            </x-atoms.button>
                                            <x-atoms.button
                                                wire:click="delete({{ $persyaratan->id }})"
                                                onclick="return confirm('Yakin ingin menghapus persyaratan ini?')"
                                                variant="danger"
                                                theme="dark"
                                                size="sm"
                                                heroicon="trash"
                                            >
                                                Hapus
                                            </x-atoms.button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b border-gray-200">
                                <td class="text-center px-6 py-8 text-gray-500" colspan="6">
                                    <div class="flex flex-col items-center">
                                        <x-heroicon-o-user class="w-16 h-16 text-gray-300 mb-4" />
                                        <x-atoms.title 
                                            size="md" 
                                            class="text-gray-700 mb-2"
                                            :text="$search ? 'Tidak ditemukan persyaratan fisik' : 'Belum ada persyaratan fisik'"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($physicalRequirements->hasPages())
                <div class="mt-4">
                    {{ $physicalRequirements->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </x-atoms.card>
    @endif

    <!-- Document Requirements Table -->
    @if($activeTab === 'document')
        <x-atoms.card className="mt-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-document-text class="w-5 h-5 text-emerald-600" />
                    <x-atoms.title text="Persyaratan Dokumen" size="lg" class="text-gray-900" />
                </div>
                <x-atoms.button
                    wire:click="createDocument"
                    variant="success"
                    theme="light"
                    heroicon="plus"
                >
                    Tambah Persyaratan Dokumen
                </x-atoms.button>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-white uppercase bg-emerald-600">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Judul Dokumen</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Urutan</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($documentRequirements->count() > 0)
                            @foreach ($documentRequirements as $index => $persyaratan)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <x-atoms.badge
                                            text="{{ ($documentRequirements->currentPage() - 1) * $documentRequirements->perPage() + $loop->iteration }}"
                                            variant="light"
                                            size="sm"
                                        />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <x-atoms.title 
                                                text="{{ $persyaratan->title }}" 
                                                size="sm" 
                                                class="text-gray-900 mb-1"
                                            />
                                            @if($persyaratan->description)
                                                <x-atoms.description 
                                                    size="sm" 
                                                    class="text-gray-500"
                                                >
                                                    {{ Str::limit($persyaratan->description, 80) }}
                                                </x-atoms.description>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $persyaratan->formatted_value }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-atoms.badge
                                            text="{{ $persyaratan->order }}"
                                            variant="light"
                                            size="sm"
                                        />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2 justify-center">
                                            <x-atoms.button
                                                wire:click="edit({{ $persyaratan->id }})"
                                                variant="primary"
                                                theme="dark"
                                                size="sm"
                                                heroicon="pencil"
                                            >
                                                Edit
                                            </x-atoms.button>
                                            <x-atoms.button
                                                wire:click="delete({{ $persyaratan->id }})"
                                                onclick="return confirm('Yakin ingin menghapus persyaratan ini?')"
                                                variant="danger"
                                                theme="dark"
                                                size="sm"
                                                heroicon="trash"
                                            >
                                                Hapus
                                            </x-atoms.button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b border-gray-200">
                                <td class="text-center px-6 py-8 text-gray-500" colspan="5">
                                    <div class="flex flex-col items-center">
                                        <x-heroicon-o-document-text class="w-16 h-16 text-gray-300 mb-4" />
                                        <x-atoms.title 
                                            size="md" 
                                            class="text-gray-700 mb-2"
                                            :text="$search ? 'Tidak ditemukan persyaratan dokumen' : 'Belum ada persyaratan dokumen'"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($documentRequirements->hasPages())
                <div class="mt-4">
                    {{ $documentRequirements->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </x-atoms.card>
    @endif

    <!-- Modal Form -->
    <x-atoms.modal 
        name="persyaratan-modal" 
        maxWidth="2xl"
        :closeable="true"
    >
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title 
                :text="$editMode ? 'Edit Persyaratan' : 'Tambah Persyaratan ' . ($type === 'physical' ? 'Fisik' : 'Dokumen')"
                size="lg" 
                class="text-gray-900"
            />
        </div>

        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Judul -->
                <x-molecules.input-field
                    label="Judul"
                    name="title"
                    placeholder="Masukan judul persyaratan"
                    wire:model="title"
                    :error="$errors->first('title')"
                    required
                />

                <!-- Deskripsi -->
                <x-molecules.textarea-field
                    label="Deskripsi"
                    name="description"
                    placeholder="Masukan deskripsi persyaratan (opsional)"
                    :rows="3"
                    wire:model="description"
                    :error="$errors->first('description')"
                />

                <!-- Nilai dan Satuan -->
                <div class="grid grid-cols-2 gap-4">
                    <x-molecules.input-field
                        label="Nilai"
                        name="value"
                        placeholder="Contoh: 155, 15, 3"
                        wire:model="value"
                        :error="$errors->first('value')"
                        required
                    />

                    <x-molecules.input-field
                        label="Satuan"
                        name="unit"
                        placeholder="Contoh: cm, kg, lembar"
                        wire:model="unit"
                        :error="$errors->first('unit')"
                    />
                </div>

                <!-- Fields khusus untuk Physical -->
                @if($type === 'physical')
                    <div class="grid grid-cols-2 gap-4">
                        <x-molecules.select-field
                            label="Jenis Kelamin"
                            name="gender"
                            wire:model="gender"
                            :options="$this->genderOptions"
                            :error="$errors->first('gender')"
                            placeholder="Pilih jenis kelamin"
                        />

                        <x-molecules.select-field
                            label="Warna"
                            name="color"
                            wire:model="color"
                            :options="$this->colorOptions"
                            :error="$errors->first('color')"
                            placeholder="Pilih warna"
                        />
                    </div>
                @endif

                <!-- Urutan -->
                <x-molecules.input-field
                    label="Urutan"
                    inputType="number"
                    name="order"
                    placeholder="0"
                    wire:model="order"
                    :error="$errors->first('order')"
                />
            </form>
        </div>

        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button
                wire:click="save"
                variant="primary"
                theme="dark"
                heroicon="check"
                isFullWidth
            >
                {{ $editMode ? 'Update' : 'Simpan' }}
            </x-atoms.button>
            <x-atoms.button
                wire:click="cancel"
                variant="secondary"
                theme="dark"
                heroicon="x-mark"
                isFullWidth
            >
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>