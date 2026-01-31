<section class="py-20 bg-gradient-to-b from-zinc-50 via-lime-50/30 to-white relative overflow-hidden">
    {{-- Artistic Background Elements --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-lime-300/20 rounded-full blur-3xl pointer-events-none opacity-50 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none opacity-50"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16" x-data="{ shown: false }" x-intersect="shown = true">
            <div :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'" class="transition-all duration-700 ease-out">
                <x-atoms.badge
                    text="Eksplorasi Sekolah"
                    variant="lime"
                    size="sm"
                    class="mb-6 shadow-sm ring-1 ring-lime-200/50" />
                
                <h2 class="text-3xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-zinc-900 via-zinc-700 to-zinc-900 mb-6 tracking-tight">
                    Kenali Lebih Dalam <br>
                    <span class="text-lime-600 underline decoration-wavy decoration-lime-300 decoration-2 underline-offset-4">Keunggulan Kami</span>
                </h2>

                <p class="text-zinc-600 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto">
                    Menyelami identitas, visi, dan fasilitas unggulan yang menjadikan kami pilihan terbaik untuk masa depan pendidikan putra-putri Anda.
                </p>
            </div>
        </div>

        {{-- Dynamic Grid Content --}}
        <div class="flex flex-wrap justify-center gap-8">
            @foreach($items as $index => $item)
            <div x-data="{ hover: false }" 
                 @mouseenter="hover = true" 
                 @mouseleave="hover = false"
                 class="group relative bg-white rounded-3xl p-8 transition-all duration-500 hover:-translate-y-2 border border-zinc-100 hover:border-lime-300 shadow-sm hover:shadow-2xl hover:shadow-lime-500/10 w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-2rem)] max-w-lg">
                
                {{-- Card Background Gradient Hover --}}
                <div class="absolute inset-0 bg-gradient-to-br from-lime-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>

                <div class="relative z-10">
                    {{-- Icon Container --}}
                    <div class="mb-8 relative inline-block">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-lime-100 to-emerald-100 text-lime-700 flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-lime-500/20">
                        @switch($item['id'])
                                @case('about')
                                    <!-- Profil Lembaga: Building/Institution -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 21H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5 21V7L13 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M19 21V11L13 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 9V9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 12V12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 15V15.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 18V18.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @break
                                @case('sma')
                                    <!-- SMA: Academic/Book -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 3L1 9L12 15L21 10.09V17H23V9M5 13.18V17.18L12 21L19 17.18V13.18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @break
                                @case('smk')
                                    <!-- SMK: Vocational/Gears -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.325 4.317C10.551 3.543 11.391 3.1 12.155 3.326L12.597 3.456C13.361 3.682 13.804 4.522 13.578 5.286L13.438 5.761C13.687 5.952 13.918 6.166 14.127 6.402L14.568 6.273C15.332 6.047 16.172 6.49 16.398 7.254L16.84 8.751C17.066 9.515 16.623 10.355 15.859 10.581L15.418 10.71C15.485 11.018 15.523 11.34 15.526 11.668L15.983 11.803C16.747 12.029 17.19 12.869 16.964 13.633L16.522 15.13C16.296 15.894 15.456 16.337 14.692 16.111L14.234 15.976C13.918 16.155 13.577 16.299 13.216 16.405L13.356 16.88C13.582 17.644 13.139 18.484 12.375 18.71L10.878 19.151C10.114 19.377 9.274 18.934 9.048 18.17L8.908 17.696C8.659 17.505 8.428 17.291 8.219 17.055L7.778 17.185C7.014 17.411 6.174 16.968 5.948 16.204L5.506 14.707C5.28 13.943 5.723 13.103 6.487 12.877L6.928 12.747C6.861 12.439 6.823 12.117 6.82 11.789L6.363 11.654C5.599 11.428 5.156 10.588 5.382 9.824L5.824 8.327C6.05 7.563 6.89 7.12 7.654 7.346L8.112 7.481C8.428 7.302 8.769 7.158 9.13 7.052L8.99 6.577C8.764 5.813 9.207 4.973 9.971 4.747L11.468 4.306L10.325 4.317ZM11.173 11.233C11.624 12.763 13.253 13.66 14.783 13.209C16.313 12.758 17.21 11.129 16.759 9.599C16.308 8.069 14.679 7.172 13.149 7.623C11.619 8.074 10.722 9.703 11.173 11.233Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @break
                                @case('achievement')
                                    <!-- Prestasi: Trophy -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 21H16M12 17V21M17 4H7C5.89543 4 5 4.89543 5 6V10C5 13.866 8.13401 17 12 17C15.866 17 19 13.866 19 10V6C19 4.89543 18.1046 4 17 4ZM19 6V11C19 11.7652 18.8241 12.4849 18.508 13.122C19.986 12.7369 21.3283 11.597 21.8499 10.1295C22.2533 8.99507 21.9427 7.72895 21.0772 6.86348C20.5284 6.31464 19.7828 6.00287 19 6.0001V6ZM5 6.0001V6C4.21724 6.00287 3.47161 6.31464 2.92283 6.86348C2.05731 7.72895 1.74669 8.99507 2.1501 10.1295C2.67169 11.597 4.014 12.7369 5.49197 13.122C5.17592 12.4849 5 11.7652 5 11V6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @break
                                @case('facility')
                                    <!-- Fasilitas: Building/Amenities -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 21H21M5 21V7L13 3V21M19 21V11L13 7M9 9V9.01M9 12V12.01M9 15V15.01M9 18V18.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @break
                                @case('alumni')
                                    <!-- Alumni: Users/Network -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11ZM12 21V19C12 16.7909 13.7909 15 16 15H8C5.79086 15 4 16.7909 4 19V21M22 13C22 14.1046 21.1046 15 20 15M20 15V21H22V15H20ZM18 7C18 3.68629 15.3137 1 12 1C8.68629 1 6 3.68629 6 7C6 10.3137 8.68629 13 12 13C15.3137 13 18 10.3137 18 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @break
                                @case('ekskul')
                                    <!-- Ekskul: Activity/Star/Ball -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @break
                                @default
                                    <!-- Default fallback -->
                                    <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 4V20M4 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                        @endswitch
                        </div>
                        {{-- Decorative Dot --}}
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-lime-400 rounded-full border-2 border-white animate-bounce-slow"></div>
                    </div>

                    <h3 class="text-2xl font-bold text-zinc-900 mb-4 group-hover:text-lime-700 transition-colors">
                        {{ $item['title'] }}
                    </h3>
                    
                    <p class="text-zinc-500 leading-relaxed mb-8 min-h-[48px]">
                        {{ $item['desc'] }}
                    </p>

                    <a href="{{ $item['url'] }}" 
                       class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-zinc-400 group-hover:text-lime-600 transition-colors pb-1 border-b-2 border-transparent group-hover:border-lime-500">
                        <span>Selengkapnya</span>
                        <x-heroicon-m-arrow-right class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>
            @endforeach
            

        </div>
    </div>

    {{-- Custom Animation Styles (Inline for simplicity, or could be in CSS) --}}
    <style>
        .animate-bounce-slow { animation: bounce 3s infinite; }
        @keyframes bounce {
            0%, 100% { transform: translateY(-5%); }
            50% { transform: translateY(5%); }
        }
    </style>
</section>
