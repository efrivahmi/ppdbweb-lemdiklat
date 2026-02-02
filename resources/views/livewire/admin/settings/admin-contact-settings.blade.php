<div>
    <x-atoms.breadcrumb currentPath="Pengaturan Kontak" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <x-atoms.title text="Pengaturan Kontak Admin" size="xl" />
                <x-atoms.description size="sm" color="gray-500">
                    Atur admin yang akan ditampilkan di dashboard siswa
                </x-atoms.description>
            </div>
            
            <div class="w-full md:w-auto">
                <x-atoms.input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari admin..."
                    className="md:w-64"
                />
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">No. Telepon</th>
                        <th scope="col" class="px-6 py-3 text-center">Tampilkan di Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $admin->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $admin->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $admin->telp ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only peer" 
                                           wire:change="toggleVisibility({{ $admin->id }})" 
                                           {{ $admin->show_in_contact ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-lime-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-lime-600"></div>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($admins->hasPages())
            <div class="mt-4">
                {{ $admins->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </x-atoms.card>
</div>
