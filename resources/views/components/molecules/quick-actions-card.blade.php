@props([
    'actions' => [],
])

@php
$defaultActions = [
    [
        'url' => route('siswa.formulir.data-murid'),
        'icon' => 'ri-user-line',
        'color' => 'text-indigo-600',
        'label' => 'Data Siswa'
    ],
    [
        'url' => route('siswa.formulir.data-orang-tua'),
        'icon' => 'ri-parent-line',
        'color' => 'text-green-600',
        'label' => 'Data Orang Tua'
    ],
    [
        'url' => route('siswa.formulir.berkas-murid'),
        'icon' => 'ri-folder-line',
        'color' => 'text-blue-600',
        'label' => 'Berkas Siswa'
    ],
    [
        'url' => route('siswa.pendaftaran'),
        'icon' => 'ri-file-list-line',
        'color' => 'text-purple-600',
        'label' => 'Pendaftaran'
    ]
];

$displayActions = count($actions) > 0 ? $actions : $defaultActions;
@endphp

<div class="bg-white border border-gray-300 shadow-md rounded-md mt-6 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($displayActions as $action)
            <a href="{{ $action['url'] }}" 
               class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:shadow-md transition">
                <i class="{{ $action['icon'] }} text-2xl {{ $action['color'] }} mb-2"></i>
                <span class="text-sm text-gray-700 text-center">{{ $action['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>