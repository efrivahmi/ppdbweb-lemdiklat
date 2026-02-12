@props(['alumni' => null])

@php
if (!$alumni) return;
$avatarUrl = $alumni->image ? asset('storage/' . $alumni->image) : null;
@endphp

<div class="group h-full">
    <article class="h-full bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-500 hover:-translate-y-1 flex flex-col">

        {{-- Image Section --}}
        <div class="relative h-72 md:h-80 overflow-hidden bg-gray-100">
            @if ($avatarUrl)
                <img src="{{ $avatarUrl }}" alt="{{ $alumni->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
            @endif
            <div class="w-full h-full flex items-center justify-center absolute inset-0 {{ $avatarUrl ? 'hidden' : 'flex' }}" style="{{ $avatarUrl ? 'display:none' : '' }}">
                <div class="w-24 h-24 bg-gradient-to-br from-lime-100 to-emerald-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-user class="w-12 h-12 text-lime-500" />
                </div>
            </div>

            {{-- Star badge for selected --}}
            @if ($alumni->is_selected)
                <div class="absolute top-3 left-3">
                    <div class="flex items-center gap-1.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white px-3 py-1.5 rounded-full shadow-lg text-xs font-bold">
                        <x-heroicon-s-star class="w-3.5 h-3.5" />
                        Terpilih
                    </div>
                </div>
            @endif

            {{-- Jurusan badge --}}
            <div class="absolute top-3 right-3">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-white/90 text-gray-700 backdrop-blur-sm shadow-md">
                    <x-heroicon-o-academic-cap class="w-3 h-3 text-lime-600" />
                    {{ $alumni->jurusan?->nama ?? 'Jurusan' }}
                </span>
            </div>
        </div>

        {{-- Content Section --}}
        <div class="flex flex-col flex-1 p-6 md:p-7">
            {{-- Name & Year --}}
            <div class="mb-3">
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-lime-600 transition-colors leading-tight mb-1.5">
                    {{ $alumni->name }}
                </h3>
                <div class="flex items-center gap-2 text-sm text-gray-400">
                    <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                    <span class="font-medium">Lulus {{ $alumni->tahun_lulus }}</span>
                </div>
            </div>

            {{-- Quote --}}
            @if ($alumni->desc)
                <div class="relative flex-1">
                    <svg class="absolute -top-0.5 -left-1 w-5 h-5 text-lime-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-4 pl-5 italic">
                        "{{ $alumni->desc }}"
                    </p>
                </div>
            @endif
        </div>
    </article>
</div>