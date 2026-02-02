<div>
    <x-atoms.breadcrumb currentPath="Data Admin" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Data Admin" size="xl" />
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari admin..."
                    className="md:w-64"
                />

                @if(auth()->user()->is_super_admin)
                <x-atoms.button
                    wire:click="openCreateModal"
                    variant="success"
                    heroicon="plus"
                    className="whitespace-nowrap"
                >
                    Tambah Admin
                </x-atoms.button>
                @endif
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">No Telepon</th>
                        <th scope="col" class="px-6 py-3">Bergabung</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($admins->count() > 0)
                        @foreach ($admins as $index => $admin)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ ($admins->currentPage() - 1) * $admins->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-lime-100 rounded-full flex items-center justify-center">
                                            <span class="text-lime-600 font-semibold text-sm">
                                                {{ strtoupper(substr($admin->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="font-medium text-gray-900">{{ $admin->name }}</p>
                                                @if($admin->is_super_admin)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-lime-100 text-lime-800">
                                                        Super Admin
                                                    </span>
                                                @endif
                                            </div>
                                            @if ($admin->id === auth()->id())
                                                <x-atoms.badge text="Anda" variant="emerald" size="sm" />
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <x-heroicon-o-envelope class="w-4 h-4 text-gray-400 mr-2" />
                                        {{ $admin->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($admin->telp)
                                        <div class="flex items-center">
                                            <x-heroicon-o-phone class="w-4 h-4 text-gray-400 mr-2" />
                                            {{ $admin->telp }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <x-heroicon-o-calendar-days class="w-4 h-4 text-gray-400 mr-2" />
                                        {{ $admin->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        @if(auth()->user()->is_super_admin)
                                        <x-atoms.button
                                        wire:click='detail({{ $admin->id }})'
                                            variant="ghost"
                                            theme="dark"
                                            size="sm"
                                            heroicon="eye"
                                            className="text-blue-600 hover:text-blue-800"
                                            title="Detail"
                                        >
                                           <!-- Detail -->
                                        </x-atoms.button>

                                        @if ($admin->id !== auth()->id())
                                            <button
                                                type="button"
                                                wire:click="toggleSuperAdmin({{ $admin->id }})"
                                                wire:confirm="Ubah status Super Admin untuk {{ $admin->name }}?"
                                                class="p-1 rounded-md transition-colors {{ $admin->is_super_admin ? 'text-lime-600 hover:text-lime-800 hover:bg-lime-50' : 'text-gray-400 hover:text-lime-600 hover:bg-gray-50' }} border {{ $admin->is_super_admin ? 'border-lime-200' : 'border-transparent hover:border-lime-200' }}"
                                                title="{{ $admin->is_super_admin ? 'Cabut Super Admin' : 'Jadikan Super Admin' }}"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                                </svg>
                                            </button>

                                            <x-atoms.button
                                                wire:click="deleteAdmin({{ $admin->id }})"
                                                wire:confirm="Yakin ingin menghapus admin ini?"
                                                variant="ghost"
                                                theme="dark"
                                                size="sm"
                                                heroicon="trash"
                                                className="text-red-600 hover:text-red-800"
                                                title="Hapus"
                                            >
                                                <!-- Hapus -->
                                            </x-atoms.button>
                                        @endif
                                        @else
                                        <span class="text-xs text-gray-400 italic">Restricted</span>
                                        @endif
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
                                        <x-atoms.title text="Tidak ada data admin" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400">
                                            @if ($search)
                                                Tidak ditemukan admin sesuai pencarian "{{ $search }}"
                                            @else
                                                Belum ada data admin yang terdaftar
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

        @if ($admins->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $admins->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    <x-atoms.modal name="create-admin" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-user-plus class="w-6 h-6 text-lime-600" />
                </div>
                <div>
                    <x-atoms.title text="Tambah Admin Baru" size="lg" />
                    <x-atoms.description size="sm" color="gray-500">
                        Lengkapi form dibawah untuk menambahkan admin baru
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="createAdmin" class="space-y-5">
                <x-molecules.input-field
                    label="Nama Lengkap"
                    name="name"
                    wire:model="name"
                    placeholder="Masukkan nama lengkap admin"
                    :required="true"
                    :error="$errors->first('name')"
                />

                <x-molecules.input-field
                    label="Email"
                    inputType="email"
                    name="email"
                    wire:model="email"
                    placeholder="admin@example.com"
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
                            wire:target="createAdmin"
                        >
                            <span wire:loading.remove wire:target="createAdmin">Simpan Admin</span>
                            <span wire:loading wire:target="createAdmin">Menyimpan...</span>
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

    <div wire:loading.flex wire:target="createAdmin" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">Menyimpan data admin...</span>
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