<div>
    <x-atoms.breadcrumb currentPath="Stat Landing" />

    <x-atoms.card className="mt-3">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <x-atoms.title text="Statistik Landing Page" size="xl" />
            <x-atoms.description class="text-gray-500">
                Anda hanya dapat mengubah <b>Guru Berkualitas</b> dan <b>Prestasi Nasional</b>. 
                Tidak bisa menambah atau menghapus.
            </x-atoms.description>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-lime-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Label</th>
                        <th scope="col" class="px-6 py-3">Value</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats as $stat)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4">
                                @if ($stat['is_editable'])
                                    <x-atoms.input type="text"
                                        wire:change="updateStat({{ $stat['id'] }}, 'label', $event.target.value)"
                                        value="{{ $stat['label'] }}" />
                                @else
                                    <span class="text-gray-700 font-medium">{{ $stat['label'] }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($stat['is_editable'])
                                    <x-atoms.input type="text"
                                        wire:change="updateStat({{ $stat['id'] }}, 'value', $event.target.value)"
                                        value="{{ $stat['value'] }}" />
                                @else
                                    <span class="text-gray-900 font-semibold">{{ $stat['value'] }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($stat['is_editable'])
                                    <x-atoms.badge text="Editable" variant="lime" size="sm" />
                                @else
                                    <x-atoms.badge text="Terkunci" variant="red" size="sm" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-atoms.card>
</div>
