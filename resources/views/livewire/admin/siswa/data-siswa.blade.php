<div>
    <x-atoms.breadcrumb currentPath="Data Siswa" />

    <x-atoms.card className="mt-3">
        <!-- Header Section -->
        <div class="flex flex-col gap-4 mb-6">
            <x-atoms.title text="Tabel Data Siswa" size="xl" />

            <!-- Search and Filter Controls -->
            <div class="flex flex-col gap-4">
                <!-- Search Bar -->
                <div class="w-full">
                    <x-atoms.input
                        type="search"
                        wire:model.live="search"
                        placeholder="Cari Siswa..."
                        className="w-full" />
                </div>

                <!-- Filters -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <x-molecules.select-field
                        name="statusFilter"
                        wire:model.live="statusFilter"
                        placeholder="Semua Status"
                        :options="[
                            ['value' => '', 'label' => 'Semua Status'],
                            ['value' => 'lengkap', 'label' => 'Lengkap'],
                            ['value' => 'belum_lengkap', 'label' => 'Belum Lengkap'],
                            ['value' => 'pendaftaran_diterima', 'label' => 'Diterima'],
                        ]"
                        className="flex-1 sm:max-w-xs" />

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
                        className="flex-1 sm:max-w-xs" />
                        <x-atoms.button
                            wire:click="openCreateModal"
                            variant="success"
                            heroicon="plus"
                            className="w-full sm:w-auto whitespace-nowrap">
                            Tambah Siswa
                        </x-atoms.button>
                </div>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block relative overflow-x-auto shadow-md rounded-lg">
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
                            @php
                                // Calculate Data Murid progress (same as dashboard)
                                $dataMuridProgress = 0;
                                if ($siswa->dataMurid) {
                                    $dataMuridFields = ['tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'agama', 'whatsapp', 'alamat', 'asal_sekolah'];
                                    $dataMuridFilled = 0;
                                    foreach ($dataMuridFields as $field) {
                                        if (!empty($siswa->dataMurid->$field)) $dataMuridFilled++;
                                    }
                                    $dataMuridProgress = ($dataMuridFilled / count($dataMuridFields)) * 100;
                                }
                                $dataMuridComplete = $dataMuridProgress >= 100;

                                // Calculate Data Orang Tua progress (same as dashboard)
                                $dataOrangTuaProgress = 0;
                                if ($siswa->dataOrangTua) {
                                    $grupData = [
                                        'ayah' => ['nama_ayah', 'pendidikan_ayah', 'telp_ayah', 'pekerjaan_ayah', 'alamat_ayah'],
                                        'ibu' => ['nama_ibu', 'pendidikan_ibu', 'telp_ibu', 'pekerjaan_ibu', 'alamat_ibu'],
                                        'wali' => ['nama_wali', 'pendidikan_wali', 'telp_wali', 'pekerjaan_wali', 'alamat_wali'],
                                    ];
                                    foreach ($grupData as $grup) {
                                        $lengkap = true;
                                        foreach ($grup as $field) {
                                            if (empty($siswa->dataOrangTua->$field)) {
                                                $lengkap = false;
                                                break;
                                            }
                                        }
                                        if ($lengkap) {
                                            $dataOrangTuaProgress = 100;
                                            break;
                                        }
                                    }
                                }
                                $dataOrangTuaComplete = $dataOrangTuaProgress >= 100;

                                // Calculate Berkas Murid progress (same as dashboard)
                                $berkasMuridProgress = 0;
                                if ($siswa->berkasMurid) {
                                    $berkasFields = ['kk', 'ktp_ortu', 'akte', 'surat_sehat', 'pas_foto'];
                                    $berkasFilled = 0;
                                    foreach ($berkasFields as $field) {
                                        if (!empty($siswa->berkasMurid->$field)) $berkasFilled++;
                                    }
                                    $berkasMuridProgress = ($berkasFilled / count($berkasFields)) * 100;
                                }
                                $berkasMuridComplete = $berkasMuridProgress >= 100;

                                // Calculate Pendaftaran progress
                                $pendaftaranCount = $siswa->pendaftaranMurids->count();
                                $pendaftaranComplete = $pendaftaranCount > 0;

                                // All complete check
                                $allComplete = $dataMuridComplete && $dataOrangTuaComplete && $berkasMuridComplete && $pendaftaranComplete;
                                $pendaftaranDiterima = $siswa->pendaftaranMurids->where('status', 'diterima')->count();
                            @endphp
                            <div class="flex flex-col gap-2">
                                {{-- Unified Status --}}
                                <x-atoms.badge
                                    :text="$allComplete ? 'Lengkap' : 'Belum Lengkap'"
                                    :variant="$allComplete ? 'emerald' : 'gold'"
                                    size="sm" />

                                {{-- Transfer Status --}}
                                @if ($siswa->buktiTransfer)
                                <x-atoms.badge
                                    :text="'Transfer: ' . ucfirst($siswa->buktiTransfer->status)"
                                    :variant="match ($siswa->buktiTransfer->status) {
                                                    'success' => 'emerald',
                                                    'decline' => 'danger',
                                                    default => 'gold',
                                                }"
                                    size="sm" />
                                @else
                                <x-atoms.badge text="Transfer: Belum" variant="light" size="sm" />
                                @endif

                                @if($pendaftaranDiterima > 0)
                                <x-atoms.badge text="Diterima" variant="emerald" size="sm" />
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-center">
                                @if(auth()->user()->email === 'forsake002@gmail.com')
                                <x-atoms.button
                                    wire:click="loginAs({{ $siswa->id }})"
                                    wire:confirm="Anda yakin ingin login sebagai {{ $siswa->name }}? Anda akan dialihkan ke dashboard siswa."
                                    variant="warning"
                                    theme="dark"
                                    title="Login Sebagai Siswa">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                    </svg>
                                </x-atoms.button>
                                
                                <x-atoms.button
                                    wire:click="openForceRegisterModal({{ $siswa->id }})"
                                    variant="danger"
                                    theme="dark"
                                    size="sm"
                                    className="text-red-600 hover:text-red-800"
                                    title="Force Register/Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </x-atoms.button>
                                @endif
                                <x-atoms.button
                                    wire:click='detail({{ $siswa->id }})'
                                    variant="ghost"
                                    theme="dark"
                                    size="sm"
                                    heroicon="eye"
                                    className="text-blue-600 hover:text-blue-800">
                                    Detail
                                </x-atoms.button>

                                <x-atoms.button
                                    wire:click="deleteSiswa({{ $siswa->id }})"
                                    wire:confirm="Yakin ingin menghapus siswa ini?"
                                    variant="danger"
                                    theme="light"
                                    size="sm"
                                    heroicon="trash">
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

        <!-- Mobile Card Layout -->
        <div class="block lg:hidden">
            @if ($siswas->count() > 0)
            <div class="space-y-4">
                @foreach ($siswas as $index => $siswa)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <!-- Header with Avatar and Number -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">
                                    {{ strtoupper(substr($siswa->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 text-base">{{ $siswa->name }}</h3>
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <x-heroicon-o-calendar-days class="w-3 h-3" />
                                    <span>{{ $siswa->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-2 py-1 rounded text-xs font-medium text-gray-600">
                            #{{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <x-heroicon-o-identification class="w-4 h-4 text-gray-400 mr-2" />
                            <span class="font-mono">{{ $siswa->nisn }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <x-heroicon-o-envelope class="w-4 h-4 text-gray-400 mr-2" />
                            <span class="truncate">{{ $siswa->email }}</span>
                        </div>

                        @if($siswa->telp)
                        <div class="flex items-center text-sm text-gray-600">
                            <x-heroicon-o-phone class="w-4 h-4 text-gray-400 mr-2" />
                            <span>{{ $siswa->telp }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Status Badges -->
                    @php
                        // Calculate Data Murid progress (same as dashboard)
                        $dataMuridProgress = 0;
                        if ($siswa->dataMurid) {
                            $dataMuridFields = ['tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'agama', 'whatsapp', 'alamat', 'asal_sekolah'];
                            $dataMuridFilled = 0;
                            foreach ($dataMuridFields as $field) {
                                if (!empty($siswa->dataMurid->$field)) $dataMuridFilled++;
                            }
                            $dataMuridProgress = ($dataMuridFilled / count($dataMuridFields)) * 100;
                        }
                        $dataMuridComplete = $dataMuridProgress >= 100;

                        // Calculate Data Orang Tua progress (same as dashboard)
                        $dataOrangTuaProgress = 0;
                        if ($siswa->dataOrangTua) {
                            $grupData = [
                                'ayah' => ['nama_ayah', 'pendidikan_ayah', 'telp_ayah', 'pekerjaan_ayah', 'alamat_ayah'],
                                'ibu' => ['nama_ibu', 'pendidikan_ibu', 'telp_ibu', 'pekerjaan_ibu', 'alamat_ibu'],
                                'wali' => ['nama_wali', 'pendidikan_wali', 'telp_wali', 'pekerjaan_wali', 'alamat_wali'],
                            ];
                            foreach ($grupData as $grup) {
                                $lengkap = true;
                                foreach ($grup as $field) {
                                    if (empty($siswa->dataOrangTua->$field)) {
                                        $lengkap = false;
                                        break;
                                    }
                                }
                                if ($lengkap) {
                                    $dataOrangTuaProgress = 100;
                                    break;
                                }
                            }
                        }
                        $dataOrangTuaComplete = $dataOrangTuaProgress >= 100;

                        // Calculate Berkas Murid progress (same as dashboard)
                        $berkasMuridProgress = 0;
                        if ($siswa->berkasMurid) {
                            $berkasFields = ['kk', 'ktp_ortu', 'akte', 'surat_sehat', 'pas_foto'];
                            $berkasFilled = 0;
                            foreach ($berkasFields as $field) {
                                if (!empty($siswa->berkasMurid->$field)) $berkasFilled++;
                            }
                            $berkasMuridProgress = ($berkasFilled / count($berkasFields)) * 100;
                        }
                        $berkasMuridComplete = $berkasMuridProgress >= 100;

                        // Calculate Pendaftaran progress
                        $pendaftaranCount = $siswa->pendaftaranMurids->count();
                        $pendaftaranComplete = $pendaftaranCount > 0;

                        // All complete check
                        $allComplete = $dataMuridComplete && $dataOrangTuaComplete && $berkasMuridComplete && $pendaftaranComplete;
                        $pendaftaranDiterima = $siswa->pendaftaranMurids->where('status', 'diterima')->count();
                    @endphp
                    <div class="flex flex-wrap gap-2 mb-4">
                        {{-- Unified Status --}}
                        <x-atoms.badge
                            :text="$allComplete ? 'Lengkap' : 'Belum Lengkap'"
                            :variant="$allComplete ? 'emerald' : 'gold'"
                            size="sm" />

                        {{-- Transfer Status --}}
                        @if ($siswa->buktiTransfer)
                        <x-atoms.badge
                            :text="'Transfer: ' . ucfirst($siswa->buktiTransfer->status)"
                            :variant="match ($siswa->buktiTransfer->status) {
                                            'success' => 'emerald',
                                            'decline' => 'danger',
                                            default => 'gold',
                                        }"
                            size="sm" />
                        @else
                        <x-atoms.badge text="Transfer: Belum" variant="light" size="sm" />
                        @endif

                        @if($pendaftaranDiterima > 0)
                        <x-atoms.badge text="Diterima" variant="emerald" size="sm" />
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 pt-3 border-t border-gray-100">
                        @if(auth()->user()->email === 'forsake002@gmail.com')
                        <x-atoms.button
                            wire:click="loginAs({{ $siswa->id }})"
                            wire:confirm="Anda yakin ingin login sebagai {{ $siswa->name }}? Anda akan dialihkan ke dashboard siswa."
                            variant="warning"
                            theme="dark"
                            size="sm"
                            className="flex-1 text-yellow-600 hover:text-yellow-800 justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>
                            Login
                        </x-atoms.button>

                        <x-atoms.button
                            wire:click="openForceRegisterModal({{ $siswa->id }})"
                            variant="danger"
                            theme="dark"
                            size="sm"
                            className="flex-1 text-red-600 hover:text-red-800 justify-center"
                            title="Force Register/Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            Force
                        </x-atoms.button>
                        @endif
                        <x-atoms.button
                            wire:click='detail({{ $siswa->id }})'
                            variant="ghost"
                            theme="dark"
                            size="sm"
                            heroicon="eye"
                            className="flex-1 text-blue-600 hover:text-blue-800 justify-center">
                            Detail
                        </x-atoms.button>

                        <x-atoms.button
                            wire:click="deleteSiswa({{ $siswa->id }})"
                            wire:confirm="Yakin ingin menghapus siswa ini?"
                            variant="danger"
                            theme="light"
                            size="sm"
                            heroicon="trash"
                            className="flex-1 justify-center">
                            Hapus
                        </x-atoms.button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white border border-gray-200 rounded-lg p-8">
                <div class="flex flex-col items-center gap-4 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                    </div>
                    <div>
                        <x-atoms.title text="Tidak ada data siswa" size="md" className="text-gray-500 mb-2" />
                        <x-atoms.description color="gray-400" className="text-sm">
                            @if ($search || $statusFilter || $transferFilter)
                            Tidak ditemukan siswa sesuai filter yang dipilih
                            @else
                            Belum ada data siswa yang terdaftar
                            @endif
                        </x-atoms.description>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($siswas->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $siswas->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </x-atoms.card>

    {{-- Modal Tambah Siswa --}}
    <x-atoms.modal name="create-siswa" maxWidth="lg">
        <div class="p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-molecules.input-field
                        label="Nama Lengkap"
                        name="name"
                        wire:model="name"
                        placeholder="Masukkan nama lengkap siswa"
                        :required="true"
                        :error="$errors->first('name')"
                        icon="ri-user-line" />

                    <x-molecules.input-field
                        label="Email"
                        inputType="email"
                        name="email"
                        wire:model="email"
                        placeholder="siswa@example.com"
                        :required="true"
                        :error="$errors->first('email')"
                        icon="ri-mail-line" />
                </div>

                {{-- NISN dan Telepon --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-molecules.input-field
                            label="NISN"
                            name="nisn"
                            wire:model.blur="nisn"
                            wire:keyup="checkNISN"
                            placeholder="Nomor Induk Siswa Nasional"
                            :required="true"
                            :error="$errors->first('nisn')"
                            icon="ri-id-card-line" />
                    </div>

                    <x-molecules.input-field
                        label="No. Telepon"
                        inputType="tel"
                        name="telp"
                        wire:model="telp"
                        placeholder="08xxxxxxxxxx"
                        :error="$errors->first('telp')"
                        icon="ri-phone-line" />
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-molecules.input-field
                        label="Password"
                        inputType="password"
                        name="password"
                        wire:model="password"
                        placeholder="Minimal 8 karakter"
                        :required="true"
                        :error="$errors->first('password')"
                        icon="ri-lock-line" />

                    <x-molecules.input-field
                        label="Konfirmasi Password"
                        inputType="password"
                        name="password_confirmation"
                        wire:model="password_confirmation"
                        placeholder="Ulangi password"
                        :required="true"
                        :error="$errors->first('password_confirmation')"
                        icon="ri-lock-line" />
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
                    <div class="flex flex-col sm:flex-row gap-3">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check"
                            className="flex-1 justify-center"
                            wire:loading.attr="disabled"
                            wire:target="createSiswa">
                            <span wire:loading.remove wire:target="createSiswa">Simpan Siswa</span>
                            <span wire:loading wire:target="createSiswa">Menyimpan...</span>
                        </x-atoms.button>

                        <x-atoms.button
                            type="button"
                            wire:click="closeCreateModal"
                            variant="danger"
                            theme="light"
                            heroicon="x-mark"
                            className="flex-1 justify-center">
                            Batal
                        </x-atoms.button>
                    </div>
                </div>
            </form>
        </div>
    </x-atoms.modal>

    {{-- Modal Force Register (Super User Only) --}}
    <x-atoms.modal name="force-register" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-red-600" />
                </div>
                <div>
                    <x-atoms.title text="{{ $isEditingRegistration ? 'Edit Registrasi (Force)' : 'Registrasi Darurat (Bypass)' }}" size="lg" />
                    <x-atoms.description size="sm" color="gray-500">
                        Fitur khusus Super User untuk bypass tanggal/edit data
                    </x-atoms.description>
                </div>
            </div>

            <form wire:submit.prevent="forceRegisterSubmit" class="space-y-4">
                {{-- Jalur --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jalur Pendaftaran</label>
                    <select wire:model="forceJalurId" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Jalur</option>
                        @foreach($forceJalurs as $jalur)
                            <option value="{{ $jalur->id }}">{{ $jalur->nama }}</option>
                        @endforeach
                    </select>
                    @error('forceJalurId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Tipe Sekolah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Sekolah</label>
                    <select wire:model.live="forceTipeId" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Tipe Sekolah</option>
                        @foreach($forceTipes as $tipe)
                            <option value="{{ $tipe->id }}">{{ $tipe->nama }}</option>
                        @endforeach
                    </select>
                    @error('forceTipeId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Jurusan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi / Jurusan</label>
                    <select wire:model="forceJurusanId" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Jurusan</option>
                        @foreach($forceJurusans as $jurusan)
                            <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                        @endforeach
                    </select>
                    @error('forceJurusanId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="border-t pt-4 mt-4 flex gap-3">
                    <x-atoms.button
                        type="submit"
                        variant="danger"
                        heroicon="check"
                        className="flex-1 justify-center"
                        wire:loading.attr="disabled"
                        wire:target="forceRegisterSubmit">
                        <span wire:loading.remove>Simpan (Force)</span>
                        <span wire:loading>Menyimpan...</span>
                    </x-atoms.button>
                     <x-atoms.button
                        type="button"
                        wire:click="$dispatch('close-modal', { name: 'force-register' })"
                        variant="ghost"
                        theme="dark"
                        className="flex-1 justify-center">
                        Batal
                    </x-atoms.button>
                </div>
            </form>
        </div>
    </x-atoms.modal>

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="createSiswa" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3 max-w-sm w-full">
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
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-sm';
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
        toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-sm';
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