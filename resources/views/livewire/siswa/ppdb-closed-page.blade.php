<div class="w-full text-center relative z-10" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
    
    <!-- Mascot Image (Nano Banana) -->
    <div class="flex justify-center mb-8"
         x-show="mounted"
         x-transition:enter="transition-all ease-out duration-700 delay-300"
         x-transition:enter-start="opacity-0 translate-y-12 scale-75"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100">
        <div class="relative">
            <div class="absolute inset-0 bg-lime-400 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-pulse"></div>
            <img src="{{ asset('assets/mascot_3d.png') }}" alt="Mascot" class="w-56 h-56 object-contain drop-shadow-2xl relative z-10 animate-[bounce_3s_infinite]">
        </div>
    </div>

    <!-- Title -->
    <h1 class="text-3xl lg:text-4xl font-black text-gray-900 mb-4 tracking-tight"
        x-show="mounted"
        x-transition:enter="transition-all ease-out duration-700 delay-500"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0">
        Oops! Pendaftaran <span class="text-lime-600">Ditutup</span>
    </h1>
    
    <!-- Description -->
    <p class="text-gray-600 mb-8 font-medium leading-relaxed max-w-md mx-auto"
       x-show="mounted"
       x-transition:enter="transition-all ease-out duration-700 delay-700"
       x-transition:enter-start="opacity-0 translate-y-4"
       x-transition:enter-end="opacity-100 translate-y-0">
        Mohon maaf, sistem Penerimaan Murid Baru saat ini sedang ditutup. 
        Silakan pantau informasi pendaftaran gelombang selanjutnya melalui halaman utama kami.
    </p>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center"
         x-show="mounted"
         x-transition:enter="transition-all ease-out duration-700 delay-1000"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-bold text-white transition-all bg-lime-600 rounded-full hover:bg-lime-700 hover:scale-105 hover:shadow-[0_8px_25px_rgba(132,204,22,0.4)] active:scale-95">
            <x-heroicon-o-home class="w-5 h-5" />
            Kembali ke Beranda
        </a>
    </div>

    <style>
        @keyframes bounce {
            0%, 100% {
                transform: translateY(-5%);
                animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
            }
            50% {
                transform: translateY(0);
                animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
            }
        }
    </style>
</div>
