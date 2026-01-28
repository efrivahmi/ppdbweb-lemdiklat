@php
    $activeNews = $this->getActiveNews();
    $priorityNews = $this->getPriorityNews();
    $regularNews = $this->getRegularNews();
@endphp

@if ($activeNews->count())
    <section class="space-y-8">
        <div class="flex flex-col md:flex-row justify-between lg:items-end space-y-4">
            <div class="space-y-3">
                <x-atoms.badge :text="$sectionData['badge']['text']" :variant="$sectionData['badge']['variant']" />
                <x-atoms.title :text="$sectionData['title']['text']" :highlight="$sectionData['title']['highlight']" :size="$sectionData['title']['size']" :className="$sectionData['title']['className']" />
            </div>

            <a href="{{ $sectionData['button']['href'] }}">
                <x-atoms.button :variant="$sectionData['button']['variant']" heroicon="arrow-right" iconPosition="right" :className="$sectionData['button']['className']">
                    {{ $sectionData['button']['text'] }}
                </x-atoms.button>
            </a>
        </div>

        @if ($showPriorityNews && $priorityNews->count())
            <div class="space-y-6">
                @foreach ($priorityNews as $berita)
                    <x-molecules.priority-news-card :berita="$berita" :isPriority="true" :showFullContent="false" />
                @endforeach
            </div>
        @endif

        @if ($regularNews->count())
            <div class="space-y-6">
                @if ($showPriorityNews && $priorityNews->count())
                    <div class="flex items-center gap-4 py-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-gray-300"></div>
                        <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
                            <span>Berita Lainnya</span>
                            <div class="w-2 h-2 bg-lime-500 rounded-full"></div>
                        </div>
                        <div class="flex-1 h-px bg-gradient-to-l from-transparent via-gray-300 to-gray-300"></div>
                    </div>
                @endif

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($regularNews as $berita)
                        <x-molecules.news-card :berita="$berita" buttonText="Baca Selengkapnya" :showDebug="false" />
                    @endforeach
                </div>
            </div>
        @endif

        @if ($priorityNews->count() === 0 && $regularNews->count() === 0)
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-document-text class="w-8 h-8 text-gray-400" />
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">
                    Belum Ada Berita
                </h3>
                <p class="text-gray-500">
                    Berita terbaru akan segera hadir. Pantau terus halaman ini!
                </p>
            </div>
        @endif
    </section>
@else
    <section class="text-center py-16">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <x-heroicon-o-newspaper class="w-10 h-10 text-gray-400" />
        </div>
        <h3 class="text-xl font-semibold text-gray-600 mb-3">
            Tidak Ada Berita Tersedia
        </h3>
        <p class="text-gray-500 max-w-md mx-auto">
            Saat ini belum ada berita yang dapat ditampilkan. Silakan kembali lagi nanti untuk mendapatkan informasi
            terbaru.
        </p>
    </section>
@endif
