@props([
    'person' => null,
])

@php
if (!$person) {
    return;
}

// Color schemes berdasarkan posisi
$colorSchemes = [
    1 => [ // Kepala Sekolah
        'header' => 'from-yellow-400 to-amber-500',
        'border' => 'border-yellow-200',
        'avatar' => 'from-yellow-100 to-amber-100',
        'badge' => 'gold'
    ],
    2 => [ // Wakil Kepala Sekolah - Akademik
        'header' => 'from-blue-500 to-blue-600',
        'border' => 'border-blue-200',
        'avatar' => 'from-blue-100 to-sky-100',
        'badge' => 'sky'
    ],
    3 => [ // Wakil Kepala Sekolah - Kesiswaan
        'header' => 'from-purple-500 to-purple-600',
        'border' => 'border-purple-200',
        'avatar' => 'from-purple-100 to-violet-100',
        'badge' => 'danger'
    ],
    4 => [ // Wakil Kepala Sekolah - Sarana Prasarana
        'header' => 'from-green-500 to-green-600',
        'border' => 'border-green-200',
        'avatar' => 'from-green-100 to-emerald-100',
        'badge' => 'emerald'
    ],
    5 => [ // Wakil Kepala Sekolah - Humas
        'header' => 'from-pink-500 to-pink-600',
        'border' => 'border-pink-200',
        'avatar' => 'from-pink-100 to-rose-100',
        'badge' => 'light'
    ],
];

// Default untuk guru dan staff lainnya
$defaultColors = [
    'header' => 'from-gray-500 to-slate-600',
    'border' => 'border-gray-200',
    'avatar' => 'from-gray-100 to-slate-100',
    'badge' => 'black'
];

$colors = $colorSchemes[$person->posisi] ?? $defaultColors;
$avatarUrl = $person->img ? asset('storage/' . $person->img) : null;
@endphp

<div class="group">
    <article class="bg-white rounded-2xl shadow-lg border {{ $colors['border'] }} overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="h-20 bg-gradient-to-r {{ $colors['header'] }}"></div>

        <div class="relative -mt-16 flex justify-center">
            <div class="w-40 h-40 rounded-full border-4 border-white shadow-lg overflow-hidden bg-gradient-to-br {{ $colors['avatar'] }}">
                @if ($avatarUrl)
                    <img 
                        src="{{ $avatarUrl }}" 
                        alt="{{ $person->nama }}" 
                        class="w-full h-full object-cover"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" 
                    />
                @endif
                
                <div class="w-full h-full flex items-center justify-center {{ $avatarUrl ? 'hidden' : 'flex' }}">
                    <x-heroicon-o-user class="w-10 h-10 text-lime-600" />
                </div>
            </div>
        </div>

        <div class="px-6 pt-4 pb-6 text-center">
            <x-atoms.title 
                :text="$person->nama" 
                size="md" 
                align="center"
                class="text-gray-800 mb-3 group-hover:text-lime-600 transition-colors"
            />

            <div class="mb-4">
                <x-atoms.badge 
                    :text="$person->jabatan" 
                    :variant="$colors['badge']" 
                    size="sm" 
                    class="inline-block"
                />
            </div>

            @if ($person->desc)
                <x-atoms.description class="text-gray-600 text-sm leading-relaxed line-clamp-4">
                    {{ $person->desc }}
                </x-atoms.description>
            @endif
        </div>
    </article>
</div>