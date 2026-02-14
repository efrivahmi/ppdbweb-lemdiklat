@props([
    'berita' => null,
    'buttonText' => 'Baca Selengkapnya',
    'showDebug' => false,
])

@php
    if (!function_exists('getNewsBadgeVariant')) {
        function getNewsBadgeVariant($category)
        {
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
    $excerpt = $berita?->excerpt ?? '';
    $fullContent = $berita?->content ?? '';
    $category = $berita?->kategori?->name ?? '';
    $image = $berita?->thumbnail ?? '';
    $placeholderImage =
        'https://images.unsplash.com/photo-1586776977607-310e9c725c37?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
    $imageUrl = $image
        ? (str_starts_with($image, 'http') ? $image : asset('storage/' . $image))
        : $placeholderImage;
    $author = $berita?->creator?->name ?? '';
    $isActive = $berita?->is_active ?? true;
    $date = $berita?->created_at ? $berita->created_at->format('d M Y') : '';
    $modalId = 'news-modal-' . $id;
    
    // Share URL - gunakan URL detail page yang bisa dibagikan
    $shareUrl = route('news.detail', $slug);
    $shareTitle = $title;
    $shareText = $excerpt;

    // Cek apakah berita ini yang harus dibuka berdasarkan parameter URL
    $shouldOpenModal = request()->get('berita') === $slug;
@endphp

@if ($berita)
    <div x-data="{
        showShareMenu: false,
        shareUrl: '{{ $shareUrl }}',
        shareTitle: '{{ addslashes($shareTitle) }}',
        shareText: '{{ addslashes($shareText) }}',
        copied: false,
        modalId: '{{ $modalId }}',
        slug: '{{ $slug }}',
        
        init() {
            // Cek apakah ini berita yang harus dibuka dari URL
            if (this.shouldOpenFromUrl()) {
                // Beri sedikit delay untuk memastikan modal sudah ter-render
                setTimeout(() => {
                    this.openModal();
                }, 100);
            }

            // Listen untuk perubahan URL (back/forward browser)
            window.addEventListener('popstate', () => {
                if (this.shouldOpenFromUrl()) {
                    this.openModal();
                } else {
                    this.closeModal();
                }
            });
        },

        shouldOpenFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('berita') === this.slug;
        },

        openModal() {
            this.$dispatch('open-modal', { name: this.modalId });
            // Update URL tanpa reload
            this.updateUrlWithModal();
        },

        closeModal() {
            this.$dispatch('close-modal', { name: this.modalId });
            this.removeModalFromUrl();
        },

        updateUrlWithModal() {
            const newUrl = window.location.origin + window.location.pathname + '?berita=' + this.slug;
            window.history.pushState({ modalOpen: true }, '', newUrl);
        },

        removeModalFromUrl() {
            const baseUrl = window.location.origin + window.location.pathname;
            window.history.pushState({}, '', baseUrl);
        },
        
        shareToFacebook() {
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.shareUrl)}`, '_blank', 'width=600,height=400');
        },
        
        shareToTwitter() {
            window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(this.shareUrl)}&text=${encodeURIComponent(this.shareTitle)}`, '_blank', 'width=600,height=400');
        },
        
        shareToWhatsApp() {
            window.open(`https://wa.me/?text=${encodeURIComponent(this.shareTitle + ' ' + this.shareUrl)}`, '_blank');
        },
        
        shareToTelegram() {
            window.open(`https://t.me/share/url?url=${encodeURIComponent(this.shareUrl)}&text=${encodeURIComponent(this.shareTitle)}`, '_blank');
        },
        
        shareToLinkedIn() {
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(this.shareUrl)}`, '_blank', 'width=600,height=400');
        },
        
        shareToInstagram() {
            this.copyLink();
            setTimeout(() => {
                alert('Link berhasil disalin! Silakan paste di Instagram Story atau Bio Anda.');
            }, 100);
        },
        
        shareToTikTok() {
            this.copyLink();
            setTimeout(() => {
                alert('Link berhasil disalin! Silakan paste di caption TikTok Anda.');
            }, 100);
        },
        
        async copyLink() {
            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(this.shareUrl);
                    this.copied = true;
                    setTimeout(() => { this.copied = false; }, 2000);
                } else {
                    const textArea = document.createElement('textarea');
                    textArea.value = this.shareUrl;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-999999px';
                    textArea.style.top = '-999999px';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        textArea.remove();
                        this.copied = true;
                        setTimeout(() => { this.copied = false; }, 2000);
                    } catch (err) {
                        console.error('Fallback: Gagal menyalin', err);
                        textArea.remove();
                    }
                }
            } catch (err) {
                console.error('Gagal menyalin:', err);
            }
        }
    }">
        <article
            class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <div class="relative aspect-[16/9] overflow-hidden">
                <img src="{{ $imageUrl }}" alt="{{ $title }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />

                <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center"
                    style="display: none;">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-xs text-gray-500">Gambar tidak tersedia</p>
                    </div>
                </div>


                @if (!$isActive)
                    <div class="absolute top-4 left-4">
                        <x-atoms.badge text="Draft" variant="black" />
                    </div>
                @endif
            </div>

            <div class="p-5">
                {{-- Meta: date, author, category --}}
                <div class="flex items-center gap-3 mb-3 text-xs text-gray-500">
                    <span class="flex items-center gap-1">
                        <x-heroicon-o-calendar-days class="w-3.5 h-3.5" />
                        {{ $date }}
                    </span>
                    @if ($author)
                        <span class="flex items-center gap-1">
                            <x-heroicon-o-user class="w-3.5 h-3.5" />
                            {{ $author }}
                        </span>
                    @endif
                </div>

                {{-- Title --}}
                <x-atoms.title :text="$title" size="md"
                    class="mb-2 group-hover:text-lime-600 transition-colors line-clamp-2" />

                {{-- Excerpt --}}
                <x-atoms.description class="mb-4 line-clamp-3 text-gray-600 text-sm leading-relaxed">
                    {{ $excerpt }}
                </x-atoms.description>

                {{-- Stats row: views, likes, category --}}
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    @if($category)
                        <x-atoms.badge :text="$category" :variant="getNewsBadgeVariant($category)" size="sm" />
                    @endif
                    <span class="text-xs text-gray-400 flex items-center gap-1">
                        <x-heroicon-o-eye class="w-3.5 h-3.5" />
                        {{ number_format($berita->views_count ?? 0) }}
                    </span>
                    <span class="text-xs text-gray-400 flex items-center gap-1">
                        <x-heroicon-o-hand-thumb-up class="w-3.5 h-3.5" />
                        {{ number_format($berita->likes_count ?? 0) }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-2">
                    <button @click="openModal()"
                            class="px-4 py-2 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Lihat Sekilas
                    </button>
                    <a href="{{ route('news.detail', $slug) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-lime-600 rounded-lg hover:bg-lime-700 transition-colors shadow-sm">
                        <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
                        Baca Selengkapnya
                    </a>
                </div>

                @if ($showDebug && $slug)
                    <div class="mt-3 p-2 bg-gray-50 rounded text-xs text-gray-400 font-mono">
                        Slug: {{ $slug }}
                    </div>
                @endif
            </div>
        </article>

        <!-- Share Menu Popup -->
        <div x-show="showShareMenu" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.outside="showShareMenu = false"
             class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/50"
             style="display: none;">
            <div class="bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl w-full sm:max-w-md sm:w-full max-h-[85vh] sm:max-h-[90vh] overflow-y-auto">
                <div class="p-5 md:p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-5 md:mb-6">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900">Bagikan Berita</h3>
                        <button @click="showShareMenu = false" 
                                class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-full hover:bg-gray-100 active:bg-gray-200 transition-colors">
                            <x-heroicon-o-x-mark class="w-5 h-5 md:w-6 md:h-6 text-gray-500" />
                        </button>
                    </div>

                    <!-- Share Buttons -->
                    <div class="grid grid-cols-3 gap-2 md:gap-3 mb-5 md:mb-6">
                        <!-- Facebook -->
                        <button @click="shareToFacebook(); showShareMenu = false"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-blue-50 active:bg-blue-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700">Facebook</span>
                        </button>

                        <!-- Twitter/X -->
                        <button @click="shareToTwitter(); showShareMenu = false"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-black rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700">Twitter</span>
                        </button>

                        <!-- WhatsApp -->
                        <button @click="shareToWhatsApp(); showShareMenu = false"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-green-50 active:bg-green-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-green-500 rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700">WhatsApp</span>
                        </button>

                        <!-- Telegram -->
                        <button @click="shareToTelegram(); showShareMenu = false"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-blue-50 active:bg-blue-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700">Telegram</span>
                        </button>

                        <!-- LinkedIn -->
                        <button @click="shareToLinkedIn(); showShareMenu = false"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-blue-50 active:bg-blue-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-700 rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700">LinkedIn</span>
                        </button>

                        <!-- Instagram -->
                        <button @click="shareToInstagram()"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-pink-50 active:bg-pink-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700">Instagram</span>
                        </button>

                        <!-- TikTok -->
                        <button @click="shareToTikTok()"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-black rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700">TikTok</span>
                        </button>

                        <!-- Copy Link -->
                        <button @click="copyLink()"
                            class="flex flex-col items-center gap-2 p-3 md:p-4 rounded-xl hover:bg-lime-50 active:bg-lime-100 transition-colors group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-lime-600 rounded-full flex items-center justify-center group-hover:scale-110 active:scale-95 transition-transform">
                                <x-heroicon-o-link class="w-6 h-6 md:w-7 md:h-7 text-white" x-show="!copied" />
                                <x-heroicon-o-check class="w-6 h-6 md:w-7 md:h-7 text-white" x-show="copied" style="display: none;" />
                            </div>
                            <span class="text-[10px] md:text-xs font-medium text-gray-700" x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                        </button>
                    </div>

                    <!-- URL Display -->
                    <div class="bg-gray-50 rounded-lg p-3 md:p-4">
                        <p class="text-[10px] md:text-xs text-gray-500 mb-1.5 md:mb-2">Link Berita:</p>
                        <p class="text-[10px] md:text-xs text-gray-700 font-mono truncate break-all" x-text="shareUrl"></p>
                    </div>

                    <!-- Close Button for Mobile -->
                    <button @click="showShareMenu = false" 
                            class="mt-4 w-full py-3 bg-gray-100 hover:bg-gray-200 active:bg-gray-300 rounded-xl font-medium text-gray-700 transition-colors sm:hidden">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <x-atoms.modal name="{{ $modalId }}" maxWidth="3xl">
            <div class="relative">
                <img src="{{ $imageUrl }}" alt="{{ $title }}"
                    class="w-full h-64 md:h-80 object-cover"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />

                <div class="w-full h-64 md:h-80 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center"
                    style="display: none;">
                    <div class="text-center">
                        <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-500">Gambar tidak tersedia</p>
                    </div>
                </div>

                @if ($category)
                    <div class="absolute top-4 left-4">
                        <x-atoms.badge :text="$category" :variant="getNewsBadgeVariant($category)" class="shadow-lg" />
                    </div>
                @endif

                <!-- Share Button in Modal -->
                <div class="absolute top-3 right-3 md:top-4 md:right-4 z-20">
                    <button @click="showShareMenu = true"
                        class="px-3 py-2 md:px-4 md:py-2 bg-white/90 backdrop-blur-sm rounded-full flex items-center gap-1.5 md:gap-2 shadow-lg hover:bg-lime-600 hover:text-white transition-all duration-300 group/share active:scale-95">
                        <x-heroicon-o-share class="w-5 h-5 md:w-5 md:h-5 text-lime-600 group-hover/share:text-white" />
                        <span class="text-xs md:text-sm font-medium text-lime-600 group-hover/share:text-white hidden sm:inline">Bagikan</span>
                    </button>
                </div>

                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>

            <div class="p-6 md:p-8">
                <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-calendar-days class="w-4 h-4 text-lime-600" />
                        <span class="font-medium">{{ $date }}</span>
                    </div>

                    @if ($author)
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-user class="w-4 h-4 text-lime-600" />
                            <span class="font-medium">{{ $author }}</span>
                        </div>
                    @endif

                    @if (!$isActive)
                        <x-atoms.badge text="Draft" variant="black" size="sm" />
                    @endif
                </div>

                <x-atoms.title :text="$title" size="2xl" mdSize="3xl"
                    class="mb-6 text-gray-900 leading-tight" />

                <div class="prose max-w-none mb-8">
                    <x-atoms.description class="text-gray-700 leading-relaxed text-justify">
                        {{ $excerpt }}
                    </x-atoms.description>
                </div>

                <a href="{{ route('news.detail', $slug) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-lime-600 text-white font-semibold rounded-xl hover:bg-lime-700 transition-colors shadow-md">
                    <x-heroicon-o-arrow-right class="w-5 h-5" />
                    Baca Selengkapnya
                </a>

                @if ($showDebug)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Debug Info:</h4>
                        <div class="text-xs text-gray-500 space-y-1 font-mono">
                            <div>ID: {{ $id }}</div>
                            <div>Slug: {{ $slug }}</div>
                            <div>Active: {{ $isActive ? 'Yes' : 'No' }}</div>
                            <div>Content Length: {{ strlen($fullContent) }} chars</div>
                        </div>
                    </div>
                @endif
            </div>
        </x-atoms.modal>
    </div>
@else
    <div class="bg-gray-100 rounded-2xl p-6 text-center">
        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
            <x-heroicon-o-document-text class="w-8 h-8 text-gray-400" />
        </div>
        <x-atoms.title text="Berita Tidak Tersedia" size="md" class="text-gray-600 mb-2" />
        <x-atoms.description class="text-gray-500">
            Data berita tidak dapat dimuat
        </x-atoms.description>
    </div>
@endif