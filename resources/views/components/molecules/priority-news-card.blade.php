@props([
    'berita' => null,
    'isPriority' => true,
    'showFullContent' => true,
])

@php
if (!function_exists('getNewsBadgeVariant')) {
    function getNewsBadgeVariant($category) {
        switch (strtolower($category)) {
            case 'pendaftaran':
                return 'emerald';
            case 'prestasi':
                return 'gold';
            case 'kegiatan':
                return 'sky';
            case 'pengumuman':
                return 'danger';
            case 'akademik':
                return 'light';
            default:
                return 'emerald';
        }
    }
}

$id = $berita?->id;
$title = $berita?->title ?? '';
$slug = $berita?->slug ?? '';
$content = $berita?->excerpt ?? '';
$category = $berita?->kategori?->name ?? '';
$image = $berita?->thumbnail ?? '';
$placeholderImage = 'https://images.unsplash.com/photo-1586776977607-310e9c725c37?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
$imageUrl = $image
    ? (str_starts_with($image, 'http') ? $image : asset('storage/' . $image))
    : $placeholderImage;
$author = $berita?->creator?->name ?? '';
$isActive = $berita?->is_active ?? true;
$date = $berita?->created_at ? $berita->created_at->format('d M Y') : '';
@endphp

@if($berita)
    <article class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="relative">
            <div class="absolute top-4 left-4 z-20">
                <div class="flex items-center gap-2 bg-gradient-to-r from-amber-400 to-orange-500 text-white px-3 py-1.5 rounded-full shadow-lg">
                    <x-heroicon-o-star class="w-4 h-4 fill-current" />
                    <span class="text-xs font-bold">PRIORITAS</span>
                </div>
            </div>

            @if($category)
                <div class="absolute top-4 right-4 z-20">
                    <x-atoms.badge 
                        :text="$category" 
                        :variant="getNewsBadgeVariant($category)"
                        class="shadow-lg"
                    />
                </div>
            @endif

            @if(!$isActive)
                <div class="absolute top-16 left-4 z-20">
                    <x-atoms.badge 
                        text="Draft" 
                        variant="black"
                        class="shadow-lg"
                    />
                </div>
            @endif
        </div>

        <div class="block lg:grid lg:grid-cols-5 lg:gap-0">
            <div class="relative lg:col-span-2 h-64 sm:h-80 lg:h-96 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-lime-500/20 to-emerald-600/30 z-10"></div>
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $title }}"
                    class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                    loading="lazy"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                
                <div 
                    class="w-full h-full bg-gray-100 flex items-center justify-center absolute inset-0 z-0"
                    style="display: none;"
                >
                    <div class="text-center">
                        <x-heroicon-o-photo class="w-16 h-16 text-gray-400 mx-auto mb-2" />
                        <p class="text-sm text-gray-500">Gambar tidak tersedia</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-start">
                <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-calendar-days class="w-4 h-4 text-lime-600" />
                        <span class="font-medium">{{ $date }}</span>
                    </div>
                    
                    @if($author)
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-user class="w-4 h-4 text-lime-600" />
                            <span class="font-medium">{{ $author }}</span>
                        </div>
                    @endif
                </div>

                <x-atoms.title
                    :text="$title"
                    size="xl"
                    mdSize="2xl"
                    class="mb-6 text-gray-900 leading-tight hover:text-lime-600 transition-colors"
                />

                <div class="prose prose-sm sm:prose-base lg:prose-lg max-w-none text-gray-700 leading-relaxed text-justify mb-6 flex-1">
                    @if($content)
                        {!! $content !!}
                    @endif
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-lime-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-lime-600 font-semibold">Berita Utama</span>
                        </div>
                        <a href="{{ route('news.detail', $slug) }}"
                           class="inline-flex items-center gap-1.5 text-sm font-semibold text-lime-600 hover:text-lime-700 transition-colors group">
                            <span>Baca Selengkapnya</span>
                            <x-heroicon-o-arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </article>
@else
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 p-8 lg:p-12 text-center">
        <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
            <x-heroicon-o-newspaper class="w-8 h-8 text-gray-500" />
        </div>
        <x-atoms.title text="Berita Prioritas Tidak Tersedia" size="lg" class="text-gray-700 mb-2" />
        <p class="text-gray-600">Belum ada berita yang ditetapkan sebagai prioritas. Silakan tambahkan berita baru atau atur prioritas berita yang sudah ada.</p>
    </div>
@endif