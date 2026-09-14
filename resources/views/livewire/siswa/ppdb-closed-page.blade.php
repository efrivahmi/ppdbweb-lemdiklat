<div class="w-full h-full flex items-center justify-center relative bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <!-- Decorative background blobs -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-lime-200 rounded-full mix-blend-multiply filter blur-[100px] opacity-50 animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-[100px] opacity-50 animate-pulse" style="animation-delay: 2s;"></div>

    <div class="w-full max-w-2xl text-center relative z-10 p-6 lg:p-12" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <!-- Mascot Image (Nano Banana) -->
        <div class="flex justify-center mb-8"
             x-show="mounted"
             x-transition:enter="transition-all ease-out duration-700 delay-300"
             x-transition:enter-start="opacity-0 translate-y-12 scale-75"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            <div class="relative">
                <div class="absolute inset-0 bg-lime-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
                <img src="{{ asset('assets/mascot_3d.png') }}" alt="Mascot" class="w-56 h-56 object-contain drop-shadow-2xl relative z-10 animate-[bounce_3s_infinite]">
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6 tracking-tight"
            x-show="mounted"
            x-transition:enter="transition-all ease-out duration-700 delay-500"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0">
            Oops! Pendaftaran <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-600 to-emerald-600">Ditutup</span>
        </h1>
        
        <!-- Description -->
        <p class="text-gray-600 mb-10 text-lg font-medium leading-relaxed max-w-lg mx-auto"
           x-show="mounted"
           x-transition:enter="transition-all ease-out duration-700 delay-700"
           x-transition:enter-start="opacity-0 translate-y-4"
           x-transition:enter-end="opacity-100 translate-y-0">
            Mohon maaf, Sistem Penerimaan Murid Baru (SPMB) saat ini sedang ditutup. 
            Silakan pantau informasi pendaftaran gelombang selanjutnya melalui halaman utama kami.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center"
             x-show="mounted"
             x-transition:enter="transition-all ease-out duration-700 delay-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 text-base font-bold text-white transition-all bg-gradient-to-r from-lime-600 to-emerald-600 rounded-full hover:from-lime-500 hover:to-emerald-500 hover:scale-105 hover:shadow-[0_10px_30px_rgba(132,204,22,0.4)] active:scale-95 whitespace-nowrap w-auto">
                <x-heroicon-o-home class="w-5 h-5 flex-shrink-0" />
                <span>Kembali ke Beranda Utama</span>
            </a>
        </div>
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
