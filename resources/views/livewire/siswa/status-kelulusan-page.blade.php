<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-100 relative overflow-hidden">
    
    <!-- Background Decor (Circles) -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute top-0 right-0 w-64 h-64 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-64 h-64 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

    <!-- Main Container -->
    <div x-data="{ open: @entangle('isOpen') }" class="relative w-full max-w-2xl z-10">
        
        <!-- CLOSED ENVELOPE (Click to Open) -->
        <div x-show="!open" 
             @click="$wire.toggleOpen()"
             class="cursor-pointer transform transition-all duration-500 hover:scale-105 hover:-rotate-1"
             x-transition:leave="transition ease-in duration-500 transform"
             x-transition:leave-end="opacity-0 scale-75 translate-y-full">
            
            <div class="relative bg-gradient-to-br from-yellow-400 via-amber-500 to-amber-600 rounded-lg shadow-2xl p-1 border-4 border-yellow-200/50">
                <!-- Flap Pattern -->
                <div class="absolute top-0 inset-x-0 h-32 bg-white/20 clip-path-triangle"></div>
                
                <div class="bg-white/10 backdrop-blur-sm rounded p-8 md:p-12 text-center border border-white/20">
                    <div class="w-24 h-24 bg-white rounded-full mx-auto flex items-center justify-center shadow-lg mb-6 ring-4 ring-white/30">
                        <img src="{{ asset('assets/logo.png') }}" class="w-16 h-16 object-contain" alt="Logo">
                    </div>
                    
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-white mb-2 drop-shadow-md">HASIL SELEKSI</h2>
                    <p class="text-yellow-100 tracking-widest uppercase font-semibold text-sm">Penerimaan Peserta Didik Baru</p>

                    <div class="mt-10">
                         <button class="bg-white text-amber-600 px-8 py-3 rounded-full font-bold shadow-lg hover:bg-yellow-50 transition flex items-center mx-auto gap-2">
                            <!-- SVG Mail Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                            Buka Amplop
                         </button>
                    </div>
                </div>

                <!-- Wax Seal -->
                <div class="absolute top-1/2 right-4 md:-right-6 transform -translate-y-1/2 w-20 h-20 bg-red-700 rounded-full border-4 border-red-800 shadow-xl flex items-center justify-center">
                    <span class="text-white font-serif font-bold text-xl opacity-80">RESMI</span>
                </div>
            </div>
        </div>

        <!-- OPENED LETTER -->
        <div x-show="open" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-1000 delay-300"
             x-transition:enter-start="opacity-0 translate-y-32 scale-90"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="bg-white rounded-lg shadow-2xl relative overflow-hidden min-h-[600px] border border-gray-200">
            
            <!-- Confetti Canvas -->
            @if($status === 'diterima')
            <canvas id="confetti" class="absolute inset-0 pointer-events-none z-0"></canvas>
            @endif

            <!-- Decor Headers -->
            <div class="h-2 bg-gradient-to-r from-blue-600 via-red-600 to-yellow-500"></div>

            <div class="p-8 md:p-12 relative z-10 text-center">
                <!-- Letterhead -->
                <div class="mb-8 border-b-2 border-double border-gray-200 pb-6">
                    <img src="{{ asset('assets/logo.png') }}" class="w-20 h-20 mx-auto mb-4">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900 font-serif text-center uppercase">{{ $schoolName }}</h1>
                    <p class="text-gray-500 text-sm">{{ $register_setting->alamat ?? 'Kab. Bandung Barat, Kec. Cikalong Wetan, Desa Cisomang Barat' }}</p>
                </div>

                <!-- Body -->
                <div class="space-y-6 text-gray-700">
                    <p class="text-lg">Halo, <span class="font-bold text-black">{{ $user->name }}</span> ({{ $user->username ?? 'Calon Siswa' }})</p>
                    <p>Berdasarkan hasil verifikasi berkas dan tes seleksi yang telah dilakukan, kami memutuskan bahwa Status Pendaftaran Anda adalah:</p>

                    <!-- Status Box -->
                    <div class="py-8 my-6 rounded-xl border-2 {{ $status === 'diterima' ? 'bg-green-50 border-green-200' : ($status === 'ditolak' ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200') }}">
                        @if($status === 'diterima')
                            <div class="flex flex-col items-center animate-pulse-slow">
                                <!-- SVG Check -->
                                <svg class="w-16 h-16 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-2xl md:text-4xl font-extrabold text-green-700 uppercase tracking-wider">Lulus Seleksi / Diterima</span>
                            </div>
                        @elseif($status === 'ditolak')
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-2xl md:text-4xl font-extrabold text-red-700 uppercase tracking-wider">Tidak Lulus</span>
                            </div>
                        @else
                             <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-2xl md:text-4xl font-extrabold text-gray-600 uppercase tracking-wider">Sedang Diproses</span>
                            </div>
                        @endif
                    </div>

                    @if($status === 'diterima')
                        <p>Selamat bergabung! Langkah selanjutnya adalah melakukan daftar ulang. Silakan unduh bukti penerimaan di bawah ini.</p>
                        <a href="{{ route('siswa.pdf.penerimaan') }}" target="_blank" class="mt-4 inline-flex items-center px-6 py-4 bg-green-600 text-white rounded-lg font-bold shadow hover:bg-green-700 transition">
                             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                             Download Surat Penerimaan
                        </a>
                    @elseif($status === 'ditolak')
                        <p>Jangan patah semangat. Kesuksesan menanti Anda di tempat lain. Terima kasih telah berpartisipasi.</p>
                        <a href="{{ route('siswa.dashboard') }}" class="inline-block mt-4 text-gray-600 font-medium underline">Kembali ke Dashboard</a>
                    @else
                        <p>Mohon menunggu hasil resmi yang akan diumumkan sesuai jadwal.</p>
                        <a href="{{ route('siswa.dashboard') }}" class="inline-block mt-4 text-gray-600 font-medium underline">Kembali ke Dashboard</a>
                    @endif
                </div>
            </div>
            
             <div class="bg-gray-50 border-t border-gray-100 p-4 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Lemdiklat Taruna Nusantara Indonesia. Dokumen ini sah dan dilindungi undang-undang.
            </div>
        </div>

    </div>
</div>

{{-- Inline script for confetti --}}
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@script
<script>
    $wire.watch('isOpen', (value) => {
        if (value && @js($status === 'diterima')) {
            setTimeout(() => {
                var duration = 3000;
                var animationEnd = Date.now() + duration;
                var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };
                var random = function(min, max) { return Math.random() * (max - min) + min; }
                var interval = setInterval(function() {
                    var timeLeft = animationEnd - Date.now();
                    if (timeLeft <= 0) return clearInterval(interval);
                    var particleCount = 50 * (timeLeft / duration);
                    confetti(Object.assign({}, defaults, { particleCount, origin: { x: random(0.1, 0.3), y: Math.random() - 0.2 } }));
                    confetti(Object.assign({}, defaults, { particleCount, origin: { x: random(0.7, 0.9), y: Math.random() - 0.2 } }));
                }, 250);
            }, 500);
        }
    });
</script>
@endscript
