<footer>
    @if($footerData)
    <div class="w-full bg-gradient-to-r from-lime-900 to-lime-500 shadow-md p-8 md:p-12 space-y-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-10">
            {{-- Brand Section --}}
            <div class="flex-1 max-w-md">
                <div class="mb-4">
                    <x-atoms.title :text="$footerData->site_title" color="white" class="text-xl font-semibold"/>
                </div>
                <x-atoms.description color="white" class="text-sm leading-relaxed mb-5">
                    {{ $footerData->site_description }}
                </x-atoms.description>
                
                <div class="flex space-x-3">
                    @foreach ($footerData->social_icons as $social)
                        <a href="{{ $social['href'] }}" target="_blank"
                           class="text-white hover:text-lime-200 hover:bg-white/10 p-2 rounded-lg transition-all duration-300"
                           aria-label="Follow us on {{ $social['label'] }}">
                            @switch($social['icon'])
                                @case('twitter')
                                    <x-lucide-twitter class="w-5 h-5"/>
                                    @break
                                @case('instagram')
                                    <x-lucide-instagram class="w-5 h-5"/>
                                    @break
                                @case('youtube')
                                    <x-lucide-youtube class="w-5 h-5"/>
                                    @break
                                @case('facebook')
                                    <x-lucide-facebook class="w-5 h-5"/>
                                    @break
                                @default
                                    <x-heroicon-o-link class="w-5 h-5"/>
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-3 gap-10">
                @foreach ($footerData->footer_links as $section)
                    <div>
                        <h4 class="text-white font-semibold text-sm mb-4">{{ $section['title'] }}</h4>
                        <ul class="space-y-3">
                            @foreach ($section['links'] as $link)
                                <li>
                                    <a href="{{ $link['href'] }}" class="text-sm text-white hover:text-lime-200 transition duration-200 block">
                                        {{ $link['text'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="border-t border-white/20 pt-6 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <p class="text-xs text-white/80">
                {{ $footerData->formatted_copyright }}
            </p>
            <div class="flex flex-wrap gap-4">
                @foreach ($footerData->legal_links as $link)
                    <a href="{{ $link['href'] }}" class="text-xs text-white/80 hover:text-white transition duration-200">
                        {{ $link['text'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @else
    {{-- Fallback jika data footer tidak tersedia --}}
    <div class="w-full bg-gradient-to-r from-lime-900 to-lime-500 shadow-md p-8 md:p-12">
        <div class="text-center text-white">
            <x-atoms.title text="Lemdiklat Taruna Nusantara Indonesia" class="text-white text-xl font-semibold mb-4" align="center"/>
            <x-atoms.description class="text-white/80 text-sm">
                Footer sedang dalam pemeliharaan. Silakan hubungi administrator.
            </x-atoms.description>
        </div>
    </div>
    @endif
</footer>