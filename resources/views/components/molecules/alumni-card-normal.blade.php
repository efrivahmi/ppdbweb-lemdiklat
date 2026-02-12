@props(['alumni' => null])

@php
if (!$alumni) return;
$avatarUrl = $alumni->image ? asset('storage/' . $alumni->image) : null;
@endphp

<div class="group h-full">
    <article class="h-full bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col">

        {{-- Image Section --}}
        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
            @if ($avatarUrl)
                <img src="{{ $avatarUrl }}" alt="{{ $alumni->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
            @endif
            <div class="w-full h-full flex items-center justify-center absolute inset-0 {{ $avatarUrl ? 'hidden' : 'flex' }}" style="{{ $avatarUrl ? 'display:none' : '' }}">
                <div class="w-16 h-16 bg-gradient-to-br from-lime-100 to-emerald-100 rounded-full flex items-center justify-center">
                    <x-heroicon-o-user class="w-8 h-8 text-lime-500" />
                </div>
            </div>

            {{-- Jurusan & Year --}}
            <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/50 to-transparent">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white/90 text-gray-700 backdrop-blur-sm">
                        {{ $alumni->jurusan?->nama ?? 'Jurusan' }}
                    </span>
                    <span class="text-[11px] font-bold text-white/90">
                        {{ $alumni->tahun_lulus }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex flex-col flex-1 p-4">
            <h3 class="text-sm font-bold text-gray-900 group-hover:text-lime-600 transition-colors leading-snug mb-2">
                {{ $alumni->name }}
            </h3>

            @if ($alumni->desc)
                <p class="text-gray-400 text-xs leading-relaxed line-clamp-3 italic flex-1">
                    "{{ $alumni->desc }}"
                </p>
            @endif
        </div>
    </article>
</div>