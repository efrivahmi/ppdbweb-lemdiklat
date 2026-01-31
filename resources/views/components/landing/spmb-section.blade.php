<section class="py-20 bg-zinc-50 relative overflow-hidden" x-data="{ shown: false }" x-intersect.once="shown = true">
    {{-- Artistic Background Elements --}}
    <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(#84cc16_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-lime-200/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 translate-y-1/3 translate-x-1/3 w-[600px] h-[600px] bg-emerald-200/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/50 relative group">
            <div class="grid lg:grid-cols-2 gap-0 relative">
                
                {{-- Left Side: Content --}}
                <div class="p-10 lg:p-16 flex flex-col justify-center relative z-20 transition-all duration-700 delay-100 ease-out transform"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                    
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-lime-50 border border-lime-100 rounded-full w-fit mb-8 animate-pulse-slow">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-lime-500"></span>
                        </span>
                        <span class="text-xs font-bold uppercase tracking-wider text-lime-700">Pendaftaran Dibuka</span>
                    </div>

                    <h2 class="text-4xl lg:text-5xl font-bold text-zinc-900 mb-6 leading-[1.15]">
                        Sistem Penerimaan <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-600 to-emerald-600">Murid Baru (SPMB)</span>
                    </h2>

                    <p class="text-lg text-zinc-600 mb-10 leading-relaxed">
                        Bergabunglah dengan Lemdiklat Taruna Nusantara Indonesia dan jadilah bagian dari generasi pemimpin masa depan. Proses seleksi yang transparan, modern, dan terintegrasi menanti Anda.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="/spmb" 
                           class="group/btn relative px-8 py-4 bg-zinc-900 text-white font-bold rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                            <div class="absolute inset-0 bg-gradient-to-r from-lime-500 to-emerald-600 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300 ease-out"></div>
                            <span class="relative flex items-center gap-3">
                                Lihat Informasi SPMB
                                <x-lucide-arrow-right class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" />
                            </span>
                        </a>
                        
                        <a href="/panduan" 
                           class="px-8 py-4 bg-white border-2 border-zinc-100 text-zinc-700 font-bold rounded-xl hover:bg-zinc-50 hover:border-zinc-200 transition-all duration-300">
                            Panduan Pendaftaran
                        </a>
                    </div>

                    {{-- Stats / Features --}}
                    <div class="mt-12 pt-8 border-t border-zinc-100 grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-3xl font-bold text-zinc-900 mb-1">100%</p>
                            <p class="text-sm text-zinc-500 font-medium">Digital & Terintegrasi</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-zinc-900 mb-1">24/7</p>
                            <p class="text-sm text-zinc-500 font-medium">Layanan Informasi</p>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Visual/Image --}}
                <div class="relative min-h-[400px] lg:min-h-full bg-zinc-100 overflow-hidden group/image">
                    {{-- Abstract Shapes --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-lime-500/10 to-emerald-500/10 z-10"></div>
                    
                    {{-- Placeholder Image / Illustration --}}
                    {{-- Using a sophisticated gradient pattern since we might not have a specific 'SPMB' image ready, 
                         or using a placeholder if available. For "Modern Classy", abstract is safe. --}}
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center transition-transform duration-1000 ease-out group-hover/image:scale-110 grayscale-[20%] group-hover/image:grayscale-0"></div>
                    
                    {{-- Overlay Gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/50 to-transparent mix-blend-multiply"></div>
                    
                    {{-- Floating Card Effect --}}
                    <div class="absolute bottom-10 left-10 right-10 z-20 p-6 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/50 transform translate-y-4 group-hover/image:translate-y-0 opacity-0 group-hover/image:opacity-100 transition-all duration-500">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-lime-100 flex items-center justify-center text-lime-600">
                                <x-lucide-check-circle class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-900">Seleksi Berbasis Kompetensi</p>
                                <p class="text-xs text-zinc-500">Mencari bakat terbaik dari seluruh negeri</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
