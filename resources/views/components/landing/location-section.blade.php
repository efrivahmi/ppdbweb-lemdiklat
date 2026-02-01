@php
    $settings = \App\Models\Admin\SchoolSetting::getCached();
@endphp

<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-12">
            <x-atoms.badge text="Lokasi Kami" variant="emerald" size="md" class="mb-4" />
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Temukan <span class="text-lime-600">Kami</span>
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kunjungi kami untuk informasi lebih lanjut tentang pendaftaran dan fasilitas sekolah
            </p>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            {{-- Left: Contact Info --}}
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 shadow-sm border border-gray-100">
                {{-- School Name --}}
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ $settings->nama_sekolah ?? 'Lemdiklat Taruna Nusantara Indonesia' }}
                    </h3>
                    <div class="w-16 h-1 bg-gradient-to-r from-lime-500 to-emerald-500 rounded-full"></div>
                </div>

                {{-- Contact Items --}}
                <div class="space-y-6">
                    {{-- Address --}}
                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-lime-100 rounded-xl flex items-center justify-center group-hover:bg-lime-200 transition-colors">
                            <x-lucide-map-pin class="w-6 h-6 text-lime-600" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Alamat</h4>
                            <p class="text-gray-800 leading-relaxed">
                                {{ $settings->alamat ?? 'Alamat belum diatur' }}
                                @if($settings->kode_pos)
                                    <span class="text-gray-500">({{ $settings->kode_pos }})</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-lime-100 rounded-xl flex items-center justify-center group-hover:bg-lime-200 transition-colors">
                            <x-lucide-phone class="w-6 h-6 text-lime-600" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Telepon</h4>
                            @if($settings->telp)
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->telp) }}" 
                                   class="text-gray-800 hover:text-lime-600 transition-colors">
                                    {{ $settings->telp }}
                                </a>
                            @else
                                <p class="text-gray-500">-</p>
                            @endif
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-lime-100 rounded-xl flex items-center justify-center group-hover:bg-lime-200 transition-colors">
                            <x-lucide-mail class="w-6 h-6 text-lime-600" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Email</h4>
                            @if($settings->email)
                                <a href="mailto:{{ $settings->email }}" 
                                   class="text-gray-800 hover:text-lime-600 transition-colors break-all">
                                    {{ $settings->email }}
                                </a>
                            @else
                                <p class="text-gray-500">-</p>
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
                        <div class="pt-4">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Ikuti Kami</h4>
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
                                           class="w-11 h-11 bg-lime-100 rounded-xl flex items-center justify-center text-lime-600 hover:bg-lime-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md"
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
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="https://maps.app.goo.gl/9nfCJS4RFEp6FJCk8" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-lime-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:from-lime-700 hover:to-emerald-700 transition-all hover:shadow-xl">
                        <x-lucide-navigation class="w-5 h-5" />
                        Buka Google Maps
                    </a>
                </div>
            </div>

            {{-- Right: Map --}}
            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-gray-100 min-h-[400px]">
                @if($settings->maps_embed_link)
                    {{-- Google Maps Iframe --}}
                    @php
                        // Extract src from iframe if full tag provided, otherwise use as-is
                        $embedLink = $settings->maps_embed_link;
                        if (preg_match('/src=["\']([^"\']+)["\']/', $embedLink, $matches)) {
                            $embedLink = $matches[1];
                        }
                    @endphp
                    <iframe 
                        src="{{ $embedLink }}"
                        width="100%" 
                        height="100%" 
                        style="border:0; min-height: 400px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full"
                        title="Lokasi {{ $settings->nama_sekolah }}">
                    </iframe>
                @elseif($settings->maps_image_url)
                    {{-- Static Map Image --}}
                    <img src="{{ $settings->maps_image_url }}" 
                         alt="Peta Lokasi {{ $settings->nama_sekolah }}"
                         class="w-full h-full object-cover min-h-[400px]">
                @else
                    {{-- Placeholder --}}
                    <div class="w-full h-full min-h-[400px] flex flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 text-gray-400">
                        <x-lucide-map class="w-16 h-16 mb-4 text-gray-300" />
                        <p class="text-lg font-medium text-gray-500">Peta Belum Tersedia</p>
                        <p class="text-sm text-gray-400 mt-1">Silakan atur di panel admin</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
