<div class="min-h-screen -m-6 flex items-center justify-center p-4 relative overflow-hidden"
     style="background: radial-gradient(circle at center, #f0fdf4 0%, #dcfce7 40%, #bbf7d0 100%);">
    
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-5" 
         style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
    </div>

    <!-- Envelope Container -->
    <div x-data="{ open: @entangle('isOpen') }" class="relative z-10 w-full max-w-lg" style="perspective: 1000px;">
        
        <!-- Closed Envelope -->
        <div x-show="!open" 
             @click="$wire.toggleOpen()"
             class="cursor-pointer transform transition-all duration-500 hover:scale-105"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 rotate-0 scale-100"
             x-transition:leave-end="opacity-0 rotate-180 scale-50">
            
            <div class="bg-gradient-to-br from-yellow-50 to-amber-100 rounded-xl shadow-2xl p-8 relative border-2 border-amber-200">
                <!-- Envelope Flap Design -->
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-amber-200/50 to-transparent rounded-t-xl pointer-events-none"></div>
                
                <div class="text-center space-y-6 py-12 border-4 border-double border-amber-300 rounded-lg m-2">
                    <div class="w-24 h-24 bg-white rounded-full mx-auto flex items-center justify-center shadow-md border-2 border-amber-400">
                        <img src="{{ asset('assets/logo.png') }}" class="w-16 h-16 object-contain">
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-2xl font-serif font-bold text-amber-900 tracking-wide">PENGUMUMAN SELEKSI</h2>
                        <h3 class="text-amber-800 font-medium tracking-widest text-sm uppercase">Penerimaan Peserta Didik Baru</h3>
                    </div>
                    
                    <div class="animate-bounce mt-8">
                        <span class="inline-block px-4 py-2 bg-amber-600 text-white rounded-full text-sm font-semibold shadow-lg">
                            <i class="ri-mail-open-line mr-2"></i>Klik untuk membuka
                        </span>
                    </div>
                </div>

                <!-- Wax Seal -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-red-700 rounded-full shadow-lg border-4 border-red-800 flex items-center justify-center z-10">
                    <div class="w-16 h-16 border-2 border-red-400 rounded-full flex items-center justify-center border-dashed opacity-50 absolute"></div>
                    <span class="text-white font-serif font-bold text-2xl drop-shadow-md">TN</span>
                </div>
            </div>
        </div>

        <!-- Opened Letter -->
        <div x-show="open" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-700 delay-300"
             x-transition:enter-start="opacity-0 translate-y-20 scale-90"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="bg-white rounded-xl shadow-2xl overflow-hidden relative border border-gray-200">
            
            <!-- Confetti Canvas -->
            @if($status === 'diterima')
            <canvas id="confetti" class="absolute inset-0 pointer-events-none z-0"></canvas>
            @endif

            <div class="relative z-10 p-8 text-center space-y-6">
                <!-- Header -->
                <div class="border-b border-gray-100 pb-6 relative">
                    <div class="absolute top-0 right-0">
                         <button wire:click="toggleOpen" class="text-gray-400 hover:text-gray-600 transition">
                            <i class="ri-close-circle-line text-2xl"></i>
                         </button>
                    </div>
                    <img src="{{ asset('assets/logo.png') }}" class="w-20 h-20 mx-auto mb-4">
                    <h3 class="text-xl font-bold text-gray-900">LEMDIKLAT TARUNA NUSANTARA</h3>
                    <p class="text-sm text-gray-500 uppercase tracking-widest mt-1">Surat Keputusan Hasil Seleksi</p>
                </div>

                <!-- Content -->
                <div class="py-2">
                    <p class="text-gray-600">Halo <span class="font-bold text-gray-800">{{ $user->name }}</span>,</p>
                    <p class="text-gray-600 mt-2">Berdasarkan hasil seleksi administrasi dan akademik, kami sampaikan bahwa status pendaftaran Anda adalah:</p>
                    
                    <div class="text-3xl font-bold font-serif my-8 py-6 px-4 rounded-xl shadow-inner border
                        {{ $status === 'diterima' ? 'bg-green-50 text-green-700 border-green-200' : 
                           ($status === 'ditolak' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-gray-50 text-gray-700 border-gray-200') }}">
                        @if($status === 'diterima')
                            <div class="flex flex-col items-center gap-2">
                                <i class="ri-checkbox-circle-fill text-4xl mb-2"></i>
                                <span>LULUS SELEKSI</span>
                            </div>
                        @elseif($status === 'ditolak')
                            <div class="flex flex-col items-center gap-2">
                                <i class="ri-close-circle-fill text-4xl mb-2"></i>
                                <span>TIDAK LULUS</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center gap-2">
                                <i class="ri-time-fill text-4xl mb-2"></i>
                                <span>DALAM PROSES</span>
                            </div>
                        @endif
                    </div>

                    @if($status === 'diterima')
                    <div class="bg-green-50 p-4 rounded-lg text-sm text-green-800 mb-6">
                         <p class="font-semibold mb-1">Selamat bergabung!</p>
                         <p>Silakan unduh Surat Penerimaan Resmi di bawah ini sebagai dokumen daftar ulang.</p>
                    </div>
                    @elseif($status === 'ditolak')
                        <p class="text-gray-600 text-sm">Terima kasih telah mengikuti proses seleksi. Tetap semangat dan jangan menyerah untuk menggapai cita-cita.</p>
                    @else
                        <p class="text-gray-600 text-sm">Hasil seleksi Anda sedang dalam proses verifikasi akhir. Mohon cek kembali secara berkala.</p>
                    @endif
                </div>

                <!-- Footer / Actions -->
                <div class="pt-6 border-t border-gray-100">
                    @if($status === 'diterima')
                        <a href="{{ route('siswa.pdf.penerimaan') }}" target="_blank"
                           class="flex items-center justify-center w-full py-4 px-6 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 transition transform hover:-translate-y-1">
                           <i class="ri-download-cloud-2-line mr-2 text-xl"></i> Download Surat Penerimaan
                        </a>
                    @else
                        <a href="{{ route('siswa.dashboard') }}" 
                           class="inline-block py-2 px-4 text-gray-500 hover:text-gray-700 transition">
                           Kembali ke Dashboard
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Secure Pattern Bottom -->
            <div class="h-3 bg-gradient-to-r from-blue-600 via-yellow-500 to-red-600"></div>
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
