<section class="relative w-full h-[60vh] sm:h-[70vh] md:h-[80vh] lg:h-screen max-h-[500px] sm:max-h-[550px] md:max-h-[580px] min-h-[400px] sm:min-h-[450px] overflow-hidden" 
    x-data="{
        imageLoaded: true,
        mounted: false,
        init() {
            this.$nextTick(() => {
                this.mounted = true;
            });
        }
    }"
    x-init="init()">
    
    {{-- Background Image Layer --}}
    <div class="absolute inset-0">
        <picture>
            {{-- Mobile Image (Portrait) --}}
            <source media="(max-width: 768px)"
                    srcset="{{ str_starts_with($heroData['mobileBackgroundImage'], 'http') ? $heroData['mobileBackgroundImage'] : asset('storage/' . $heroData['mobileBackgroundImage']) }}">

            {{-- Desktop Image (Landscape) --}}
            <img src="{{ str_starts_with($heroData['backgroundImage'], 'http') ? $heroData['backgroundImage'] : asset('storage/' . $heroData['backgroundImage']) }}"
                 alt="Taruna Nusantara"
                 class="w-full h-full object-cover object-center transition-all duration-1000"
                 x-bind:class="{
                     'opacity-100 scale-100': imageLoaded,
                     'opacity-0 scale-110': !imageLoaded
                 }"
                 x-on:load="imageLoaded = true" />
        </picture>

        {{-- Gradient Fallback --}}
        <div class="absolute inset-0 bg-gradient-to-br from-lime-800 via-lime-900 to-lime-900 transition-opacity duration-700"
             x-bind:class="{
                 'opacity-0': imageLoaded,
                 'opacity-100': !imageLoaded
             }">
        </div>
    </div>
    
    {{-- Dark Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent sm:from-black/80 sm:via-black/40"></div>
    
    {{-- Content --}}
    <div class="relative z-10 flex items-center justify-start h-full text-white px-4 sm:px-6 md:px-12 lg:px-16">
        <div class="max-w-3xl w-full">
            {{-- Text Content --}}
            <div class="space-y-3 sm:space-y-4 lg:space-y-6" 
                 x-show="mounted" 
                 x-transition:enter="transition ease-out duration-800"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                
                <x-atoms.badge 
                    :text="$heroData['badge']['text']" 
                    :variant="$heroData['badge']['variant']" 
                    size="sm" 
                    class="sm:text-sm" />
                
                <x-atoms.title 
                    :text="$heroData['title']['text']" 
                    :highlight="$heroData['title']['highlight']" 
                    size="3xl" 
                    mdSize="5xl"
                    class="text-white leading-tight lg:text-6xl" />
                
                <x-atoms.description 
                    color="gray-100" 
                    size="sm" 
                    mdSize="lg" 
                    class="leading-relaxed lg:text-xl">
                    {{ $heroData['description'] }}
                </x-atoms.description>
            </div>
            
            {{-- CTA Button --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-4 sm:pt-6 lg:pt-8" 
                 x-show="mounted"
                 x-transition:enter="transition ease-out duration-800 delay-300"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                
                <div class="animate-fade-in-up w-full sm:w-auto" style="animation-delay: 0.4s; animation-fill-mode: both;">
                    <a href="/spmb" class="block">
                        <x-atoms.button 
                            variant="success" 
                            theme="light" 
                            size="md" 
                            heroicon="document-text"
                            iconPosition="left" 
                            rounded="full" 
                            shadow="lg" 
                            :isFullWidth="true"
                            class="group hover:scale-105 transition-all duration-300 sm:px-8">
                            Daftar Sekarang!
                        </x-atoms.button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(60px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
        opacity: 0;
    }
</style>
@endpush