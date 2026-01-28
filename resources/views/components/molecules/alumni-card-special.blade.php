@props(['alumni' => null])

@php
if (!$alumni) return;
$avatarUrl = $alumni->image ? asset('storage/' . $alumni->image) : null;
@endphp

<div class="group h-full">
  <article
    class="h-full bg-white rounded-3xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col">

    <div class="h-40 bg-gradient-to-r from-gray-500 to-slate-700"></div>

    <div class="relative -mt-28 flex justify-center">
      <div class="w-36 h-36 rounded-full border-6 border-white shadow-xl overflow-hidden bg-gradient-to-br from-gray-100 to-slate-100">
        @if ($avatarUrl)
        <img src="{{ $avatarUrl }}" alt="{{ $alumni->name }}"
          class="w-full h-full object-cover"
          onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
        @endif
        <div class="w-full h-full flex items-center justify-center {{ $avatarUrl ? 'hidden' : 'flex' }}">
          <x-heroicon-o-user class="w-12 h-12 text-lime-600" />
        </div>
      </div>
    </div>

    <div class="flex flex-col flex-1 px-8 pt-6 pb-10 text-center justify-between">
      <div>
        <x-atoms.title :text="$alumni->name"
          size="2xl"
          align="center"
          class="text-gray-800 mb-4 group-hover:text-lime-600 transition-colors" />

        <div class="mb-3 text-base text-gray-500">
          {{ $alumni->jurusan?->nama }} · {{ $alumni->tahun_lulus }}
        </div>

        @if ($alumni->desc)
        <x-atoms.description class="text-gray-600 text-base leading-relaxed line-clamp-6">
          {{ $alumni->desc }}
        </x-atoms.description>
        @endif
      </div>
    </div>
  </article>
</div>