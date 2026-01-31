@php
    $settings = \App\Models\Admin\SchoolSetting::getCached();
@endphp

<section class="py-20 bg-gradient-to-br from-zinc-50 via-lime-50/50 to-white relative overflow-hidden" x-data="{ shown: false }" x-intersect.once="shown = true">
    {{-- Artistic Background Elements --}}
    <div class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 bg-lime-300/20 rounded-full blur-3xl pointer-events-none opacity-50 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none opacity-50"></div>
    <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(#84cc16_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        {{-- Section Header --}}
        <div class="text-center mb-16 transition-all duration-700 delay-100 ease-out transform"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <x-atoms.badge
                text="Lokasi Kami"
                variant="lime"
                size="sm"
                class="mb-6 shadow-sm ring-1 ring-lime-200/50" />
            
            <h2 class="text-3xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-zinc-900 via-zinc-700 to-zinc-900 mb-6 tracking-tight">
                Temukan <span class="text-lime-600 underline decoration-wavy decoration-lime-300 decoration-2 underline-offset-4">Kami</span>
            </h2>
            
            <p class="text-zinc-600 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto">
                Kunjungi kampus asri kami yang dirancang untuk mendukung pembelajaran holistik dan pembentukan karakter pemimpin masa depan.
            </p>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
            {{-- Left: Contact Info Card --}}
            <div class="relative group bg-white/80 backdrop-blur-xl rounded-3xl p-8 lg:p-10 shadow-xl border border-white/50 hover:border-lime-300 transition-all duration-500 delay-200 ease-out transform hover:-translate-y-1"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                
                {{-- Decorative Gradient Border --}}
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-lime-400 via-emerald-400 to-lime-400 rounded-t-3xl opacity-80"></div>

                {{-- School Name --}}
                <div class="mb-10 relative">
                    <h3 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4 leading-tight">
                        {{ $settings->nama_sekolah ?? 'Lemdiklat Taruna Nusantara Indonesia' }}
                    </h3>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-lime-500 to-emerald-500 rounded-full shadow-sm"></div>
                </div>

                {{-- Contact Items --}}
                <div class="space-y-8">
                    {{-- Address --}}
                    <div class="flex items-start gap-5 group/item">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-lime-100 to-emerald-50 rounded-2xl flex items-center justify-center group-hover/item:scale-110 transition-transform duration-300 shadow-sm text-lime-600">
                            <x-lucide-map-pin class="w-7 h-7" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-zinc-400 uppercase tracking-widest mb-1">Alamat Kampus</h4>
                            <p class="text-zinc-700 text-lg leading-relaxed font-medium">
                                {{ $settings->alamat ?? 'Alamat belum diatur' }}
                                @if($settings->kode_pos)
                                    <span class="text-zinc-500">({{ $settings->kode_pos }})</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-start gap-5 group/item">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-lime-100 to-emerald-50 rounded-2xl flex items-center justify-center group-hover/item:scale-110 transition-transform duration-300 shadow-sm text-lime-600">
                            <x-lucide-phone class="w-7 h-7" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-zinc-400 uppercase tracking-widest mb-1">Telepon Resmi</h4>
                            @if($settings->telp)
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->telp) }}" 
                                   class="text-zinc-800 text-lg font-medium hover:text-lime-600 transition-colors inline-block relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-lime-500 after:transition-all hover:after:w-full">
                                    {{ $settings->telp }}
                                </a>
                            @else
                                <p class="text-zinc-400 text-lg">-</p>
                            @endif
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-5 group/item">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-lime-100 to-emerald-50 rounded-2xl flex items-center justify-center group-hover/item:scale-110 transition-transform duration-300 shadow-sm text-lime-600">
                            <x-lucide-mail class="w-7 h-7" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-zinc-400 uppercase tracking-widest mb-1">Email Informasi</h4>
                            @if($settings->email)
                                <a href="mailto:{{ $settings->email }}" 
                                   class="text-zinc-800 text-lg font-medium hover:text-lime-600 transition-colors inline-block relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-lime-500 after:transition-all hover:after:w-full">
                                    {{ $settings->email }}
                                </a>
                            @else
                                <p class="text-zinc-400 text-lg">-</p>
                            @endif
                        </div>
                    </div>

                    {{-- Social Media Links --}}
                    @php
                        $socialLinks = $settings->social_links ?? [];
                        $platformIcons = [
                            'website' => 'lucide-globe',
                            'facebook' => 'lucide-facebook',
                            'instagram' => 'lucide-instagram',
                            'twitter' => 'lucide-twitter',
                            'youtube' => 'lucide-youtube',
                            'tiktok' => 'lucide-music-2',
                            'whatsapp' => 'lucide-message-circle',
                            'linkedin' => 'lucide-linkedin',
                        ];
                    @endphp
                    @if(count($socialLinks) > 0)
                        <div class="pt-6 border-t border-zinc-100">
                            <h4 class="text-sm font-bold text-zinc-400 uppercase tracking-widest mb-4">Ikuti Perjalanan Kami</h4>
                            <div class="flex flex-wrap gap-3">
                                @foreach($socialLinks as $link)
                                    @if(!empty($link['url']))
                                        @php
                                            $platform = $link['platform'] ?? 'website';
                                            $iconName = $platformIcons[$platform] ?? 'lucide-link';
                                        @endphp
                                        <a href="{{ $link['url'] }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="w-12 h-12 bg-white border border-zinc-200 rounded-xl flex items-center justify-center text-zinc-500 hover:bg-gradient-to-br hover:from-lime-500 hover:to-emerald-600 hover:text-white hover:border-transparent hover:scale-110 hover:-rotate-6 transition-all duration-300 shadow-sm hover:shadow-lg"
                                           title="{{ ucfirst($platform) }}">
                                            <x-dynamic-component :component="$iconName" class="w-5 h-5" />
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- CTA Button --}}
                <div class="mt-10">
                    <a href="https://maps.app.goo.gl/9nfCJS4RFEp6FJCk8" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="group/btn w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-zinc-900 to-zinc-800 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl hover:shadow-lime-900/20 hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                        {{-- Button Shine Effect --}}
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/btn:animate-[shimmer_1.5s_infinite]"></div>
                        
                        <x-lucide-map class="w-6 h-6 text-lime-400 group-hover/btn:scale-110 transition-transform" />
                        <span>Buka Google Maps</span>
                        <x-lucide-arrow-up-right class="w-5 h-5 text-zinc-500 group-hover/btn:text-white transition-colors" />
                    </a>
                </div>
            </div>

            {{-- Right: Map Card (Artistic Frame) --}}
            <div class="relative group h-full min-h-[500px] transition-all duration-700 delay-300 ease-out transform pointer-events-none lg:pointer-events-auto"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                
                {{-- Abstract Frame Elements --}}
                <div class="absolute -inset-4 bg-gradient-to-tr from-lime-200 to-emerald-200 rounded-[2.5rem] opacity-30 blur-2xl group-hover:opacity-50 transition-opacity duration-700"></div>
                <div class="absolute inset-0 bg-white rounded-[2rem] shadow-2xl overflow-hidden frame-mask border-4 border-white">
                    @if($settings->maps_embed_link)
                        {{-- Google Maps Iframe --}}
                        @php
                            $embedLink = $settings->maps_embed_link;
                            if (preg_match('/src=["\']([^"\']+)["\']/', $embedLink, $matches)) {
                                $embedLink = $matches[1];
                            }
                        @endphp
                        <iframe 
                            src="{{ $embedLink }}"
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-full grayscale hover:grayscale-0 transition-all duration-700 scale-105 hover:scale-100"
                            title="Lokasi {{ $settings->nama_sekolah }}">
                        </iframe>
                    @elseif($settings->maps_image_url)
                        <img src="{{ $settings->maps_image_url }}" 
                             alt="Peta Lokasi {{ $settings->nama_sekolah }}"
                             class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-zinc-100 text-zinc-400 pattern-grid-lg">
                            <x-lucide-map class="w-20 h-20 mb-6 text-zinc-300" />
                            <p class="text-xl font-bold text-zinc-500">Peta Belum Tersedia</p>
                        </div>
                    @endif
                    
                    {{-- Overlay Gradient --}}
                    <div class="absolute inset-0 pointer-events-none shadow-[inset_0_0_100px_rgba(0,0,0,0.1)]"></div>
                </div>

                {{-- Floating Badge --}}
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-zinc-100 flex items-center gap-4 animate-bounce-slow max-w-xs">
                    <div class="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center text-3xl">📍</div>
                    <div>
                        <p class="text-xs text-zinc-400 font-bold uppercase tracking-wider">Lokasi Strategis</p>
                        <p class="text-sm font-semibold text-zinc-800">Dekat Pusat Kota</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
