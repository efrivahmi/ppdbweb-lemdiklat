<div>
    <x-atoms.breadcrumb currentPath="Data Guru" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Data Guru" size="xl" />
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari guru..."
                    className="md:w-64"
                />

                <x-atoms.button
                    wire:click="openCreateModal"
                    variant="success"
                    heroicon="plus"
                    className="whitespace-nowrap"
                >
                    Tambah Guru
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($gurus->count() > 0)
                        @foreach ($gurus as $index => $guru)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ ($gurus->currentPage() - 1) * $gurus->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                            <span class="text-emerald-600 font-semibold text-sm">
                                                {{ strtoupper(substr($guru->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $guru->name }}</p>
                                            <x-atoms.badge text="Guru" variant="emerald" size="sm" />
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <x-heroicon-o-envelope class="w-4 h-4 text-gray-400 mr-2" />
                                        {{ $guru->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($guru->mapel?->mapel_name)
                                        <div class="flex items-center">
                                            {{ $guru->mapel->mapel_name }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button
                                        wire:click='detail({{ $guru->id }})'
                                            variant="ghost"
                                            theme="dark"
                                            size="sm"
                                            heroicon="eye"
                                            className="text-blue-600 hover:text-blue-800"
                                        >
                                            Detail
                                        </x-atoms.button>
                                        
                                        <x-atoms.button
                                            wire:click="deleteGuru({{ $guru->id }})"
                                            wire:confirm="Yakin ingin menghapus guru ini?"
                                            variant="ghost"
                                            theme="dark"
                                            size="sm"
                                            heroicon="trash"
                                            className="text-red-600 hover:text-red-800"
                                        >
                                            Hapus
                                        </x-atoms.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b border-gray-200">
                            <td class="text-center px-6 py-12 text-gray-500" colspan="6">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                                    </div>
                                    <div class="text-center">
                                        <x-atoms.title text="Tidak ada data guru" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400">
                                            @if ($search)
                                                Tidak ditemukan guru sesuai pencarian "{{ $search }}"
                                            @else
                                                Belum ada data guru yang terdaftar
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

        @if ($gurus->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $gurus->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="create-guru" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-user-plus class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <x-atoms.title text="Tambah Guru Baru" size="lg" />
                    <x-atoms.description size="sm" color="gray-500">
                        Lengkapi form dibawah untuk menambahkan guru baru
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="createGuru" class="space-y-5">
                <x-molecules.input-field
                    label="Nama Lengkap"
                    name="name"
                    wire:model="name"
                    placeholder="Masukkan nama lengkap guru"
                    :required="true"
                    :error="$errors->first('name')"
                />

                <x-molecules.input-field
                    label="Email"
                    inputType="email"
                    name="email"
                    wire:model="email"
                    placeholder="guru@example.com"
                    :required="true"
                    :error="$errors->first('email')"
                />

                <x-molecules.input-field
                    label="No. Telepon"
                    inputType="tel"
                    name="telp"
                    wire:model="telp"
                    placeholder="08xxxxxxxxxx"
                    :error="$errors->first('telp')"
                />

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <select wire:model="mapel_id" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-lime-500 focus:border-lime-500
                                   @error('mapel_id') border-red-500 @enderror">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->mapel_name }}</option>
                        @endforeach
                    </select>
                    @error('mapel_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <x-molecules.input-field
                        label="Password"
                        inputType="password"
                        name="password"
                        wire:model="password"
                        placeholder="Minimal 8 karakter"
                        :required="true"
                        :error="$errors->first('password')"
                    />

                    <x-molecules.input-field
                        label="Konfirmasi Password"
                        inputType="password"
                        name="password_confirmation"
                        wire:model="password_confirmation"
                        placeholder="Ulangi password"
                        :required="true"
                        :error="$errors->first('password_confirmation')"
                    />
                </div>

                <div class="border-t pt-6 mt-6">
                    <div class="flex gap-3">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="createGuru"
                        >
                            <span wire:loading.remove wire:target="createGuru">Simpan Guru</span>
                            <span wire:loading wire:target="createGuru">Menyimpan...</span>
                        </x-atoms.button>
                        
                        <x-atoms.button
                            type="button"
                            wire:click="closeCreateModal"
                            variant="ghost"
                            theme="dark"
                            heroicon="x-mark"
                            className="flex-1"
                        >
                            Batal
                        </x-atoms.button>
                    </div>
                </div>
            </form>
        </div>
    </x-atoms.modal>

    <div wire:loading.flex wire:target="createGuru" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">Menyimpan data guru...</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('success', event => {
        console.log('Success:', event.detail.message);
    });
    
    window.addEventListener('error', event => {
        console.log('Error:', event.detail.message);
    });
</script>
@endpush