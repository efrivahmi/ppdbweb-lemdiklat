<div>
    <x-atoms.breadcrumb currentPath="Data Siswa" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Tabel Data Siswa" size="xl" />

            <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto items-end">
                <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto">
                    <x-atoms.input 
                        type="search" 
                        wire:model.live="search" 
                        placeholder="Cari Siswa..." 
                        className="lg:w-64"
                    />
                    
                    <div class="flex gap-3">
                        <x-molecules.select-field 
                            name="statusFilter" 
                            wire:model.live="statusFilter"
                            placeholder="Semua Status" 
                            :options="[
                                ['value' => '', 'label' => 'Semua Status'],
                                ['value' => 'data_lengkap', 'label' => 'Data Lengkap'],
                                ['value' => 'berkas_lengkap', 'label' => 'Berkas Lengkap'],
                                ['value' => 'pendaftaran_diterima', 'label' => 'Diterima'],
                            ]" 
                            className="md:w-48" 
                        />

                        <x-molecules.select-field 
                            name="transferFilter" 
                            wire:model.live="transferFilter"
                            placeholder="Semua Transfer" 
                            :options="[
                                ['value' => '', 'label' => 'Semua Transfer'],
                                ['value' => 'pending', 'label' => 'Transfer Pending'],
                                ['value' => 'success', 'label' => 'Transfer Diterima'],
                                ['value' => 'decline', 'label' => 'Transfer Ditolak'],
                                ['value' => 'no_transfer', 'label' => 'Belum Upload'],
                            ]" 
                            className="md:w-48" 
                        />
                    </div>
                </div>

                <x-atoms.button
                    wire:click="openCreateModal"
                    variant="success"
                    heroicon="plus"
                    className="whitespace-nowrap"
                >
                    Tambah Siswa
                </x-atoms.button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">NISN</th>
                        <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">No Telepon</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($siswas->count() > 0)
                        @foreach ($siswas as $index => $siswa)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-heroicon-o-identification class="w-4 h-4 text-gray-400" />
                                        <span class="font-mono text-sm">{{ $siswa->nisn }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-sm">
                                                {{ strtoupper(substr($siswa->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $siswa->name }}</p>
                                            <div class="flex items-center gap-1 text-xs text-gray-500">
                                                <x-heroicon-o-calendar-days class="w-3 h-3" />
                                                <span>{{ $siswa->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <x-heroicon-o-envelope class="w-4 h-4 text-gray-400 mr-2" />
                                        <span class="text-sm">{{ $siswa->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($siswa->telp)
                                        <div class="flex items-center">
                                            <x-heroicon-o-phone class="w-4 h-4 text-gray-400 mr-2" />
                                            <span class="text-sm">{{ $siswa->telp }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <x-atoms.badge 
                                            :text="'Data: ' . (optional($siswa->dataMurid)->proses ? 'Lengkap' : 'Belum')" 
                                            :variant="optional($siswa->dataMurid)->proses ? 'emerald' : 'gold'" 
                                            size="sm" 
                                        />

                                        @if ($siswa->buktiTransfer)
                                            <x-atoms.badge 
                                                :text="'Transfer: ' . ucfirst($siswa->buktiTransfer->status)" 
                                                :variant="match ($siswa->buktiTransfer->status) {
                                                    'success' => 'emerald',
                                                    'decline' => 'danger',
                                                    default => 'gold',
                                                }" 
                                                size="sm" 
                                            />
                                        @else
                                            <x-atoms.badge text="Transfer: Belum" variant="light" size="sm" />
                                        @endif

                                        @php
                                            $pendaftaranDiterima = $siswa->pendaftaranMurids->where('status', 'diterima')->count();
                                        @endphp
                                        @if($pendaftaranDiterima > 0)
                                            <x-atoms.badge text="Diterima" variant="emerald" size="sm" />
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <x-atoms.button
                                            wire:click='detail({{ $siswa->id }})'
                                            variant="ghost"
                                            theme="dark"
                                            size="sm"
                                            heroicon="eye"
                                            className="text-blue-600 hover:text-blue-800"
                                        >
                                            Detail
                                        </x-atoms.button>
                                        
                                        <x-atoms.button
                                            wire:click="deleteSiswa({{ $siswa->id }})"
                                            wire:confirm="Yakin ingin menghapus siswa ini?"
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
                            <td class="text-center px-6 py-12 text-gray-500" colspan="7">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                                    </div>
                                    <div class="text-center">
                                        <x-atoms.title text="Tidak ada data siswa" size="md" className="text-gray-500 mb-2" />
                                        <x-atoms.description color="gray-400">
                                            @if ($search || $statusFilter || $transferFilter)
                                                Tidak ditemukan siswa sesuai filter yang dipilih
                                            @else
                                                Belum ada data siswa yang terdaftar
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

        @if ($siswas->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $siswas->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal Tambah Siswa --}}
    <x-atoms.modal name="create-siswa" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-user-plus class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <x-atoms.title text="Tambah Siswa Baru" size="lg" />
                    <x-atoms.description size="sm" color="gray-500">
                        Lengkapi form dibawah untuk menambahkan siswa baru
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="createSiswa" class="space-y-5">
                {{-- Nama dan Email --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <x-molecules.input-field
                        label="Nama Lengkap"
                        name="name"
                        wire:model="name"
                        placeholder="Masukkan nama lengkap siswa"
                        :required="true"
                        :error="$errors->first('name')"
                        icon="ri-user-line"
                    />

                    <x-molecules.input-field
                        label="Email"
                        inputType="email"
                        name="email"
                        wire:model="email"
                        placeholder="siswa@example.com"
                        :required="true"
                        :error="$errors->first('email')"
                        icon="ri-mail-line"
                    />
                </div>

                {{-- NISN dan Telepon --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <x-molecules.input-field
                            label="NISN"
                            name="nisn"
                            wire:model.blur="nisn"
                            wire:keyup="checkNISN"
                            placeholder="Nomor Induk Siswa Nasional"
                            :required="true"
                            :error="$errors->first('nisn')"
                            icon="ri-id-card-line"
                        />
                        
                    </div>

                    <x-molecules.input-field
                        label="No. Telepon"
                        inputType="tel"
                        name="telp"
                        wire:model="telp"
                        placeholder="08xxxxxxxxxx"
                        :error="$errors->first('telp')"
                        icon="ri-phone-line"
                    />
                </div>

                {{-- Password --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <x-molecules.input-field
                        label="Password"
                        inputType="password"
                        name="password"
                        wire:model="password"
                        placeholder="Minimal 8 karakter"
                        :required="true"
                        :error="$errors->first('password')"
                        icon="ri-lock-line"
                    />

                    <x-molecules.input-field
                        label="Konfirmasi Password"
                        inputType="password"
                        name="password_confirmation"
                        wire:model="password_confirmation"
                        placeholder="Ulangi password"
                        :required="true"
                        :error="$errors->first('password_confirmation')"
                        icon="ri-lock-line"
                    />
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" />
                        <div>
                            <x-atoms.title text="Informasi Penting" size="sm" className="text-blue-900 mb-2" />
                            <div class="text-sm text-blue-800 space-y-1">
                                <p>• Siswa akan langsung dapat login menggunakan email dan password</p>
                                <p>• NISN harus unik dan tidak boleh sama dengan siswa lain</p>
                                <p>• Siswa dapat melengkapi data pribadi setelah login</p>
                                <p>• Email akan digunakan untuk notifikasi sistem</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="border-t pt-6 mt-6">
                    <div class="flex gap-3">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1"
                            wire:loading.attr="disabled"
                            wire:target="createSiswa"
                        >
                            <span wire:loading.remove wire:target="createSiswa">Simpan Siswa</span>
                            <span wire:loading wire:target="createSiswa">Menyimpan...</span>
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

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="createSiswa" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Menyimpan data siswa...</span>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
    window.addEventListener('success', event => {
        console.log('Success:', event.detail.message);
        
        // Show success toast
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        toast.innerHTML = `
            <div class="flex items-center gap-2">
                <i class="ri-check-circle-line"></i>
                <span>${event.detail.message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
    
    window.addEventListener('error', event => {
        console.log('Error:', event.detail.message);
        
        // Show error toast
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        toast.innerHTML = `
            <div class="flex items-center gap-2">
                <i class="ri-error-warning-line"></i>
                <span>${event.detail.message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });

    // Format NISN input
    document.addEventListener('input', function(e) {
        if (e.target.name === 'nisn') {
            // Remove any non-numeric characters
            let value = e.target.value.replace(/[^\d]/g, '');
            
            // Limit to 10 digits
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            
            e.target.value = value;
        }
    });

    // Format phone number input
    document.addEventListener('input', function(e) {
        if (e.target.name === 'telp') {
            // Remove any non-numeric characters except +
            let value = e.target.value.replace(/[^\d+]/g, '');
            
            // If starts with 0, replace with +62
            if (value.startsWith('0')) {
                value = '+62' + value.slice(1);
            }
            
            e.target.value = value;
        }
    });
</script>
@endpush