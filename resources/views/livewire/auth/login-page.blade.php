<div class="w-full relative" 
     x-data="{ errorMessage: '', capslockOn: false, mounted: false }" 
     x-init="setTimeout(() => mounted = true, 50)"
     x-on:error.window="errorMessage = $event.detail.message"
     @keydown.window="capslockOn = $event.getModifierState('CapsLock')"
     @keyup.window="capslockOn = $event.getModifierState('CapsLock')">

    <!-- Decorative Animated Blobs -->
    <div class="absolute -top-10 -left-10 w-64 h-64 bg-lime-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"
         x-show="mounted" x-transition:enter="transition-opacity duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-40"></div>
    <div class="absolute -top-10 -right-10 w-64 h-64 bg-emerald-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"
         x-show="mounted" x-transition:enter="transition-opacity duration-1000 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-40"></div>
    <div class="absolute -bottom-10 left-16 w-64 h-64 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000"
         x-show="mounted" x-transition:enter="transition-opacity duration-1000 delay-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-40"></div>

    <!-- Floating SVG Text Outside Container -->
    <div class="mb-8 flex flex-col items-center justify-center text-center relative z-20"
         x-show="mounted"
         x-transition:enter="transition-all ease-out duration-1000 delay-100"
         x-transition:enter-start="opacity-0 -translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0">
         
         <svg class="w-full max-w-[320px] h-16 overflow-visible" viewBox="0 0 320 60">
             <defs>
                 <linearGradient id="textGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                     <stop offset="0%" stop-color="#4d7c0f" />
                     <stop offset="50%" stop-color="#84cc16" />
                     <stop offset="100%" stop-color="#10b981" />
                 </linearGradient>
             </defs>
             <text x="50%" y="45" font-family="system-ui, -apple-system, sans-serif" font-weight="900" font-size="42" text-anchor="middle"
                   fill="transparent" stroke="url(#textGrad)" stroke-width="1.5"
                   class="animate-svg-text drop-shadow-md">
                 Selamat Datang
             </text>
         </svg>
         <p class="text-gray-500 mt-2 text-sm font-medium">Gunakan Email/NISN & Password yang terdaftar untuk masuk</p>
    </div>

    <!-- Main Glass Card -->
    <div class="bg-white border border-white/60 shadow-[0_20px_40px_rgb(0,0,0,0.08)] rounded-[2.5rem] p-8 lg:p-10 relative z-10"
         x-show="mounted"
         x-transition:enter="transition-all ease-out duration-700 delay-300"
         x-transition:enter-start="opacity-0 translate-y-12 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100">



      <!-- Alert Error -->
      <template x-if="errorMessage">
        <div class="bg-red-500/10 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl text-sm font-medium mb-6 flex items-center gap-3 animate-slide-in-right">
          <i class="ri-error-warning-fill text-xl text-red-500"></i>
          <span x-text="errorMessage"></span>
        </div>
      </template>

      <!-- Capslock Warning -->
      <div x-show="capslockOn" style="display: none;" 
           class="mb-6 flex items-center gap-3 text-amber-700 bg-amber-500/10 p-4 rounded-xl border border-amber-500/20 text-sm font-medium"
           x-transition:enter="transition-all ease-out duration-300"
           x-transition:enter-start="opacity-0 -translate-y-2"
           x-transition:enter-end="opacity-100 translate-y-0">
          <i class="ri-error-warning-fill text-xl text-amber-500 animate-pulse"></i>
          <span>Peringatan: Caps Lock Anda sedang aktif!</span>
      </div>

      <form class="space-y-5" wire:submit.prevent="login"
            x-show="mounted"
            x-transition:enter="transition-all ease-out duration-700 delay-400"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0">
        
        <div class="relative">
          <x-molecules.input-field label="Email atau NISN" inputType="text" name="credentials" id="credentials"
            placeholder="Masukkan email atau NISN Anda" wire:model.defer="credentials"
            :error="$errors->first('credentials')" required />
        </div>

        <div class="relative">
          <x-molecules.input-field label="Kata Sandi" inputType="password" name="password" id="password"
            placeholder="Masukkan kata sandi Anda" wire:model.defer="password" :error="$errors->first('password')"
            required />
        </div>

        <div class="pt-2">
          <x-atoms.button type="submit" variant="success" size="lg" isFullWidth="true" rounded="full"
            shadow="lg" heroicon="arrow-right-on-rectangle"
            class="relative overflow-hidden group transform transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_8px_25px_rgba(132,204,22,0.4)] active:scale-[0.98]">
            <span class="relative z-10 flex items-center justify-center gap-2 font-bold tracking-wide">
              Masuk
            </span>
            <!-- Button hover highlight effect -->
            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-shimmer z-0"></div>
          </x-atoms.button>
        </div>
      </form>

      <div class="flex items-center my-6"
           x-show="mounted"
           x-transition:enter="transition-opacity duration-700 delay-500"
           x-transition:enter-start="opacity-0"
           x-transition:enter-end="opacity-100">
        <div class="flex-1 border-t border-gray-200/60"></div>
        <span class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">atau</span>
        <div class="flex-1 border-t border-gray-200/60"></div>
      </div>

      <div class="text-center space-y-4"
           x-show="mounted"
           x-transition:enter="transition-all ease-out duration-700 delay-600"
           x-transition:enter-start="opacity-0 translate-y-4"
           x-transition:enter-end="opacity-100 translate-y-0">
        
        <x-atoms.description align="center" color="gray-600" size="sm" class="font-medium">
          Belum memiliki akun?
          <a href="{{ route('register') }}"
            class="inline-block mt-1 font-bold text-lime-600 hover:text-lime-700 relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-lime-600 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left transition-colors">
            Daftar Sekarang
          </a>
        </x-atoms.description>

        <x-atoms.description align="center" color="gray-400" size="sm">
          <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 hover:text-gray-700 transition-colors duration-300 group">
            <x-heroicon-o-arrow-left class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300" />
            Kembali ke Home
          </a>
        </x-atoms.description>
      </div>

    </div>

    <style>
      /* SVG Text Drawing Animation */
      @keyframes draw-text {
        0% { stroke-dashoffset: 600; fill: transparent; stroke-width: 1.5px; }
        60% { stroke-dashoffset: 0; fill: transparent; stroke-width: 1.5px; }
        100% { stroke-dashoffset: 0; fill: url(#textGrad); stroke-width: 0.5px; }
      }
      .animate-svg-text {
        stroke-dasharray: 600;
        stroke-dashoffset: 600;
        animation: draw-text 3.5s ease-in-out forwards;
        animation-delay: 0.2s;
      }

      /* Life-like Dynamic Animations */

      /* Blob Animation */
      @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(20px, -30px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
      }
      .animate-blob {
        animation: blob 7s infinite;
      }
      .animation-delay-2000 {
        animation-delay: 2s;
      }
      .animation-delay-4000 {
        animation-delay: 4s;
      }

      /* Shimmer Effect for Button */
      @keyframes shimmer {
        100% { transform: translateX(100%); }
      }
      .animate-shimmer {
        animation: shimmer 2s infinite;
      }

      /* Slide in for Alerts */
      @keyframes slide-in-right {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
      }
      .animate-slide-in-right {
        animation: slide-in-right 0.4s ease-out forwards;
      }


    </style>
</div>