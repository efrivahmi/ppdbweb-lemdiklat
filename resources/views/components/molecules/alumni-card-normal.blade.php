@props(['alumni' => null])

@php
if (!$alumni) return;
$avatarUrl = $alumni->image ? asset('storage/' . $alumni->image) : null;
@endphp

<div class="group h-full">
    <article
        class="h-full bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col">

        <div class="h-28 bg-gradient-to-r from-gray-500 to-slate-700"></div>

        <div class="relative -mt-20 flex justify-center">
            <div class="w-28 h-28 rounded-full border-4 border-white shadow-lg overflow-hidden bg-gradient-to-br from-gray-100 to-slate-100">
                @if ($avatarUrl)
                <img src="{{ $avatarUrl }}" alt="{{ $alumni->name }}"
                    class="w-full h-full object-cover"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                @endif
                <div class="w-full h-full flex items-center justify-center {{ $avatarUrl ? 'hidden' : 'flex' }}">
                    <x-heroicon-o-user class="w-8 h-8 text-lime-600" />
                </div>
            </div>
        </div>

        <div class="flex flex-col flex-1 px-6 pt-4 pb-6 text-center justify-between">
            <div>
                <x-atoms.title :text="$alumni->name"
                    size="md"
                    align="center"
                    class="text-gray-800 mb-3 group-hover:text-lime-600 transition-colors" />

                <div class="mb-2 text-sm text-gray-500">
                    {{ $alumni->jurusan?->nama }} · {{ $alumni->tahun_lulus }}
                </div>

                @if ($alumni->desc)
                <x-atoms.description class="text-gray-600 text-sm leading-relaxed line-clamp-4">
                    {{ $alumni->desc }}
                </x-atoms.description>
                @endif
            </div>
        </div>
    </article>
</div>