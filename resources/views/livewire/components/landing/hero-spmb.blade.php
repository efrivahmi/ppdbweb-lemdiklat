<section 
    class="relative w-screen h-[calc(100vh-5rem)] overflow-hidden"
    x-data="{
        imageLoaded: true,
        mounted: false,
        hasError: false,
        init() {
            this.$nextTick(() => this.mounted = true)
        }
    }"
    x-init="init()"
>
    {{-- Background Image Layer --}}
    <div class="relative w-full h-full flex justify-center">
        @if($heroData['backgroundImage'])
            <img 
                src="{{ asset('storage/' . $heroData['backgroundImage']) }}" 
                alt="Taruna Nusantara"
                class="w-full h-full object-cover object-center transition-all duration-1000"
                x-bind:class="{
                    'opacity-100 scale-100': imageLoaded && !hasError,
                    'opacity-0 scale-110': !imageLoaded || hasError
                }"
                x-on:load="imageLoaded = true"
                x-on:error="hasError = true; imageLoaded = false" 
            />
        @endif
        
        {{-- Gradient Fallback --}}
        <div 
            class="absolute inset-0 bg-gradient-to-br from-lime-800 via-lime-900 to-lime-900 transition-opacity duration-700"
            x-bind:class="{
                'opacity-0': imageLoaded && !hasError && @js($heroData['backgroundImage'] !== null),
                'opacity-100': !imageLoaded || hasError || @js($heroData['backgroundImage'] === null)
            }">
        </div>
    </div>

    {{-- Dark Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent sm:from-black/80 sm:via-black/40"></div>
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

    /* gambar proporsional dan full lebar */
    section img {
        width: 100%;
        height: auto;
        object-fit: contain;
        object-position: center;
        display: block;
    }

    /* untuk jaga di mobile biar nggak kepotong */
    @media (max-width: 640px) {
        section {
            width: 100vw;
        }
    }
</style>
@endpush
