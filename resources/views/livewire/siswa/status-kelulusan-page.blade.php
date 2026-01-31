<div class="min-h-screen -m-6 flex items-center justify-center p-6 relative overflow-hidden bg-gray-50 font-sans">
    
    <!-- Sophisticated Background -->
    <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-50"></div>
    <div class="absolute inset-0 bg-gradient-to-tr from-blue-50/40 via-purple-50/40 to-pink-50/40"></div>

    <!-- Main Container -->
    <div x-data="{ open: @entangle('isOpen') }" class="relative z-10 w-full max-w-lg perspective-[2000px]">
        
        <!-- ENVELOPE (Closed) -->
        <div x-show="!open" 
             @click="$wire.toggleOpen()"
             class="cursor-pointer group relative transform transition-all duration-700 hover:scale-[1.02] hover:-translate-y-2"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 rotate-x-0 translate-y-0"
             x-transition:leave-end="opacity-0 rotate-x-90 translate-y-20">
            
            <!-- Envelope Body -->
            <div class="relative bg-gradient-to-b from-amber-100 to-amber-200 rounded-xl shadow-2xl border border-amber-200/50 overflow-hidden">
                <!-- Texture -->
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%239C92AC\' fill-opacity=\'0.1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
                
                <!-- Flap (Visual) -->
                <div class="absolute top-0 left-0 right-0 h-48 bg-gradient-to-b from-amber-300 via-amber-200 to-transparent clip-path-polygon-[0%_0%,50%_100%,100%_0%] shadow-lg z-20" style="clip-path: polygon(0 0, 50% 100%, 100% 0);"></div>

                <div class="relative z-10 p-12 text-center space-y-8 mt-20">
                    <!-- Premium Badge -->
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white shadow-xl ring-4 ring-amber-100/50 mx-auto">
                        <img src="{{ asset('assets/logo.png') }}" class="w-12 h-12 object-contain">
                    </div>

                    <div class="space-y-3">
                        <h2 class="text-3xl font-serif font-bold text-amber-950 tracking-tight">Hasil Seleksi</h2>
                        <p class="text-amber-800/80 font-medium tracking-wide text-xs uppercase letter-spacing-2">Penerimaan Peserta Didik Baru</p>
                    </div>
                    
                    <div class="pt-8 pb-4">
                        <button class="px-8 py-3 bg-amber-950 text-amber-50 rounded-full text-sm font-medium shadow-lg hover:bg-amber-900 transition-colors flex items-center gap-2 mx-auto ring-2 ring-white/20">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                            </span>
                            Ketuk untuk Membuka
                        </button>
                    </div>
                </div>

                <!-- Seal -->
                <div class="absolute top-[35%] left-1/2 -translate-x-1/2 -translate-y-1/2 z-30">
                    <div class="w-24 h-24 bg-red-800 rounded-full shadow-2xl flex items-center justify-center border-4 border-red-700/50 relative group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 border border-white/20 rounded-full m-1 dashed"></div>
                        <span class="font-serif text-3xl font-bold text-white/90 tracking-tighter drop-shadow-md">TN</span>
                    </div>
                </div>
            </div>
            
            <!-- Shadow Depth -->
            <div class="absolute -bottom-10 left-10 right-10 h-10 bg-black/20 blur-2xl rounded-full"></div>
        </div>


        <!-- LETTER (Opened) -->
        <div x-show="open" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-1000 delay-300"
             x-transition:enter-start="opacity-0 translate-y-20 scale-95 rotate-x-10"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100 rotate-x-0"
             class="bg-white rounded-2xl shadow-2xl overflow-hidden relative border border-gray-100 max-w-lg mx-auto">
            
            <!-- Confetti Canvas -->
            @if($status === 'diterima')
            <canvas id="confetti" class="absolute inset-0 pointer-events-none z-0"></canvas>
            @endif

            <!-- Letterhead -->
            <div class="bg-gray-50/50 border-b border-gray-100 p-8 text-center relative z-10">
                <div class="absolute top-4 right-4">
                     <button wire:click="toggleOpen" class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-full">
                        <i class="ri-close-line text-xl"></i>
                     </button>
                </div>
                <img src="{{ asset('assets/logo.png') }}" class="w-16 h-16 mx-auto mb-4 drop-shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">LEMDIKLAT TARUNA NUSANTARA</h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Surat Keputusan Resmi</p>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-8 relative z-10">
                <div class="text-center space-y-2">
                    <p class="text-gray-500 text-sm font-medium">Kepada Yth. Calon Siswa</p>
                    <h4 class="text-xl font-bold text-gray-900">{{ $user->name }}</h4>
                </div>
                
                <!-- Status Display -->
                <div class="flex justify-center">
                    @if($status === 'diterima')
                        <div class="bg-gradient-to-b from-green-50 to-white border border-green-100 rounded-2xl p-6 text-center w-full relative overflow-hidden shadow-sm">
                            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-100 rounded-full opacity-50 blur-2xl"></div>
                             <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-green-100 rounded-full opacity-50 blur-2xl"></div>
                            
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-green-100">
                                <i class="ri-checkbox-circle-fill text-4xl text-green-500"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-green-700 tracking-tight">LULUS SELEKSI</h2>
                            <p class="text-green-600/90 text-sm mt-2 font-medium">Selamat! Anda dinyatakan diterima.</p>
                        </div>
                    @elseif($status === 'ditolak')
                         <div class="bg-red-50 border border-red-100 rounded-2xl p-6 text-center w-full">
                            <i class="ri-close-circle-fill text-5xl text-red-500 mb-3 inline-block shadow-sm rounded-full bg-white"></i>
                            <h2 class="text-2xl font-bold text-red-700 tracking-tight">TIDAK LULUS</h2>
                            <p class="text-red-600/90 text-sm mt-1 font-medium">Mohon maaf, Anda belum berhasil.</p>
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 text-center w-full">
                            <i class="ri-time-fill text-5xl text-gray-400 mb-3 inline-block"></i>
                            <h2 class="text-2xl font-bold text-gray-700 tracking-tight">MENUNGGU HASIL</h2>
                            <p class="text-gray-500 text-sm mt-1 font-medium">Pengumuman akan segera hadir.</p>
                        </div>
                    @endif
                </div>

                <!-- Primary Action -->
                <div class="space-y-4 pt-2">
                    @if($status === 'diterima')
                        <a href="{{ route('siswa.pdf.penerimaan') }}" target="_blank"
                           class="group relative w-full flex items-center justify-center gap-3 px-6 py-4 bg-gray-900 text-white rounded-xl font-medium shadow-lg shadow-gray-200 hover:bg-gray-800 transition-all transform hover:-translate-y-0.5 overflow-hidden">
                           <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                           <i class="ri-download-cloud-2-fill text-xl"></i> 
                           <span>Unduh Surat Penerimaan</span>
                        </a>
                        <p class="text-xs text-center text-gray-400 font-medium">Dokumen ini wajib dibawa saat daftar ulang</p>
                    @elseif($status === 'ditolak')
                        <a href="{{ route('siswa.dashboard') }}" class="block w-full text-center py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition-colors font-medium text-sm">
                            Kembali ke Dashboard
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Security Footer -->
            <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
                <div class="flex items-center justify-center gap-2 opacity-60">
                    <i class="ri-shield-keyhole-line text-gray-400"></i>
                    <span class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Digitally Signed & Verified</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@script
<script>
    $wire.watch('isOpen', (value) => {
        if (value && @js($status === 'diterima')) {
            setTimeout(() => {
                var duration = 3 * 1000;
                var animationEnd = Date.now() + duration;
                var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

                var random = function(min, max) { return Math.random() * (max - min) + min; }

                var interval = setInterval(function() {
                    var timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    var particleCount = 50 * (timeLeft / duration);
                    confetti(Object.assign({}, defaults, { particleCount, origin: { x: random(0.1, 0.3), y: Math.random() - 0.2 } }));
                    confetti(Object.assign({}, defaults, { particleCount, origin: { x: random(0.7, 0.9), y: Math.random() - 0.2 } }));
                }, 250);
            }, 600);
        }
    });
</script>
@endscript
