{{-- News Detail Page — Left Aligned Header & Sidebar --}}
@php
    if (!function_exists('getNewsBadgeVariant')) {
        function getNewsBadgeVariant($category) {
            switch (strtolower($category)) {
                case 'pendaftaran': return 'emerald';
                case 'prestasi': return 'gold';
                case 'kegiatan': return 'sky';
                case 'pengumuman': return 'danger';
                case 'akademik': return 'light';
                default: return 'emerald';
            }
        }
    }

    $title = $berita->title ?? '';
    $slug = $berita->slug ?? '';
    $content = $berita->content ?? '';
    // Use description hook if available, otherwise truncate content
    $excerpt = $berita->description ?? Str::limit(strip_tags($content), 160);
    $category = $berita->kategori->name ?? '';
    $image = $berita->thumbnail ?? '';
    $imageUrl = $image
        ? (str_starts_with($image, 'http') ? $image : asset('storage/' . $image))
        : '';
    $placeholderImage = 'https://images.unsplash.com/photo-1586776977607-310e9c725c37?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
    $author = $berita->creator->name ?? 'Admin';
    $authorInitial = strtoupper(substr($author, 0, 1));
    $date = $berita->created_at ? $berita->created_at->format('d M Y') : '';
    $readTime = max(1, round(str_word_count(strip_tags($content)) / 200));
    $shareUrl = route('news.detail', $slug);
@endphp

<div class="min-h-screen bg-gray-50/50 font-sans" x-data="{
    showShareMenu: false,
    shareUrl: '{{ $shareUrl }}',
    shareTitle: '{{ addslashes($title) }}',
    shareExcerpt: '{{ addslashes($excerpt) }}',
    copied: false,

    shareToFacebook() {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(this.shareUrl), '_blank', 'width=600,height=400');
    },
    shareToTwitter() {
        const text = this.shareTitle + '\n' + this.shareExcerpt;
        window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(this.shareUrl) + '&text=' + encodeURIComponent(text), '_blank', 'width=600,height=400');
    },
    shareToWhatsApp() {
        const text = `*${this.shareTitle}*\n\n${this.shareExcerpt}\n\n${this.shareUrl}`;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    },
    async shareToTikTok() {
        await this.copyLink();
        window.open('https://www.tiktok.com/', '_blank');
    },
    shareToLinkedIn() {
        window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(this.shareUrl), '_blank', 'width=600,height=600');
    },
    shareToTelegram() {
        window.open('https://t.me/share/url?url=' + encodeURIComponent(this.shareUrl) + '&text=' + encodeURIComponent(this.shareTitle), '_blank');
    },
    shareToLine() {
        window.open('https://social-plugins.line.me/lineit/share?url=' + encodeURIComponent(this.shareUrl), '_blank');
    },
    shareToEmail() {
        window.open('mailto:?subject=' + encodeURIComponent(this.shareTitle) + '&body=' + encodeURIComponent(this.shareTitle + '\n\n' + this.shareExcerpt + '\n\n' + this.shareUrl), '_self');
    },
    async copyLink() {
        try {
            await navigator.clipboard.writeText(this.shareUrl);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        } catch(e) {}
    }
}"><div x-data="{
    showShareMenu: false,
    shareUrl: '{{ $shareUrl }}',
    shareTitle: '{{ addslashes($title) }}',
    shareExcerpt: '{{ addslashes($excerpt) }}',
    copied: false,

    {{-- ==================== HERO SECTION (CLEAN) ==================== --}}
    <div class="relative w-full h-[50vh] min-h-[400px] max-h-[600px] bg-gray-100 overflow-hidden group">
        {{-- Image --}}
        <img src="{{ $imageUrl ?: $placeholderImage }}"
             alt="{{ $title }}"
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
        
        {{-- Fallback --}}
        <div class="absolute inset-0 bg-gray-200 flex items-center justify-center" style="display: none;">
            <x-heroicon-o-photo class="w-16 h-16 text-gray-400" />
        </div>

        {{-- Gradient Overlay (Subtle) --}}
        <div class="absolute inset-0 bg-gradient-to-t from-transparent via-transparent to-black/30 pointer-events-none"></div>

        {{-- Top Navigation --}}
        <div class="absolute top-0 left-0 right-0 p-6 z-20 flex justify-between items-center max-w-7xl mx-auto w-full">
            <a href="{{ route('news') }}" 
               class="group flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-full text-white transition-all border border-white/20 shadow-sm">
                <x-heroicon-o-arrow-left class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
                <span class="text-sm font-medium hidden sm:block">Kembali</span>
            </a>
            
            <button @click="showShareMenu = true" 
                    class="p-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-full text-white transition-all border border-white/20 shadow-sm active:scale-95">
                <x-heroicon-o-share class="w-5 h-5" />
            </button>
        </div>
    </div>

    {{-- ==================== MAIN CONTENT ==================== --}}
    <div class="bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16">
                
                {{-- Left Column: Header & Content --}}
                <article class="lg:col-span-8">
                    
                    {{-- HEADER SECTION (Moved Inside Left Column) --}}
                    <div class="mb-10 text-left">
                        {{-- Badges & Stats --}}
                        <div class="flex items-center gap-3 sm:gap-4 mb-6 flex-wrap">
                            @if($category)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-lime-100 text-lime-700">
                                    {{ $category }}
                                </span>
                            @endif
                            <div class="w-px h-4 bg-gray-300 hidden sm:block"></div>
                            <span class="flex items-center gap-1.5 text-sm font-medium text-gray-500">
                                <x-heroicon-o-calendar-days class="w-4 h-4" />
                                {{ $date }}
                            </span>
                            <div class="w-px h-4 bg-gray-300 hidden sm:block"></div>
                            <span class="flex items-center gap-1.5 text-sm font-medium text-gray-500">
                                <x-heroicon-o-clock class="w-4 h-4" />
                                {{ $readTime }} min baca
                            </span>
                            <span class="flex items-center gap-1.5 text-sm font-medium text-gray-500 ml-2">
                                <x-heroicon-o-eye class="w-4 h-4" />
                                {{ number_format($berita->views_count) }}
                            </span>
                        </div>

                        {{-- Title --}}
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-8 tracking-tight">
                            {{ $title }}
                        </h1>

                        {{-- Author --}}
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm">
                                {{ $authorInitial }}
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-bold text-gray-900">{{ $author }}</p>
                                <p class="text-xs text-gray-500">Penulis Artikel</p>
                            </div>
                        </div>
                    </div>

                    {{-- Typography Content --}}
                    <div class="prose prose-lg md:prose-xl max-w-none 
                        prose-headings:font-bold prose-headings:tracking-tight prose-headings:text-gray-900
                        prose-p:text-gray-600 prose-p:leading-relaxed prose-p:text-justify
                        prose-a:text-lime-600 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:shadow-lg prose-img:my-10 prose-img:w-full
                        prose-blockquote:border-l-4 prose-blockquote:border-lime-500 prose-blockquote:bg-gray-50 prose-blockquote:px-6 prose-blockquote:py-4 prose-blockquote:rounded-r-lg prose-blockquote:not-italic prose-blockquote:text-gray-700
                        prose-ul:marker:text-lime-500 prose-ol:marker:text-lime-500
                        [&_strong]:text-gray-900 [&_strong]:font-bold">
                        @if($content)
                            {!! $content !!}
                        @else
                            <div class="text-center py-20 text-gray-400">
                                <x-heroicon-o-document-text class="w-16 h-16 mx-auto mb-4 opacity-50" />
                                <p class="text-lg">Konten belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Interaction Footer --}}
                    <div class="mt-12 pt-8 border-t border-gray-100">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-semibold text-gray-700">Apakah artikel ini membantu?</span>
                                <div class="flex items-center bg-white rounded-full shadow-sm ring-1 ring-gray-200 p-1">
                                    <button wire:click="toggleLike" 
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all {{ $userReaction === 'like' ? 'bg-lime-100 text-lime-700' : 'text-gray-500 hover:bg-gray-50' }}">
                                        <x-heroicon-o-hand-thumb-up class="w-4 h-4 {{ $userReaction === 'like' ? 'fill-current' : '' }}" />
                                        <span class="text-xs font-bold">{{ number_format($berita->likes_count) }}</span>
                                    </button>
                                    <div class="w-px h-4 bg-gray-200 mx-1"></div>
                                    <button wire:click="toggleDislike" 
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all {{ $userReaction === 'dislike' ? 'bg-red-100 text-red-700' : 'text-gray-500 hover:bg-gray-50' }}">
                                        <x-heroicon-o-hand-thumb-down class="w-4 h-4 {{ $userReaction === 'dislike' ? 'fill-current' : '' }}" />
                                    </button>
                                </div>
                            </div>
                            <button @click="showShareMenu = true" class="text-sm font-bold text-lime-600 hover:text-lime-700 flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-lime-50 transition-colors">
                                <x-heroicon-o-share class="w-4 h-4" />
                                Bagikan Artikel
                            </button>
                        </div>
                    </div>

                    {{-- Comments Section --}}
                    <div class="mt-12 pt-10 border-t border-gray-100" id="comments">
                        <h3 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-2">
                            Komentar <span class="bg-gray-100 text-gray-600 text-sm py-0.5 px-2 rounded-full">{{ $comments->count() }}</span>
                        </h3>

                        {{-- Comment Form --}}
                        <div class="mb-10 bg-gray-50 rounded-2xl p-6 md:p-8">
                            @if($commentSubmitted)
                                <div class="flex flex-col items-center justify-center text-center py-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3 text-green-600">
                                        <x-heroicon-o-check class="w-6 h-6" />
                                    </div>
                                    <h4 class="font-bold text-gray-900">Terkirim!</h4>
                                    <p class="text-sm text-gray-500 mt-1">Komentar menunggu moderasi admin.</p>
                                </div>
                            @else
                                <form wire:submit.prevent="submitComment" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                                            <input type="text" wire:model="commentName" id="name" placeholder="Nama Anda"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-lime-500 focus:ring-2 focus:ring-lime-200 outline-none transition-all">
                                            @error('commentName') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Komentar</label>
                                        <textarea wire:model="commentMessage" id="message" rows="3" placeholder="Tulis komentar..."
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-lime-500 focus:ring-2 focus:ring-lime-200 outline-none transition-all resize-none"></textarea>
                                        @error('commentMessage') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-colors shadow-lg shadow-gray-900/10 active:scale-95">
                                            Kirim Komentar
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>

                        {{-- Comment List --}}
                        <div class="space-y-6">
                            @forelse($comments as $comment)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-sm border border-gray-200">
                                            {{ strtoupper(substr($comment->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h5 class="font-bold text-gray-900 text-sm">{{ $comment->name }}</h5>
                                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $comment->message }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-center text-sm py-4">Belum ada komentar.</p>
                            @endforelse
                        </div>
                    </div>
                </article>

                {{-- Right Column: Sidebar --}}
                <aside class="lg:col-span-4 space-y-8">
                    
                    {{-- Related News Widget (Only if exists) --}}
                    @if(isset($relatedNews) && $relatedNews->count() > 0)
                        <div class="bg-gray-50 rounded-2xl p-6 md:p-8 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200/60 flex items-center justify-between">
                                <span>Berita Terkait</span>
                                <a href="{{ route('news') }}" class="text-xs font-semibold text-lime-600 hover:text-lime-700">Lihat Semua</a>
                            </h3>
                            <div class="space-y-6">
                                @foreach($relatedNews as $news)
                                    <a href="{{ route('news.detail', $news->slug) }}" class="group flex gap-4 items-start">
                                        <div class="flex-shrink-0 relative w-20 h-20 rounded-xl overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5">
                                            @if($news->thumbnail)
                                                <img src="{{ str_starts_with($news->thumbnail, 'http') ? $news->thumbnail : asset('storage/' . $news->thumbnail) }}" 
                                                     alt="{{ $news->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                                    <x-heroicon-o-photo class="w-8 h-8" />
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 py-1">
                                            <div class="flex items-center gap-2 mb-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-lime-500"></span>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $news->created_at->format('d M Y') }}</p>
                                            </div>
                                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-lime-600 line-clamp-2 leading-snug transition-colors">
                                                {{ $news->title }}
                                            </h4>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Latest News Widget (Always show) --}}
                    <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm ring-1 ring-gray-900/5">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">
                            Berita Terbaru
                        </h3>
                        <div class="space-y-6">
                            @foreach($latestNews as $news)
                                <a href="{{ route('news.detail', $news->slug) }}" class="group block">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-heroicon-o-calendar-days class="w-3.5 h-3.5 text-gray-400" />
                                        <span class="text-xs text-gray-500">{{ $news->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-lime-600 line-clamp-2 leading-snug transition-colors mb-2">
                                        {{ $news->title }}
                                    </h4>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-50 text-center">
                            <a href="{{ route('news') }}" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                                Indeks Berita
                            </a>
                        </div>
                    </div>

                    {{-- Categories Widget --}}
                    <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm ring-1 ring-gray-900/5">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">
                            Kategori
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($categories as $cat)
                                <a href="{{ route('news', ['category' => $cat->slug ?? $cat->id]) }}" 
                                   class="inline-flex items-center justify-between px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-lime-50 text-xs font-medium text-gray-600 hover:text-lime-700 border border-gray-200 hover:border-lime-200 transition-all group">
                                    <span>{{ $cat->name }}</span>
                                    <span class="ml-2 bg-gray-200 group-hover:bg-lime-200 text-gray-500 group-hover:text-lime-700 py-0.5 px-1.5 rounded-md text-[10px]">
                                        {{ $cat->beritas_count }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </aside>

            </div>
        </div>
    </div>

    {{-- Share Menu Popup (Same as before) --}}
    <div x-show="showShareMenu" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center p-0 sm:p-4 bg-gray-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.outside="showShareMenu = false">
        
        <div class="bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl w-full sm:max-w-md p-6 sm:p-8 transform transition-all"
             x-show="showShareMenu"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full sm:translate-y-10 sm:scale-95 opacity-0"
             x-transition:enter-end="translate-y-0 sm:scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 sm:scale-100 opacity-100"
             x-transition:leave-end="translate-y-full sm:translate-y-10 sm:scale-95 opacity-0">
            
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-gray-900">Bagikan Berita</h3>
                <button @click="showShareMenu = false" class="p-2 -mr-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                {{-- Facebook --}}
                <button @click="shareToFacebook()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-blue-50 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">Facebook</span>
                </button>

                {{-- Twitter --}}
                <button @click="shareToTwitter()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-gray-100 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center shadow-lg shadow-black/30 group-hover:scale-110 transition-transform">
                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">X (Twitter)</span>
                </button>

                {{-- WhatsApp --}}
                <button @click="shareToWhatsApp()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-green-50 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">WhatsApp</span>
                </button>

                {{-- TikTok --}}
                <button @click="shareToTikTok()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-gray-100 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center shadow-lg shadow-black/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.65-1.62-1.1-.01.95-.02 1.91-.03 2.87 0 2.38-.28 4.79-1.25 6.99-2.14 4.14-7.05 5.83-11.23 3.93-3.15-1.41-5.17-4.57-5.07-8.02.02-3.14 2.15-5.91 5.16-6.79.79-.23 1.61-.31 2.43-.28v4.2c-1.52.12-2.86 1.25-3.16 2.76-.32 1.57.51 3.23 2.01 3.92 1.94.94 4.31-.01 5.06-2.02.24-1.13.25-2.31.22-3.48V.02z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">TikTok</span>
                </button>

                {{-- LinkedIn --}}
                <button @click="shareToLinkedIn()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-blue-50 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-[#0077b5] text-white flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">LinkedIn</span>
                </button>

                {{-- Telegram --}}
                <button @click="shareToTelegram()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-sky-50 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-[#229ED9] text-white flex items-center justify-center shadow-lg shadow-sky-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">Telegram</span>
                </button>

                {{-- Line --}}
                <button @click="shareToLine()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-green-50 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-[#00C300] text-white flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.629-.285-.629-.629V8.108c0-.345.284-.63.629-.63.347 0 .628.285.628.63v4.145h2.388c.346 0 .626.285.626.63 0 .344-.28.629-.626.629z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">Line</span>
                </button>

                {{-- Email --}}
                <button @click="shareToEmail()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-gray-50 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-gray-600 text-white flex items-center justify-center shadow-lg shadow-gray-600/30 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-envelope class="w-6 h-6" />
                    </div>
                    <span class="text-xs font-semibold text-gray-600">Email</span>
                </button>

                {{-- Copy Link --}}
                <button @click="copyLink()" class="flex flex-col items-center gap-3 p-4 rounded-2xl hover:bg-lime-50 group transition-colors">
                    <div class="w-12 h-12 rounded-full bg-lime-500 text-white flex items-center justify-center shadow-lg shadow-lime-500/30 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-link class="w-6 h-6" x-show="!copied" />
                        <x-heroicon-o-check class="w-6 h-6" x-show="copied" style="display:none;" />
                    </div>
                    <span class="text-xs font-semibold text-gray-600" x-text="copied ? 'Disalin' : 'Salin Link'"></span>
                </button>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <button @click="showShareMenu = false" class="text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">
                    Batalkan
                </button>
            </div>
        </div>
    </div>
</div>
