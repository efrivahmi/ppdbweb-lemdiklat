<div class="max-w-7xl mx-auto">
    <div class="text-center mb-12">
        <x-atoms.badge
            text="Video Kami"
            variant="danger"
            class="mb-4" />
        <x-atoms.title
            text="Jelajahi Konten Video"
            highlight="Video"
            size="3xl"
            align="center"
            class="mb-4" />
        <x-atoms.description
            size="lg"
            align="center"
            class="max-w-2xl mx-auto text-gray-600">
            Tonton berbagai video menarik tentang kegiatan, prestasi, dan kehidupan sekolah kami
        </x-atoms.description>
    </div>

    @if($videos->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @foreach($videos as $video)
                <a
                    href="{{ $video->watch_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group block">
                    <div class="relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 aspect-video">
                        <img
                            src="{{ $video->thumbnail }}"
                            alt="{{ $video->title }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                        
                        <div class="absolute inset-0 bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center" style="display: none;">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-red-400 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                                <p class="text-xs text-red-600">Video YouTube</p>
                            </div>
                        </div>
                        
                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/0 transition-all duration-300 flex items-center justify-center">
                            <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300 shadow-2xl">
                                <svg class="w-10 h-10 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                </svg>
            </div>
            <x-atoms.title
                text="Belum Ada Video"
                size="xl"
                align="center"
                class="mb-3 text-gray-700" />
            <x-atoms.description
                size="md"
                align="center"
                class="text-gray-500">
                Video YouTube belum tersedia saat ini. Silakan periksa kembali nanti.
            </x-atoms.description>
        </div>
    @endif
</div>